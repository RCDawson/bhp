<?php

class Form extends CI_Controller {

    function index()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

//        $this->form_validation->set_rules('username', 'Username', 'callback_username_check|required');
//        $this->form_validation->set_rules('password', 'Password', 'required');
//        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
//        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
//        $this->form_validation->set_rules('active', 'Foo');

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('myform');
        }
        else
        {
            $this->load->view('formsuccess');
        }
    }

    public function username_check($str)
    {
        if ($str == 'test')
        {
            $this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}
?>