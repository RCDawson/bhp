<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfusion_model extends MY_Model {

    protected $_table = 'mc_content';

    public function index() {
    	$query = $this->db->where('page_type','page')->where('url','transfusion')->get($this->_table);
    	if($query->num_rows() > 0)
    	{
    		$page = $query->row();
    		$page->kids = $this->get_kids($query->row()->id);
    		return $page;
    	}
    }
    
    public function get_kids($id)
    {
		$kids = $this->db->where('page_type','page')->where('parent_id',$id)->order_by('sort, title asc')->get($this->_table);
		if($kids->num_rows() > 0)
		{
			return $kids->result();
		}
    }


    public function edit($id) {
    	echo 'No edit method for blogs';
    }


    /**
     * Update Entry
     *
     * Update entry data
     *
     * @access	public
     * @param	int			id of entry
     * @param	object		data being updated
     * @return	object		data that was updated
     */
    public function update($id, $postdata = NULL) {
        if(!empty($postdata)) {
            $this->db->where('id', $id);
            $this->db->update('authors', $postdata, 'id = '. $id);
            return true;
        }
    }


    public function insert($postdata) {
        $this->db->insert('mc_content',$postdata);
    }


    public function author_form($form_type) {

        $this->form_validation->set_rules('author', 'Author', 'trim|required|callback_uniq_uid');
        $this->form_validation->set_rules('desc_sml', 'desc_sml', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        $this->form_validation->set_error_delimiters('<dd>', '</dd>');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        else {
            $this->authors->insert($postdata);
            return true;
        }
    }


    public function delete($id) {
        $this->db->where('id',$id)->delete('authors');
        $this->template->_message('Author successfully deleted', 'success', 'admin/authors');
    }
}