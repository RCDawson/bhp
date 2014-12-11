<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Transfusion Admin Controller
*/

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model($this->router->fetch_module().'_model', '_model');
    	$this->load->helper('form');
    }

    public function index() {
    	show_error('Sorry dude');
    	$view->rows = $this->_model->index();
        $this->template->build('admin/index',$view);
    }
    
    public function edit() {
    	die(__FILE__);
    	if(empty($url)) { $this->template->_message('Unable to process your request.','error','admin/news'); }
    	$this->view->page = $this->_model->edit($url);
    	$this->template->build('admin/edit',$this->view);
    }
    public function insert() {
    	$view->posts = $this->_model->insert();
        $this->template
                ->title('Blog')
                ->build('admin/index',$view);
    }
    
    public function comments()
    {
    	$this->template->title('News')->build('admin/index',$view);
    }

    public function indexx() {
        $data->rows = $this->users_model->users();

        foreach($data->rows as $k=>$a) {
            $this->_uniques[] = $a->username;
            $this->_uniques[] = $a->email;
        }

        $this->user_form('new');

        $this->template
            ->title('Manage Users')
            ->build('admin/index', $data);
    }    
}