<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media_model extends CI_Model {

	protected $_table 			= 'media';
	protected $_table_joined 	= 'pages_media';	
	protected $_upload_path		= 'application/assets/uploads';

	function __construct()
	{
		parent::__construct();		
			
		$this->load->helper('string');
	}	
		
	// --------------------------------------------------------------------
	
	/**
	 * Insert 
	 *
	 * Insert media based on supplied data. 
	 *
	 * @access	public
	 * @param	object
	 * @param	int
	 * @return	int
	 */
	function insert($data, $page_id)
	{
		if( !$data ):
			log_message('error', 'data not supplied');
			return FALSE;
		endif;
			
		$data->created 	= date('Y-m-d H:i:s');
		$this->db->insert($this->_table, $data);
		$id = $this->db->insert_id();
		unset($data);
		
		$data->page_id = $page_id;
		$data->media_id	= $id;
		$this->db->insert($this->_table_joined, $data);		
		
		return $id;
	}	
	
	// --------------------------------------------------------------------
	
	/**
	 * List by Page
	 *
	 * returns media based on page
	 *
	 * @access	public
	 * @param	int
	 * @return	string
	 */
	public function list_by_page($id)
	{
		if( !$id ):			
			log_message('error', 'id not supplied');		
			return FALSE;
		endif;
		
		$this->db->join($this->_table_joined, $this->_table_joined . '.media_id = ' . $this->_table . '.id', 'inner');
		$this->db->where('page_id', $id);
		$this->db->where($this->_table . '.deleted IS NULL', NULL, FALSE);
		$query = $this->db->get($this->_table);
		
		if( $query->num_rows() == 0 ) return FALSE;
		
		return $query->result();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Upload Item
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public function upload($field_name = 'file', $path = NULL)
	{		
		
		$config['upload_path'] 		= FCPATH . ($path ? $path : $this->_upload_path);
		$config['allowed_types']	= 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);
		
		if( !$this->upload->do_upload($field_name) ):
			$this->_error = $this->upload->display_errors('', '');
			return FALSE;
		endif;		
		
		$filedata =  $this->upload->data();
		
		return $filedata['file_name'];
	}
	 
}