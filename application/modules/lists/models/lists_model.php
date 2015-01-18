<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lists_model extends MY_Model {

    public function index($type,$all=false)
    {
        $id=null;
        $query = $this->db->where('url', $this->uri->segment(1))
            ->limit(1)
            ->get('mc_content');
        if($query->num_rows() > 0) {
            $id = $query->row()->id;
        }
        if($id) {
            $query = $this->db->where('parent_id', $id)
                ->order_by('id', 'desc')
                ->order_by('sort')
                ->get('mc_content');
            if ($query->num_rows() > 0) {
                $results = $query->result_array();
                //            rsort($results);
                return $results;
            } else {
                return array();
            }
        }
    }

    public function indexX($url=NULL, $segment2=NULL) {
        if(!empty($url)) {
            // Try to get the page
            $query = $this->db->where('url', $url)->where('parent_id',null)->get('mc_content');
            if($query->num_rows()>0) {
                if(!empty($segment2)) {
                $query = $this->db->where('url', $segment2)->where('parent_id',$query->row()->id)->get('mc_content');
                    if($query->num_rows()==0) {
                        show_404();
                    }
                }
            } else {
                show_404();
            }
        return $query->row();
        }
    }

    public function get_by_title($title=null) {
    	$query = $this->db->where('title',$title)->limit(1)->get('mc_content');
    	if($query->num_rows() > 0) {
    		$item = $query->row();
    		$query = $this->db->where('parent_id',$query->row()->id)->limit(1)->get('mc_content');
    		$item->kid = $query->row();
    		return $item;
    	}
    }

    public function contact_form() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('themsg', 'Message', 'callback_themsg_msg');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', 'Required Field');
        $this->form_validation->set_message('valid_email', 'Invalid Address');
        $this->form_validation->set_error_delimiters('<span class="error">', '</label>');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            $this->send_email();
        }
    }

// End contact_form

    public function send_email() {
        $email_settings = $this->get_email_settings();
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $reply_to = $_POST['email'];

        $this->load->library('email');

        $this->email->from($email_settings->from);
        $this->email->to($email_settings->to); // Can be comma delimited $this->email->to('email','email','email');
        $this->email->reply_to($_POST['email']/* , $_POST['name'] */);

        $this->email->subject('Message from the site');
        $this->email->message('<html><body><p>Name: ' . $this->input->post('name') . '<br>Email: ' . $this->input->post('email') . '</p><p>' . $this->input->post('themsg') . '</p></body></html>');

        if ($this->input->post('last_name') == '') { // DOM has been manipulated by the client.
            $this->email->send();
            header("Location:/contact/");
            $this->session->set_flashdata('success', TRUE);
        }
    }

// End send_email

    public function get_partials_by_id($id) {
        $query = $this->db
                    ->select('meta_value')
                    ->where('meta_key', '_afterbody_partial')
                    ->where('post_id',$id)->order_by('meta_sort asc')
                    ->get('contentmeta');
    	//debug::dump($this->db->last_query());
        if($query->num_rows() > 0) {
        	return $query->result_array();
        }
//        if($query->num_rows()>1) {
//        	debug::dump($query->result());
//        	foreach($query->result() as $k=>$v) {
//	        	debug::dump($k.'=>'.$v);
//        	}
//        	exit;
//        	return $row;
 //       }
    }
    public function get_email_settings() {
        $email_settings = new stdClass();
        $values = array('form_contact_from','admin_email');
        $query = $this->db->select('option_value')->where_in('option_name', $values)->get('options');
        $email_settings->to = $query->row(0)->option_value;
        $email_settings->from = $query->row(1)->option_value;
        $query->free_result();
        return $email_settings;
    }

// End get_email_settings
	public function themsg_msg($str) {
            if ($str == '') {
                    $this->form_validation->set_message('themsg_msg', 'Come on now. What\'s on your mind?');
                    return false;
            } else {
                    return true;
            }
	}
}

// End Frontend_model class */