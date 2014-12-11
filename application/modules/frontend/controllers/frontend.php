<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends MY_Controller {

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
        $this->output->enable_profiler(false);
        // end benchmarking
	        
    }

    public function brandon()
    {
        $data = new stdClass();
        $data->main_nav = $this->frontend_model->get_contentmeta('main_nav');
        $data->site_name = $this->config->item('site_name');
        $this->template->title('Brandon Christopher')->build('brandon-christopher',$data);
    }

    public function aida()
    {
        $data = new stdClass();
        $data->main_nav = $this->frontend_model->get_contentmeta('main_nav');
        $data->site_name = $this->config->item('site_name');
        $this->template->title('Aida Zilelian')->build('aida-zilelian',$data);
    }

    public function index($url = NULL, $query_str = NULL) {
        // 'home' is the url stored in the db, but don't let anyone know that
        if ($url == 'home')
            show_404();

        // Handle first url segment
        if (empty($url)) {
            $url = 'home';
        }

        $data = new stdClass();
        $data->page = $this->frontend_model->index($url, $query_str);
        $data->page->partials = $this->frontend_model->get_partials_by_id($data->page->id);
        if(!empty($data->page->partials)) {
        	foreach($data->page->partials as $key=>$partial) {
        		$this->template->set_partial('_afterbody_partial',$partial['meta_value']);
                $this->frontend_model->contact_form();
        	}
	    }
        $data->main_nav = $this->frontend_model->get_contentmeta('main_nav');
        $data->site_name = $this->config->item('site_name');
        $data->sidebars = $this->frontend_model->get_page_sidebars($url);
        $data->sidebar_charlimit = $this->config->item('sidebar_char_limit');
		$this->template->title($data->page->title);
//         if ($url=='upcoming')
//         {
//         	$this->template->build('one_col', $data);
//         }
        if ($url == 'submissions')
        {
        	$this->template->build('six-by-six', $data);
        }
        else
        {
        	if($url=='home')
        	{
        		$data->featured_author = $this->frontend_model->get_by_title('Brandon Christopher');
        	}
	        $this->template->build('default_view', $data);
	    }
    }
    
    public function load_module($module) {	
    	$this->load->library('../modules/'.$module.'/controllers/'.$module);
    	$this->$module->index();
    }
    public function news() { die(__file__); }

    public function themsg_msg($str) {
        return $this->frontend_model->themsg_msg($str);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */