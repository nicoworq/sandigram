<?php

class Accounts_model extends CI_Model {

    var $table_name = "cuentas";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_accounts($user) {
        $query = $this->db->get_where($this->table_name, array('id_usuario' => $user['id']));
        $accounts = $query->result();
        return $accounts;
    }

    public function set_active($account_id) {
        $this->session->set_userdata("active_account_id", $account_id);
    }

    public function get_active() {
        $this->load->library('session');
        return $this->session->active_account_id;
    }

    public function new_account($nombre) {
        $this->load->model("Users_model", "Users");
        $active_user = $this->Users->get_active();

        $data = array("nombre" => $nombre, "id_usuario" => $active_user['id']);
        $this->db->insert($this->table_name, $data);

        return $this->db->affected_rows();
    }

}
