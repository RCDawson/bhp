<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends MY_Model {

    public function users($id=null) {
        if(!$id) {
            $query = $this->db->get('sys_users');
            return $query->result();
        } else {
            $query = $this->db->where('id',$id)->get('sys_users');
            $row = $query->row();
            return $row;
        }
    }

    public function user_exists($id) {
		return $this->db->where('id',$id)->get('sys_users')->num_rows();
    }

    /*
     * @todo delete this method
     */
//    public function get_user($id) {
//        $query = $this->db->where('id',$id)->get('sys_users');
//        $row = $query->row();
//        return $row;
//    }

    public function insert() {
        $postdata = (object) $this->input->post();

        // Unset inputs not matching fields in table.
        unset($postdata->submit);
        unset($postdata->repassword);

        $created = date("Y-m-d H:i:s");
        $postdata->created = $created;
        $postdata->salt = $this->users_model->myHash(preg_replace('/\D/','',$created));
        $postdata->password = $this->users_model->myHash($postdata->password, $postdata->salt);

        $this->db->insert('sys_users', $postdata);
    }

    public function update($id) {
        $postdata = (object) $this->input->post();

        // Unset inputs not matching fields in table.
        unset($postdata->submit);
        unset($postdata->repassword);

        $this->db->where('id',$id)->update('sys_users', $postdata);
    }

    public function is_unique($field,$val,$table) {
        $query = $this->db
            ->select($field)
            ->where($field,$val)
            ->get($table);
        $row = $query->row();
        if(empty($row)) {
            // It's Unique;
            return true;
        }
    }

 
    public function myHash($plainText, $salt = null) {
        return sha1($plainText . $salt);
    }


    public function delete($id) {
        $this->db->where('id',$id)->delete('sys_users');
    }
}