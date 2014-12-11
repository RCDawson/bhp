<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * CMS Transfusion Controller
*/

class Transfusion extends MY_Controller {
	
	public $view;

    public function __construct() {
        parent::__construct();
        $this->load->model($this->router->fetch_module().'_model', '_model');
    }

    public function index() {
    	$this->view->page = $this->_model->index();
    	$this->load->config('transfusion_config');
    	$this->template
    			->title($this->config->item('title'))
    			->build($this->config->item('view'),$this->view);
    }
    
    public function edit() {
    	$this->view->page = $this->_model->edit($url);
    	$this->template->build('admin/edit',$this->view);
    }

    public function insert() {
    	$view->posts = $this->_model->insert();
        $this->template
                ->title('Blog')
                ->build('admin/index',$view);
    }
    
}