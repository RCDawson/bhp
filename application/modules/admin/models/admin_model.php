<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Admin Model
 * /application/modules/admin/models/admin_model.php
 */

class Admin_model extends MY_Model {

	public function __construct() {
        $data = new stdClass();
		$data->settings = $this->get_site_options();
	}
	
    /**
     *  Admin CRUD
     */
    public function main_form($form_type, $url = null, $childId = null) {
        if ($this->input->post('url')) {
            $_POST['url'] = url_title($this->input->post('url'), 'dash', TRUE);
            if(empty($_POST['active'])) $_POST['active'] = 0;
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($form_type == 'edit_sidebar') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required|callback_be_unique');
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
        }
        $this->form_validation->set_rules('url', 'URL', 'trim|required|callback_be_unique');
        $this->form_validation->set_rules('active', 1);
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            if ($form_type == 'new') {
//                $this->new_user();
            }
            if ($form_type == 'editChild') {
                $this->update_child_page($url,$childId);
            }
            if ($form_type == 'edit' || $form_type == 'edit_sidebar') {
                $this->update_page($url);
            }
            return true;
        }
    }

    /**
     * Determine if $arg is found in array '_uniques'.
     * Used to prevent passing values to fields in DB that hold unique values.
     *
     * @param string $arg
     * @return boolean
     */
    public function be_unique($arg) {
        if (in_array($arg, $this->_uniques)) {
            $this->form_validation->set_message('be_unique', '%s is not available.');
            return false;
        }
        return true;
    }

    public function create($_type)
    {
        if(empty($_POST['url'])) $_POST['url'] = url_title($_POST['title'],'dash',TRUE);
//        Debug::dump($_POST);die;
        $now = date("Y-m-s H:i:s");
        $_POST['published'] = $now;
        $this->db->insert('mc_content', $this->input->post());
        $this->template->_message('New ' . $_type . ' created.','success',current_url());

    }

    public function create_content($_type, $url = null) {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ($_type == 'sidebar') {
            $this->form_validation->set_rules('title', 'Title', 'trim|required|callback_be_unique');
        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
        }
        if ($this->input->post('url')) {
            $this->form_validation->set_rules('url', 'URL', 'trim|required|callback_be_unique');
        }
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            if ($_type == 'page') {
                $this->create($_type);
            }
            if ($_type == 'new') {
//                $this->new_user();
            }
            if ($_type == 'edit' || $_type == 'edit_sidebar') {
//                $this->update($url);
            }
            $this->template->_message('type = ' . $_type);
            return true;
        }
    }

    public function create_option() {
        $this->load->library('forms');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('option_name', 'Setting name', 'trim|required|is_unique[options.option_name]');
        $this->form_validation->set_rules('option_value', 'Setting value', 'trim|required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            $this->db->insert('options', $this->input->post());
        }
    }

    public function editChildPage($childId) {
        $query = $this->db
            ->where('url', $childId)
            ->get('mc_content');
        $result = $query->row();
        if($result && $result->parent_id == null) { show_error('Can not find page'); }
        return $result;
    }

    public function edit_pages($url = NULL) {
        if ($url != NULL) {
            $query = $this->db->query('select *, @parent:=`parent_id` from `mc_content` where `url`="' . $url . '" union select *, parent_id as "extra column for @parent" from `mc_content` where id = @parent');
            if ($query->num_rows() == 0) {
                show_404();
            }
            //OK. We have some content.
            $data = new stdClass();
            $data->page = $query->result();
            // Is it a child of another page
            if (!empty($data->page[1]->url)) {
                // Grab the parent URL and get rid of the parent.
                $data->page[0]->parent_url = $data->page[1]->url;
                unset($data->page[1]);
            }
            // Build the page object
            $data->page = $data->page[0];

            // Does this page have kids?
            $query = $this->db->where('parent_id', $data->page->id)->get('mc_content');
            $data->kids = $query->result();
            return $data;
        } else {
            $query = $this->db->order_by('url asc, parent asc')->get('mc_content');
            return $query->result();
        }
        //Debug::dump($query->num_rows(),'admin_model:37');exit;
    }

    public function update_page($url) {
        /*
                $this->db->set('meta_value', $this->input->post('url'))
                        ->where('meta_value', $this->input->post('orig_url'))
                        ->where('meta_key', 'sidebar')
                        ->update('contentmeta');
        */
        unset($_POST['orig_url']);
        $this->db->where('url', $url)->update('mc_content', $this->input->post());
        header("Location:" . base_url() . 'admin/edit/' . $this->input->post('url'));
        $this->template->_message('Update Successful', 'success');
    }

    public function update_child_page($url,$childId) {
        unset($_POST['orig_url']);
//        Debug::dump($childId);die;
//        Debug::dump($this->input->post('url'));
        $this->db->where('url', $childId)->update('mc_content', $this->input->post());
        header("Location:" . base_url() . 'admin/edit/' . $url . '/' . $this->input->post('url'));
        $this->template->_message('Update Successful', 'success');
    }

    public function delete_view($url) {
        $query = $this->db->select('id,url,title')->where('url', $url)->get('mc_content');
        return $query->row();
    }

    public function delete_by_url($url) {
        $this->db->where('url',$url)->delete('mc_content');
    }

    // End CRUD ---------------------------------------------------------/

/*    public function get_sidebars($url = null) {
        if (empty($url)) {
            $query = $this->db->select('title,url')->where('page_type', 'sidebar')->order_by('sort asc, url asc')->get('mc_content');
            return $query->result();
        } else {
            $query = $this->db->select('title,url,excerpt')->where('page_type', 'sidebar')->order_by('sort asc, url asc')->get('mc_content');
            return $query->row();
        }
    }
*/
	public function get_sidebars() {
		$this->query = $this->db->select('title,url')->where('page_type', 'sidebar')->order_by('sort asc, url asc')->get('mc_content');
		//$query = $this->db->select('title,url')->where('page_type', 'sidebar')->order_by('sort asc, url asc')->get('mc_content');
		//return $query->result();
		$sidebars = '<ul>'."\n\t";
			if($this->query->num_rows() > 0) {
//		debug::dump($sidebars->result_array());exit;
				foreach($this->query->result_array() as $sidebar) {
					$sidebars .= '<li><a href="/admin/edit/' . $sidebar['url'] . '">' . $sidebar['title'] . '</a></li>'."\n";
				}
	        		$sidebars .= '<li><button type="button">Add a Sidebar</button></li>'."\n";
    		} else {
        		$sidebars .= '<li><button type="button">Build a Sidebar</button></li>';
    		}
    	$sidebars .= '</ul>';
		//debug::dump($sidebars2);exit;
	    return $sidebars;
	}
    public function get_sidebar_usage($url = null) {
        if (!empty($url)) {
            $query = $this->db
                    ->select('*')
                    ->from('mc_content')
                    ->join('contentmeta', 'contentmeta.post_id = mc_content.id')
                    ->where('contentmeta.meta_value', $url)
                    ->order_by('contentmeta.meta_sort')
                    ->get();
            //Debug::dump($this->db->last_query());exit;
            return $query->result();
        }
    }

    public function get_parents() {
        $query = $this->db->where('parent_id', null)->where('page_type', 'page')->order_by('sort asc, url asc, parent asc')->get('mc_content');
        return $query->result();
    }

    public function get_kids() {
        $query = $this->db->where('parent_id is not null')->order_by('url asc')->get('mc_content');
        return $query->result();
    }
    
} // End Admin_model