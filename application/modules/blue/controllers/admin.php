<?php
class Admin extends My_Controller
{

    public function index() {
		$this->view->pods = $this->load->library('dashboard_pods')->index();
        $this->template->build('index', $this->view);
    }

}
