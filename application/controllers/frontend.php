<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('base', 'text');
        $this->load->model('frontend_model');

		// ci benchmarking //
		$sections = array(
			'uri_string' => false,
			'memory_usage' => false,
			'http_headers' => false
			);
		$this->output->set_profiler_sections($sections);
        $this->output->enable_profiler(TRUE);
        // end benchmarking
	        
    }

    public function index($url = NULL, $query_str = NULL) {

        // 'home' is the url stored in the db, but don't let anyone know that
        if ($url == 'home')
            show_404();

        // Handle first url segment
        if (empty($url)) {
            $url = 'home';
        }

        $data->page = $this->frontend_model->index($url, $query_str);
        $data->page->partials = $this->frontend_model->get_partials_by_id($data->page->id);
        if(!empty($data->page->partials)) {
	        $this->template->set_partial('_afterbody_partial',$data->page->partials);
                $this->frontend_model->contact_form();
	    }
        $data->main_nav = $this->frontend_model->get_contentmeta('main_nav');
        $data->sidebars = $this->frontend_model->get_page_sidebars($url);
        $data->sidebar_charlimit = $this->config->item('sidebar_char_limit');

        $this->template->build('frontend', $data);
    }

    public function themsg_msg($str) {
        return $this->frontend_model->themsg_msg($str);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */