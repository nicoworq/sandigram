<?php

class Accounts_model extends CI_Model {

    var $table_name = "cuentas";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function get_accounts($user) {
        $query = $this->db->get_where($this->table_name, array('id_usuario' => $user['id']));
        $accounts = $query->result();
        return $accounts;
    }

    public function get_account($account_id) {
        $query = $this->db->get_where($this->table_name, array('id' => $account_id));
        $account = $query->result();
        return isset($account[0]) ? $account[0] : FALSE;
    }

    public function set_active($account_id) {
        $account = $this->get_account($account_id);
        $this->session->set_userdata("active_account", $account);
    }

    public function get_active() {
        return $this->session->active_account;
    }

    public function new_account($nombre, $user, $password) {
        $this->load->model("Users_model", "Users");
        $active_user = $this->Users->get_active();

        $data = array("nombre" => $nombre, "user" => $user, "password" => $password, "id_usuario" => $active_user['id']);
        $this->db->insert($this->table_name, $data);

        return $this->db->affected_rows();
    }

}
