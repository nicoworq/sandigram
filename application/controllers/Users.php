<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Users_model", "Users");
    }

    public function index() {

        $usuarios = $this->Users->get_users();

        $this->load->view('users/users-list', array(
            'usuarios' => $usuarios,
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message"),));
    }

    public function edit_user($id_user) {

        if (!is_integer(intval($id_user))) {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "No encontramos ese usuario!");
            redirect("users");
        }

        $user = $this->Users->get_user($id_user);

        if (!$user) {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "No encontramos ese usuario!");
            redirect("users");
        }

        $this->load->view("users/user-edit", array(
            'user' => $user[0],
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message")
        ));
    }

    public function edit_user_action() {
        $id = $this->input->post("id", TRUE);
        $nombre = $this->input->post("nombre", TRUE);
        $email = $this->input->post("email", TRUE);
        $password = $this->input->post("password", TRUE);
        $password2 = $this->input->post("password2", TRUE);


        if (is_null($nombre) || is_null($email) || is_null($password) || empty($password2)) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Por favor revisa todos los campos");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("email", $email);

            redirect("users/{$id}");
        }

        if ($password !== $password2) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Las contraseñas no coinciden");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("email", $email);
            redirect("users/{$id}");
        }

        $superadmin = 0;
        $editado = $this->Users->edit_user($id,$nombre, $email, $password, $superadmin);

        if ($editado) {
            $this->session->set_flashdata("alert", "success");
            $this->session->set_flashdata("alert_message", "Usuario editado correctamente!");
            redirect("users");
        } else {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "Ocurrió un error al editar el usuario");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("email", $email);
            redirect("users/{$id}");
        }
    }

    public function new_user() {

        $this->load->view('users/user-new', array(
            'email' => $this->session->flashdata("email"),
            'nombre' => $this->session->flashdata("nombre"),
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message")));
    }

    public function new_user_action() {

        $nombre = $this->input->post("nombre", TRUE);
        $email = $this->input->post("email", TRUE);
        $password = $this->input->post("password", TRUE);
        $password2 = $this->input->post("password2", TRUE);


        if (is_null($nombre) || is_null($email) || is_null($password) || empty($password2)) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Por favor revisa todos los campos");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("email", $email);

            redirect("users/new");
        }

        if ($password !== $password2) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Las contraseñas no coinciden");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("email", $email);

            redirect("users/new");
        }
        $superadmin = 0;
        $creado = $this->Users->new_user($nombre, $email, $password, $superadmin);

        if ($creado) {
            $this->session->set_flashdata("alert", "success");
            $this->session->set_flashdata("alert_message", "Usuario creado correctamente!");
            redirect("users");
        } else {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "Ocurrió un error al crear el usuario");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("email", $email);
            redirect("users/new");
        }
    }

}
