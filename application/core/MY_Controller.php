<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->view = new stdClass();
    	$this->load->model($this->router->fetch_module().'_model','_model');
        $this->_model->get_site_name();
		$this->view->site_name = $this->config->item('site_name');
		$this->view->main_nav = $this->_model->get_contentmeta('main_nav');
        $this->front_or_back();
    }
    
    public function front_or_back() {
		if($this->uri->segment(1) == 'admin')
		{
			$this->backend();
		}
		else
		{
			$this->frontend();
		}
    }
    
    public function frontend() {
		return $this->view;
    }
    
	public function backend() {
        $this->load->library('auth');

		/*
		 * Layout, theme, helper files
		 */
        $this->load->helper('cms_nav');
        $this->template
                ->set_breadcrumb('Dashboard', '/admin')
                ->set_layout('cms/cms_layout');

        if ($this->uri->segment(2) != 'login' && Auth::has_id() === FALSE) {
            $this->set_redirect(base_url() . $this->uri->uri_string);
            redirect('admin/login');
        }
    }

    public function set_redirect($url) {
        $this->session->set_userdata('request_url', $url);
    }

    public function get_redirect() {
        return $this->session->userdata('request_url');
    }

    public function invalid_request() {
        $this->template->_message('Invalid Request');
        return false;
    }

}