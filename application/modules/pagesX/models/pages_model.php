<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {

	protected $_table = 'mc_content';

	function __construct()
	{
		parent::__construct();
		/* From MY_model */
		$this->_app_config = $this->config->item('app');
		
		if( !isset($this->_table) ):			
			log_message('error', 'table not specified');
		endif;
		/******/
	}

	public function get_all($page_type) {
		$query = $this->db->select('id, title, url')->where('page_type',$page_type)->where('parent_id',null)->order_by('sort, title asc')->get($this->_table);
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}

	public function get($arg)
	{
		if( !$arg ):			
			log_message('error', 'parameter not supplied');
			return FALSE;
		endif;
		
		$this->db->select($this->_table . '.*');
		//$this->db->select("DATE_FORMAT(date, '%b.%e.%Y') as date_formatted", FALSE);
		
		if( is_numeric($arg) ):
			$this->db->where('id', $arg);
		else:
			foreach( $arg as $key => $value ):				
				if( is_array($value) ):
					$this->db->where($value[0], NULL, FALSE);
					continue;
				endif;			
				$this->db->where($key, $value);
			endforeach;
		endif;
		
		//$this->db->where('deleted', NULL);
		$query = $this->db->get($this->_table);
		
		if( $query->num_rows() == 0 ) return FALSE;
		
		return $query->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Page by URL
	 *
	 * Return page based of type and url
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	public function get_by_url($type, $url)
	{	
		$this->db->where('url', $url);
		$this->db->where('type', $type);
		$this->db->where('deleted', NULL);
		$query = $this->db->get($this->_table);
		
		if( $query->num_rows() == 0 ) return FALSE;		
		$row = $query->row();		
		return $row;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Pages Organized by Category
	 *
	 * Return pages by types organized by category
	 *
	 * @access	public
	 * @param	string
	 * @return	array
	 */
	public function get_categorized($type)
	{
		if( !$type ):			
			log_message('error', '[page:get_landing] missing parameter');
			return FALSE;
		endif;
		
		$this->db->select($this->_table . '.*');
		$this->db->select('pages_categories.*, categories.title as `category_title`');
	
		$this->db->join('pages_categories', 'page_id = ' . $this->_table . '.id', 'inner');
		$this->db->join('categories', 'category_id = categories.id', 'left');
		
		$this->db->where($this->_table . '.type', $type);
		$this->db->where($this->_table . '.parent_id', NULL);
		$this->db->where($this->_table . '.deleted', NULL);
		$query = $this->db->get($this->_table);
		
		if( $query->num_rows() == 0 ) return FALSE;		
		$rows = $query->result();		
		$results = array();
		
		foreach( $rows as $row ):		
			if( !isset($results[$row->category_id]) ) $results[$row->category_id] = array();			
			array_push($results[$row->category_id], $row);		
		endforeach;
		
		return $results;	
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Landing Page
	 *
	 * Return the landing page of specified type
	 *
	 * @access	public
	 * @param	string
	 * @return	object
	 */
	public function get_landing($type)
	{
		if( !$type ):			
			log_message('error', '[page:get_landing] missing parameter');
			return FALSE;
		endif;
		
		$this->db->where('type', $type);
		$this->db->where('parent_id', NULL);
		$this->db->where('deleted', NULL);
		$query = $this->db->get($this->_table);
		
		if( $query->num_rows() == 0 ) return FALSE;		
		$row = $query->row();		
		return $row;	 
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * List Entries
	 *
	 * List all active entry. 
	 *
	 * @access	public
	 * @return	array
	 */
	public function _list()
	{
		$this->db->where('deleted', NULL);
		$this->db->where('landing', 1);
		$this->db->order_by('title', 'asc');
		$query = $this->db->get($this->_table);
		
//		$this->_revert_table();
		
		if( $query->num_rows() == 0 ) return FALSE;
		
		return $query->result();
	}
	 
	// --------------------------------------------------------------------
	
	/**
	 * Get Pages by Type
	 *
	 * Return the pages of specified type
	 *
	 * @access	public
	 * @param	string
	 * @return	object
	 */
	public function list_by_type($type, $limit = NULL, $offset = 0)
	{
		if( !$type ):			
			log_message('error', '[page:_list] missing parameter');
			return FALSE;
		endif;	
		
		$this->db->select($this->_table . '.*');
		$this->db->select("DATE_FORMAT(date, '%b.%e.%Y') as date_formatted", FALSE);
		$this->db->select("DATE_FORMAT(date, '%Y/%m/%d') as date_url", FALSE);
		
		$this->db->where('type', $type);
		$this->db->where('parent_id IS NOT NULL');
		$this->db->where('deleted', NULL);
		
		$this->db->order_by('date', 'DESC');
		$this->db->order_by('ABS(`order`)', NULL, FALSE);
		
		if( $limit ) $this->db->limit($limit, $offset);
				
		$query = $this->db->get($this->_table);		
		
		if( $query->num_rows() == 0 ) return FALSE;		
		$rows = $query->result();		
		return $rows;		
	}
	/**/ 
	protected $_app_config;
	protected $_error;
	protected $_table_org;
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Call Method
	 *
	 * If method is not found try call _method, used for php function
	 * name conflicts i.e.( list )
	 *
	 * @access	public
	 * @param	string
	 * @param	mixed	
	 * @return	void
	 */
	public function __call($method, $args)
	{
		if( method_exists($this, "_$method") ) return call_user_func_array(array($this, "_$method"), $args);
		
		return;
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * Delete Entry - Generic
	 *
	 * Delete entry, not true deletion. Update entry deleted field to
	 * current time.
	 *
	 * @access	public
	 * @param	int	
	 * @return	boolean
	 */
	function delete($id)
	{
		if( !$id ):			
			log_message('error', 'id not supplied');		
			return FALSE;
		endif;
		
		$data->deleted = date('Y-m-d H:i:s');
		$this->db->where('id', $id);
		$this->db->update($this->_table, $data);
		
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get Error
	 *
	 * returns error if problems with any methods
	 *
	 * @access	public
	 * @return	string
	 */
	public function error()
	{
		return $this->_error;
	}	
	
	// --------------------------------------------------------------------
	
	/**
	 * Check Database Fields
	 *
	 * Check if postdata field is in database, if so return new object with
	 * only fields that exists in database;
	 *
	 * @access	public
	 * @param	object
	 * @return	object
	 */
	 
	function fields_in_db($postdata)
	{
		if( !$postdata ):			
			log_message('error', 'postdata not supplied');
			return FALSE;
		endif;
		
		$fields = $this->db->list_fields($this->_table);
		
		foreach($postdata as $key => $value):
			if(in_array($key, $fields)) $data->{$key} = $value;
		endforeach;
		
		return $data;
	}
	
	/**
	 * Insert Entry
	 *
	 * Insert entry based on supplied data. 
	 *
	 * @access	public
	 * @param	object
	 * @return	int
	 */
	function insert($data)
	{
		if( !$data ):
			log_message('error', 'data not supplied');
			return FALSE;
		endif;
			
		$data->created 	= date('Y-m-d H:i:s');
		$this->db->insert($this->_table, $data);
		$id = $this->db->insert_id();
		unset($data);
		
		return $id;
	}	
	
	// --------------------------------------------------------------------
		
	/**
	 * Revert Table
	 *
	 * Revert table to orginal table
	 *
	 * @access	public
	 * @return	void
	 */
	function revert_table()
	{		
		$this->_table = $this->_table_org;		
		$this->_table_org = NULL;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Swap Table
	 *
	 * Swap table for models with multiple tables, will revert after each command
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function swap_table($table)
	{
		if( empty($this->_table_org) ) $this->_table_org = $this->_table;			
		$this->_table = $table;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update Entry
	 *
	 * Update entry data
	 *
	 * @access	public
	 * @param	int
	 * @param	object
	 * @return	object
	 */
	function update($id, $data)
	{
		if( !$id || !$data ):
			log_message('error', 'id or data not supplied');
			return FALSE;	
		endif;
		
		$this->db->where('id', $id);
		$this->db->update($this->_table, $data);	
		
		return $data;
	}
}

/* End of file pages_model.php */
/* Location: modules/pages/models/pages_model.php */