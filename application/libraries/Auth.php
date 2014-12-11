<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
    
    public function authenticate($username, $password, $url = NULL) {
    $query = $this->db
                ->select('id, username, first_name, last_name, password, salt')
                ->where('username', $username)
                ->get('sys_users');

        $row = $query->row();

        if ($row != NULL) {
            // Username OK. Check the password. Return False on fail
            if ($row->password == sha1($password . $row->salt)) {
                self::set_id($row);
                self::movin_on($this->session->userdata('request_url'));
            }
            return true;
        } else {
            return FALSE;
        }
    }

    private function set_id($row) {
        $this->session->set_userdata(array(
            'uid'       => $row->id,
            'disp_name' => $row->first_name . ' ' . $row->last_name,
            'authed'    => true));
    }

    public function has_id() {
        $query = $this->db
                ->select('id, role')
                ->where('id', $this->session->userdata('uid'))
                ->get('sys_users');
        $row = $query->row();

        if (empty($row->id) && empty($row->role)) {
            $this->config->set_item('authenticated',false);
            return FALSE;
        } else {
            $this->config->set_item('authenticated',true);
            return TRUE;
        }
    }

    private function movin_on($url) {
        if ($url != NULL) {
            redirect($url);
        }
    }

}