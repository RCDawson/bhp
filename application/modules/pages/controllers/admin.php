<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Pages CMS Controller
 *
 */

class Admin extends MY_Controller {

	public function __construct()
	{
            parent::__construct();

//            $this->load->model('pages_model','pages');
//            $this->load->model('media_model');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Index
	 *
	 * @access	public
	 * @return	void
	 */
	public function index()
	{
	    //Debug::dump($data);exit;
	    $data->pages = $this->db->
	    	select('id,parent,parent_id,title,url')->
	    	where('page_type','page')->get('mc_content')->result();
// 		$data->rows = $this->pages->_list();
                $this->template
        		->title('Site Content')
        		->build('admin/index', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @return	void
	 */
	public function delete($id, $parent_id)
	{	
		if( !$id || $parent_id == NULL ) $this->template->_message('Invalid request', 'error', 'admin/pages');
		
		if( $this->input->post('action') == 'pages-delete' ):
			$this->pages->delete($id);
 			$this->template->_message('Page also deleted successfully', 'successful');
 			$this->template->_message('Page deleted successfully', 'success', '/admin/pages' . ( $parent_id ? '/manage/' . $parent_id : NULL));
		endif;
	
		$data->row = $this->pages->get($id);
		$data->parent = $parent_id ? $this->pages->get($parent_id) : NULL;
	
		$this->template->title('Delete');
		$this->template->build('admin/delete', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Edit
	 *
	 * @access	public
	 * @param	int
	 * @param	int
	 * @return	void
	 */
	public function edit($id=null, $parent_id = NULL)
	{
		if( !$id ) $this->template->_message('Invalid request', 'error', 'admin/pages');
		
		
		$data->parent = $parent_id ? $this->pages->get($parent_id) : NULL;	
		
		if( $this->input->post('action') == 'pages-edit' ):
		
			$postdata = $this->pages->fields_in_db($this->security->xss_clean($_POST));
			$postdata->url = url_title($postdata->title);
			
 			if($this->input->post('title') == '') {
 				$this->template->_message('Page Title Required.', 'error', current_url());
 			} else {
 				$this->pages->update($id, $postdata);
 				$this->template->_message('Your edits have been made.', 'successful', '/admin/pages' . ( $parent_id ? '/manage/' . $parent_id : NULL));
			}
// 			$this->template->_message('Page deleted successfully', 'success', '/admin/pages' . ( $parent_id ? '/manage/' . $parent_id : NULL));
			
		endif;
	
		$data->row      = $this->pages->get($id);
		$data->media 	= $data->row->media  ? $this->media_model->list_by_page($id) : NULL;
	
                $this->template
                    ->title('Edit Page')
//                    ->title($data->row->title . ': Edit')
//                    ->set_breadcrumb($data->row->title . ': Edit','admin/pages')
                    ->inject_partial('js','<script type="text/javascript" src="/js/plugins/tinymce/scripts/jquery.tinymce.js"></script>')
                    ->build('admin/edit', $data);
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * Insert
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */
	public function insert($parent_id = NULL)
	{		
		if( $this->input->post('action') == 'pages-insert' ):
			$postdata = $this->pages->fields_in_db($this->security->xss_clean($_POST));
			
			if( $parent_id ):
				$parent = $this->pages->get($parent_id);
				$postdata->type = $parent->type;
				$postdata->parent_id = $parent->id;			
			endif;
			
			$postdata->url = url_title($postdata->title);
			
			$this->pages->insert($postdata);
 			$this->template->_message('Page created successfully', 'success', '/admin/pages' . ( $parent_id ? '/manage/' . $parent_id : NULL));
		endif;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Manage
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */
	public function manage($id=NULL)
	{   
		if( !$id ) $this->template->_message('Invalid request', 'error', 'admin/pages');
		
		$data->parent = $this->pages->get($id);
		debug::dump($data->parent);exit;
		$data->rows = $this->pages->list_by_type($data->parent->typeX);
                $this->template
                    ->title('Manage ' . $data->parent->title)
                    ->set_breadcrumb('Site Content', '/admin/pages')
                    ->build('admin/manage', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Media Index
	 *
	 * @access	public
	 * @param	string
	 * @param	int
	 * @param	int
	 * @param	int
	 * @return	void
	 */	
	function media($action, $id, $page_id, $parent_id = NULL)
	{
	
		switch( $action ):
		
			case 'delete':				
				$this->_media_delete($id, $page_id, $parent_id);
				break;
				
			case 'edit':				
				$this->_media_edit($id, $page_id, $parent_id);			
				break;
				
			case 'insert':
				$parent_id 	= $page_id;
				$page_id 	= $id;				
				$this->_media_insert($page_id, $parent_id);
				break;
				
			default:
				$this->template->message('missing parameters', 'error', '/pages');
		
		endswitch;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Media Delete
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */	
	function _media_delete($id, $page_id, $parent_id)
	{
		if( !$id ) $this->template->message('id missing', 'error', '/pages');
		
		if( $this->input->post('action') == 'pages-media-delete' ):			
			$this->media->delete($id);
			$this->template->message('Media deleted successfully', 'success', '/pages/edit/' . $page_id . ($parent_id ? "/$parent_id" : ''));			
		endif;
	
		$data->row 	= $this->media->get($id);
		$data->page 	= $this->pages->get($page_id);
		$data->parent 	= $parent_id ? $this->pages->get($parent_id) : FALSE;
	
		$this->template->set('title', 'Delete Media | Content | ', TRUE);		
		$this->template->load('global', 'media/delete', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Media Edit
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */	
	function _media_edit($id, $page_id, $parent_id)
	{
		if( !$id ) $this->template->message('id missing', 'error', '/pages');
		
		if( $this->input->post('action') == 'pages-media-edit' ):		
			$postdata = $this->media->fields_in_db($this->security->xss_clean($_POST));
			$this->media->update($id, $postdata);			
			$this->template->message('Media updated successfully', 'success', '/pages/edit/' . $page_id . ($parent_id ? "/$parent_id" : ''));			
		endif;
		
		$data->row 		= $this->media->get($id);
		$data->page 	= $this->pages->get($page_id);
		$data->parent 	= $this->pages->get($parent_id);
	
		$this->template->set('title', 'Edit Media | Content | ', TRUE);		
		$this->template->load('global', 'media/edit', $data);		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Media Insert
	 *
	 * @access	public
	 * @param	int
	 * @return	void
	 */	
	function _media_insert($page_id, $parent_id = NULL)
	{
		if( !$page_id ) $this->template->message('page id missing', 'error', '/pages');
		
		$return = $this->input->post('return', TRUE);	
				
		switch( $this->input->post('type') ):
			
			case 'image':			
			case 'images':								
				
				$filename = $this->media->upload('file', '../frontend/assets/uploads/images/pages');				
				if( $filename === FALSE ) $this->template->message($this->media->error(), 'error', $return);
				
				if( $id = $this->input->post('id') )$this->media->delete($id);
	
				$postdata = $this->media->fields_in_db($this->security->xss_clean($_POST));
				if( isset($postdata->id) ) unset($postdata->id);
				unset($postdata->type);
	
				$postdata->file = $filename;
				$this->media->insert($postdata, $page_id);	
				$this->template->message('Image uploaded successfully', 'success', $return);
				
				break;
		
		endswitch;
	}
	/**/
}

/* End of file pages.php */
/* Location: modules/pages/controllers/pages.php */