<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends MY_Controller {

    public $content = null;

    public function __construct() {
        parent::__construct();
        $this->load->helper('base', 'text');
        $this->load->model('lists_model');
        $this->content = new stdClass();
    }

    public function index()
    {
        $this->content->main_nav = $this->lists_model->get_contentmeta('main_nav');
        $this->content->payload = $this->lists_model->index('media');
        $this->content->site_name = $this->config->item('site_name');
        $this->template->title('Media')->build('index',$this->content);
    }

    public function indexx($url = NULL, $query_str = NULL) {
        die(__METHOD__);
        $data = new stdClass();
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
    public function news() { die(__METHOD__); }

    public function themsg_msg($str) {
        return $this->frontend_model->themsg_msg($str);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */