<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Dashboard Model
 * Used by the Dashboard library to populate the dashboard view.
 * Without this file, the exiting module will not list contents in the dashboard.
 * 
 * Model should return an array of objects, and include 'helper', and 'title'
 * properties for the dashboard helper.
 *
 * /application/modules/pages/models/
 *
 */
class Pages_dashboard_model extends MY_Model {
	
	var $_table = 'mc_content';
	var $_page_type = 'page';
	var $_helper = 'list_parent_kids';
	var $_heading = 'Pages';
	
	public function __construct() {
		$this->init();
	}
	
	public function init() {
		$data = $this->db->where('page_type',$this->_page_type)->get($this->_table);
		if($data->num_rows() > 0)
		{
			$this->_results = $data->result();
		}
		$this->view->pods->pages = $this;
		return $this->view->pods->pages;
	}

} // End class