<?php

class Users_model extends CI_Model {

    var $table_name = "usuarios";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function validate_user($email, $password) {

        $user = $this->get_user_by_email($email);
        if ($user === NULL) {
            return FALSE;
        }

        if (md5($password) === $user['password']) {
            return $user;
        }
        return FALSE;
    }

    public function get_user_by_email($email) {

        $query = $this->db->get_where($this->table_name, array('email' => $email), 1);

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row;
        }
    }

    public function set_active($user) {        
        $this->session->set_userdata("logged_user", $user);
        session_write_close();
    }

    public function get_active() {        
        return $this->session->logged_user;
    }

}
