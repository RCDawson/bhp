<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * CMS Admin/Login Controller
 */

class Edit extends MY_Controller {

    public function index()
    {
    echo current_url(); exit;
        // Build the Dashboard
        $this->load->model('dashboard_model','dash');
        $this->load->model('admin_model','pages');
        $data->co_info = $this->dash->company_info(1);
        $data->user = $this->dash->user_info($this->session->userdata('uid'));
        $data->pages = $this->pages->get_pages();
        $this->template
            ->title('Dashboard')
            ->build('dashboard',$data);
    }

    public function company_info()
    {
        $query = $this->db
                        ->where('sys_users_id',$id)
                        ->get('contact_info');
        return $query->row();
    }

    public function edit($url)
    {
        $this->load->model('admin_model','edit');
        $data->row = $this->edit->edit($url);
        Debug::dump($data->row);
        exit;
        $this->template
                ->title('Edit:'.$url)
                ->build('admin/edit',$data);
    }

    /*
     *  Login screen/form of CMS
     */
        public function validate_login()
	{
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('login-user', 'Username', 'trim|required');
        $this->form_validation->set_rules('login-pass', 'Password', 'trim|required');
        $this->form_validation->set_message('Invalid username or password.');

            if ($this->form_validation->run() == FALSE)
            {
                return false;
            }

            else
            {
                $username = $this->input->post('login-user');
                $password = $this->input->post('login-pass');
                // If the form fields validate, Authenticate User.
                Auth::authenticate($username, $password);
            }
	}

    public function login()
    {
        //echo'login method';exit;
        // Show them the login form
        $this->validate_login();
        $this->template
        ->title('Authenticate')
        ->build('login_form');
    }

    public function logout()
    {
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('authed');
        $this->session->unset_userdata('disp_name');
        $this->session->unset_userdata('request_url');
        redirect('admin');
    }

}