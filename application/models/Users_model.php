<?php

class Users_model extends CI_Model {

    var $table_name = "usuarios";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function get_users() {

        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function get_user($id) {

        $query = $this->db->get_where($this->table_name, array('id' => $id), 1);

        return $query->result();
    }

    public function new_user($nombre, $email, $password, $superadmin) {

        $sql_insert = "INSERT INTO {$this->table_name} (nombre,email,password,superadmin) VALUES (?, ? , ? , ?) ";

        $this->db->query($sql_insert, array($nombre, $email, md5($password), $superadmin));

        return $this->db->affected_rows();
    }

    public function edit_user($id, $nombre, $email, $password, $superadmin) {

        $sql_insert = "UPDATE {$this->table_name} SET nombre = ?,email = ?,password = ?,superadmin = ? WHERE id = ? ";

        $this->db->query($sql_insert, array($nombre, $email, md5($password), $superadmin, $id));

        return $this->db->affected_rows();
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
