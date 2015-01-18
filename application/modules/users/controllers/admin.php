<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Users Admin Controller
*/

class Admin extends MY_Controller {

    public $_uniques = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
    }

    /**
     * Index
     *
     * Listing of all users in system
     *
     * @access	public
     * @return	void
     */
    public function index()
    {
        $data = new stdClass();
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

    public function user_form($form_type,$id=null) {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_be_unique');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_be_unique');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        if($form_type == 'new') {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[repassword]');
            $this->form_validation->set_message('matches','Both %s fields must match.');
        }
        $this->form_validation->set_error_delimiters('<dd>', '</dd>');

        if ($this->form_validation->run() == FALSE) {
            return false;
        }
        else {
            if($form_type=='new') {
                $this->new_user();
            }
            if($form_type=='update') {
                $this->update_user($id);
            }
            return true;
        }
    }

    /**
     * Determine if $arg is found in array '_uniques'.
     * Used to prevent passing values to fields in DB that hold unique values.
     *
     * @param string $arg
     * @return boolean
     */
    public function be_unique($arg) {
        if(in_array($arg,$this->_uniques)) {
            $this->form_validation->set_message('be_unique','%s is not available.');
            return false;
        }
        return true;
    }

    /**
     * Delete CMS user
     *
     * @access	public
     * @param	int
     * @return	void
     */
    public function delete($id=null) {
    	// If there's no ID or a bad ID is passed thru the URL, boot 'em
        if (!$id || !is_numeric($id) || !$this->users_model->user_exists($id)) {
            $this->template->_message('User does not exist.','error','admin/users');
        }
    	// They're not posting the Delete form. Show the Delete view
        else if (!$this->input->post('submit')) {
            // Show Warning and user info.
            $data->row = $this->users_model->users($id);
//            debug::dump($data);exit;
            $this->template->
                    title('Delete User')
                    ->set_breadcrumb('Site Content', '/admin/pages')
                    ->build('admin/delete', $data);
        }
    	// They've posted the Delete form. Ok to delete user with ID.
        else {
            $this->users_model->delete($id);
            $this->template->_message('User deleted successfully', 'success', 'admin/users');
        }
    }

    /**
     * Edit existing CMS User
     *
     * This is the edit user for current logged it. Can update password and
     * profile.
     *
     * @access	public
     * @return	void
     */
    function edit( $id=NULL )
    {
        $data = new stdClass();
        //$this->user_model->is_unique('username','test','sys_users');
        // If $id is not query string, redirect to users.
        if(!$id) {
            redirect('admin/users');
            $this->template->_message('129 controller', 'success', current_url());
        }
        // $id is in query string, so pull all users from db and build array.
        // Allow editing.
        if ($id) {
            $data->info = $this->users_model->users();
            // build array to check for unique users/emails in form/post data.
            $_userinfo = array();
            foreach($data->info as $k=>$a) {
                //Build separate array with THIS user's info. We'll unset it later, so form won't fail.
                if($a->id == $id) {
                    $_userinfo[] = $a->username;
                    $_userinfo[] = $a->email;
                }
                $this->_uniques[] = $a->username;
                $this->_uniques[] = $a->email;
            }
//            Debug::dump($this->_uniques,'Initial Uniques',true);
//            Debug::dump($this->_userinfo,'User Specific values',true);

            // $id NOT found in _uniques, redirect to users.
//            if(in_array($id,$this->_uniques)==FALSE && in_array($id,$this->_userinfo)) {
//                $this->template->_message('User not found.','error','admin/users');
//            }

            // Remove current user info out of _uniques so form validation will allow the
            // use of same username and email address.
            $this->_uniques = array_diff($this->_uniques,$_userinfo);

//            Debug::dump($this->_uniques,'Final Uniques for Form Validation',true);
            // Show the user edit form, and populate fields.
            $this->user_form('update',$id);

            $this->template
                ->title('Edit User')
                ->build('admin/edit', $data);

            // Posting an edit
            if ( $this->input->post() !==FALSE ) {
                // Remove inputs not matching fields in table.
                $postdata = (object) $this->input->post();
                unset($postdata->submit);
            }
        }
    }

    /**
     * Insert New User to CMS
     *
     * @access	public
     * @return	void
     */
    public function new_user() {
        $this->users_model->insert();
        $this->template->_message('User successfully added', 'success', current_url());
    }

    /**
     * Insert New User to CMS
     *
     * @access	public
     * @return	void
     */
    public function update_user($id) {
        $this->users_model->update($id);
        if($this->session->userdata('uid')==$id) {
            $this->session->set_userdata('disp_name',$this->input->post('first_name').' '.$this->input->post('last_name'));
            $this->template->_message('Profile successfully updated', 'success', current_url());
        } else {
            $this->template->_message('User successfully updated', 'success', current_url());
        }
    }
}

/* End of file users.php */
/* Location: admin/controllers/users.php */