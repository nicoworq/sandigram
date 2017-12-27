<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        $error = FALSE;

        if ($this->session->flashdata('error') !== NULL) {
            $error = $this->session->flashdata('error');
        }
        $this->load->view('login/login-view', array('error' => $error, 'email' => $this->session->flashdata('email')));
    }

    public function login_action() {
        $this->load->model("Users_model", "Users");
        $email = $this->input->post("email");
        $password = $this->input->post("password");

        $valid_user = $this->Users->validate_user($email, $password);

        if ($valid_user) {
            $this->Users->set_active($valid_user);
            
            redirect("/accounts");
            return TRUE;
        }
        $this->session->set_flashdata("error", "Usuario y/o contraseña incorrectos");
        $this->session->set_flashdata("email", $email);
        redirect("/login");
        return FALSE;
    }

}
