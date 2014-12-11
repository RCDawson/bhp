<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * MY_Model
 *
 */

/*
 * @todo Get rid of this model ?
*/

class MY_Model extends CI_Model {
    
    public function get_site_options() {
        $options = $this->db->select('option_name,option_value')->get('options');
        foreach($options->result_array() as $config) {
			$this->config->set_item($config['option_name'],$config['option_value']);
        }
        $data->settings = (object) $this->config->config;
        return $data;
    }
    
    public function get_site_name() {
    	$this->get_site_options();
	   	if($this->config->item('site_name')) {
	    	return $this->config->item('site_name').' : ';
	    } else {
	    	return '';
	    }
    }

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
//    function __call($method, $args) {
//        if( method_exists($this, "_$method") ) return call_user_func_array(array($this, "_$method"), $args);
//
//        return;
//    }

    // --------------------------------------------------------------------

    /**
     * Delete Entry - Generic
     *
     * Delete entry, not true deletion. Update entry deleted field to
     * current time.
     *
     * @access	public
     * @param	int         id of entry
     * @return	boolean
     */
//    function delete($id) {
//        if( !$id ):
//            log_message('error', 'id not supplied');
//            return FALSE;
//        endif;
//
//        $data->deleted = date('Y-m-d H:i:s');
//        $this->db->where('id', $id);
//        $this->db->update($this->_table, $data);
//
//        return TRUE;
//    }

    // --------------------------------------------------------------------

    /**
     * Get Error
     *
     * returns error if problems with any methods
     *
     * @access	public
     * @return	string		error string for instance
     */
//    function error() {
//        return $this->_error;
//    }

    // --------------------------------------------------------------------

    /**
     * Check Database Fields
     *
     * Check if postdata field is in database, if so return new object with
     * only fields that exists in database;
     *
     * @access	public
     * @param	object		posted data
     * @return	object		data object of accepted data
     */

    function fields_in_db($postdata,$table) {
        $fields = $this->db->list_fields($table);

        foreach($postdata as $key => $value):
            if(in_array($key, $fields)) $data->{$key} = $value;
        endforeach;

        return $data;
    }

    // --------------------------------------------------------------------

    /**
     * Get Entry
     *
     * Get entry details, encase custom sql in an array ie. array('sql')
     *
     * @access	public
     * @param	mixed		id or data to filter by
     * @return	mixed		result entry(s)
     */
    function gets($arg) {
        if( !$arg ):
            log_message('error', 'parameter not supplied');
            return FALSE;
        endif;

        $this->db->select('*');

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

        if($this->db->field_exists('created', $this->_table) ) $this->db->select("DATE_FORMAT(created, '%b %e, %Y') as created_formatted", FALSE);

        $this->db->where('deleted', NULL);
        $query = $this->db->get($this->_table);

        $length = $query->num_rows();

        if( $length == 0 ) return FALSE;

        if( $length == 1 ) return $query->row();

        if( $length > 1 ) return $query->result();
    }

    // --------------------------------------------------------------------

    /**
     * Insert Entry
     *
     * Insert entry with supplied data.
     *
     * @access	public
     * @param	object		data to be inserted
     * @return	int			id of newly inserted entry
     */
    function insert($data) {
        if( !$data ):
            log_message('error', 'data not supplied');
            return FALSE;
        endif;

        if ( $this->db->field_exists('created', $this->_table) ) $data->created = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $data);
        $id = $this->db->insert_id();
        unset($data);

        return $id;
    }

    // --------------------------------------------------------------------

    /**
     * List Entries
     *
     * List all active entry.
     *
     * @access	public
     * @return	array		result entries
     */
    function _list() {
        if($this->db->field_exists('title', $this->_table) ) $this->db->order_by('title');

        if ( $this->db->field_exists('deleted', $this->_table) ) $this->db->where('deleted', NULL);
        $query = $this->db->get($this->_table);

        $this->_revert_table();

        if( $query->num_rows() == 0 ) return FALSE;

        return $query->result();
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
    function revert_table() {
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
    function swap_table($table) {
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
     * @param	int			id of entry
     * @param	object		data being updated
     * @return	object		data that was updated
     */
/*    function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->_table, $data);
        return $data;
    }
*/

    /*
         *  Join Sys_Users and Contact_Info on ID and return object
    */

    public function company_info($id=1)
    {
        $query = $this->db->where('sys_users_id',$id)->get('contact_info');
        if($query->num_rows() > 0)
        {
        	$data = $query->row();
        	return $data;
        }
    }


    public function get_user($all=false) {
        $query = $this->db
                ->select('id,role,username,email,first_name,last_name,created')
                ->where('id',$this->session->userdata('uid'))
                ->get('sys_users');
        return $query->row();
    }

    public function edit($url) {
        $query = $this->db
                ->where('url',$url)
                ->get('mc_content');
        return $query->row();
    }
    
	// Return one table cell or one row from the contentmeta table
	public function get_meta_by($col,$val,$as_row=true) {
		if($as_row) {
			$row = $this->db->where($col,$val)->limit(1)->get('contentmeta');
		} else {
			$row = $this->db->where($col,$val)->get('contentmeta');
		}
		// Row or rows coming back?
		if($row->num_rows() > 0 && $row->num_rows() < 2) {
			$row = $row->row();
			return $row;
		} else {
			$row = $row->result();
			return $row;
		}
	}
	public function get_sidebar_by_id($id) {
		$object = $this->db->where('post_id',$id)->where('meta_key','sidebar')->get('contentmeta');
	}
    public function get_page_sidebars($url=null) {
        if(!empty($url)) {
            $query = $this->db
                        ->select('*')
                        ->from('mc_content')
                        ->join('contentmeta', 'contentmeta.post_id = mc_content.id')
                        ->where('contentmeta.meta_value',$url)
                        ->order_by('contentmeta.meta_sort')
                        ->get();
            //Debug::dump($this->db->last_query());exit;
            return $query->result();
        }
    }
    
    public function get_contentmeta($meta_key) {
        $query = $this->db
                    ->select('mc_content.url,contentmeta.meta_value as "link_text"')
                    ->from('mc_content')
                    ->join('contentmeta', 'contentmeta.post_id = mc_content.id')
                    ->where('contentmeta.meta_key',$meta_key)
                    ->order_by('contentmeta.meta_sort')
                    ->get();
        //Debug::dump($this->db->last_query());exit;
        //Debug::dump($query->result());exit;
        return $query->result();
        
//        $query = $this->db->where_in('meta_key', $meta_name)->order_by('meta_sort asc')->get('contentmeta');
//        return $query->result();
    }

}

/* End of file MY_Model.php */
/* Location: core/MY_Model.php */