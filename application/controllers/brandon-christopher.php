<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('base', 'text');
    }

    public function index() {
        $this->template->build('brandon-christopher');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */