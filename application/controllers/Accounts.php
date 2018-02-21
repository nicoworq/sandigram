<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Accounts_model", "Accounts");
        $this->load->model("Users_model", "Users");

        $this->loggedUser = checkLogged($this->Users, $this->session);
        $this->activeAccount = $this->Accounts->get_active();
    }

    public function index() {
        $user = $this->session->logged_user;
        $accounts = $this->Accounts->get_accounts($user);

        $this->load->view("accounts/select-account-view", array(
            "accounts" => $accounts,
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message"),
            "active_account" => $this->activeAccount)
        );
    }

    public function select_account($account_id) {
        $this->Accounts->set_active($account_id);
        redirect("/posts");
    }

    public function new_account() {
        $error = FALSE;
        if ($this->session->flashdata('error') !== NULL) {
            $error = $this->session->flashdata('error');
        }
        $this->load->view("accounts/new-account-view", array("error", $error, "active_account" => $this->activeAccount));
    }

    public function new_account_action() {
        $nombre = $this->input->post("nombre");
        $user = $this->input->post("user");
        $password = $this->input->post("password");

        $creada = $this->Accounts->new_account($nombre,$user,$password);
        if ($creada) {
            $this->session->set_flashdata("alert", "success");
            $this->session->set_flashdata("alert_message", "Cuenta creada correctamente!");
            redirect("accounts");
        } else {
            $this->session->set_flashdata("error", "Ocurrió un error al crear la cuenta");
            redirect("accounts/new-account");
        }
    }

}
