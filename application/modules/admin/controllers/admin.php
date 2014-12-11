<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * CMS Admin/Login Controller
 * /application/modules/admin/controllers/admin.php
 */

class Admin extends MY_Controller {

    public $_uniques = array();
    public $_compare = array();
	public $_table = 'mc_content';

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
    }
    
	public function get_settings() {
		$settings = array();
		$empty = '<span class="empty">- empty -</span>';
		$settings['site_name'] = ($this->config->item('site_name')) ? $this->config->item('site_name').' : ':'';
		$settings['admin_email'] = ($this->config->item('admin_email')) ? $this->config->item('admin_email'):$empty;
		$settings = (object)$settings;
//		$settings->site_name =
		return $settings;
	}

    public function index() {
        // Build the Dashboard
        $view = new stdClass();
        $view->settings = $this->get_settings();
        $this->config->set_item('hidebreadcrumbs',true);
    	$view->pods = $this->load->library('dashboard');
    	$this->load->helper('get_pods');
        $view->pages = $this->admin_model->get_parents();
        $view->kids = $this->admin_model->get_kids();
        $view->sidebars = $this->admin_model->get_sidebars();
        $this->template
                ->title('Dashboard')
                ->build('/admin/index', $view);
    }

    public function pods() {
        // Build the Dashboard
        $this->config->set_item('hidebreadcrumbs',true);
    	$this->load->library('dashboard_pods');
        //$this->load->file(APPPATH.'modules/libraries/html_elements/Div.php');
     	//$this->view->divElement = new Div('Some Settings value or whatever', array('class' => 'someClass'), array());
     	
        //$this->view->pages = $this->admin_model->get_parents();
        //$this->view->kids = $this->admin_model->get_kids();
        //$this->view->sidebars = $this->admin_model->get_sidebars();
        $this->template
                ->title('Dashboard')
                ->build('/admin/pods', $this->view);
    }

    /*
     * Admin CRUD
     */

    public function edit($url = null) {
    	$this->load->helper('date');
        $this->set_redirect(current_url());
//    	$view->settings = $this->get_settings();
        // Try to pull some data
        $data = $this->admin_model->edit_pages($url);
        // $url is not null, so pull all pages from db and build array.
        // Allow editing.
        if (!empty($data->page)) {
            $data->all_pages = $this->admin_model->edit_pages();
            // build array to check for unique users/emails in form/post data.
            $_compare = array();
            foreach ($data->all_pages as $k => $a) {
                //Build separate array with THIS page's contents. We'll unset it later, so form won't fail.
                if ($a->url == $url) {
                    $this->_compare[] = $a->url;
                    $this->_compare[] = $a->title;
                }
                $this->_uniques[] = $a->url;
                $this->_uniques[] = $a->title;
            }

            // Remove current user info out of _uniques so form validation will allow the
            // use of same username and email address on update.
            $this->_uniques = array_diff($this->_uniques, $this->_compare);

            $this->template->inject_partial('js','/js/ckeditor/ckeditor.js');
        } else {
            show_404();
        }
        if($data->page->page_type=='sidebar') {
            $this->admin_model->main_form('edit_sidebar', $url);
//            $data->sidebars = $this->admin_model->get_sidebars_usage($url);
            $this->template->title('Edit Sidebars')->build('/admin/edit',$data);
        } else {
            $this->admin_model->main_form('edit', $url);
            $this->template->title('Edit Page')->build('/admin/edit',$data);
        }
    }

    public function options() {
        $data->option = $this->admin_model->create('options');
        $this->template->title('New Option')->build('/admin/options',$data);
    }

    public function create($_type = null) {
        if($_type=='sidebar' || $_type=='page') {
            $this->admin_model->create_content($_type);
            $this->template->title('Create '.ucwords($_type))->build('/admin/create_content');
        } else {
            show_404();
        }
    }

    public function update($url) {
        //echo('update method of admin controller');exit;
        $this->admin_model->update_page($url);
    }

    public function delete($url) {
    	$data->content = $this->admin_model->delete_view($url);
    	if($this->input->post())
    	{
    		$this->admin_model->delete_by_url($url);
    		$this->template->_message('Content has been deleted.', 'success',$this->get_redirect());
    	}
		$this->template->title('Delete')->build('/admin/delete',$data);
    }


    public function edit_orig($url = null) {
    	$data->settings = $this->get_settings();
    	$this->load->helper('date');
        $this->set_redirect(current_url());
        // Try to pull some data
        $data = $this->admin_model->edit_pages($url);
        // $url is not null, so pull all pages from db and build array.
        // Allow editing.
        if (!empty($data->page)) {
            $data->all_pages = $this->admin_model->edit_pages();
            // build array to check for unique users/emails in form/post data.
            $_userinfo = array();
            foreach ($data->all_pages as $k => $a) {
                //Build separate array with THIS page's contents. We'll unset it later, so form won't fail.
                if ($a->url == $url) {
                    $this->_userinfo[] = $a->url;
                    $this->_userinfo[] = $a->title;
                }
                $this->_uniques[] = $a->url;
                $this->_uniques[] = $a->title;
            }

            // Remove current user info out of _uniques so form validation will allow the
            // use of same username and email address on update.
            $this->_uniques = array_diff($this->_uniques, $this->_userinfo);
            
            $this->template->inject_partial('js','/js/ckeditor-full/ckeditor.js');
        } else {
            show_404();
        }
        if($data->page->page_type=='sidebar') {
            $this->admin_model->main_form('edit_sidebar', $url);
            $data->sidebars = $this->admin_model->get_sidebars_usage($url);
            $this->template->title('Edit Sidebars')->build('/admin/edit_sidebars',$this->data);
        } else {
            $this->admin_model->main_form('edit', $url);
            $this->template->title('Edit Page')->build('/admin/edit',$data);
        }
    }


    public function be_unique($arg) {
        return $this->admin_model->be_unique($arg);
    }

    /*
     *  CMS Login
     */

    public function login() {
    	if($this->session->userdata('authed')===true) redirect('admin');

        // Show the form
        $this->validate_login();
        $this->config->set_item('hidebreadcrumbs',true);
        $this->template
                ->title('Authenticate')
                ->build('/admin/login_form');
    }

    public function validate_login() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login-user', 'Username', 'trim|required');
        $this->form_validation->set_rules('login-pass', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            $username = $this->input->post('login-user');
            $password = $this->input->post('login-pass');
            // If the form fields validate, Authenticate User.
            $this->template->_message('Welcome back!', 'success');
            Auth::authenticate($username, $password);
        }
    }

    // End CMS Log In ----------------------------------------------------------------/

    /*
     *  CMS Log Out
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }

    // End CMS Log Out ----------------------------------------------------------------/
}