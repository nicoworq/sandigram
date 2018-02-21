<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

    var $loggedUser;
    var $activeAccount;

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Posts_model", "Posts");
        $this->load->model("Users_model", "Users");
        $this->load->model("Accounts_model", "Accounts");

        $this->loggedUser = checkLogged($this->Users, $this->session);
        $this->activeAccount = $this->Accounts->get_active();
    }

    public function index() {
        $this->load->helper('date');
        $posts = $this->Posts->get_posts();
        $this->load->view("posts/posts-list", array(
            "posts" => $posts,
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message"),
            "active_account" => $this->activeAccount)
        );
    }

    public function new_post() {
        $nombre = $this->session->flashdata("nombre");
        if (!$nombre) {
            $nombre = $this->activeAccount->nombre;
        }

        $this->load->view("posts/new-post-view", array(
            'nombre' => $nombre,
            'texto' => $this->session->flashdata("texto"),
            'fecha_publicacion' => $this->session->flashdata("fecha_publicacion"),
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message"),
            "active_account" => $this->activeAccount
        ));
    }

    public function new_post_action() {
        $nombre = $this->input->post("nombre", TRUE);
        $texto = $this->input->post("texto", TRUE);
        $id_medio = $this->input->post("id_medio", TRUE);
        $fecha_publicacion = $this->input->post("fecha_publicacion", TRUE);
        $id_tipo = $this->input->post("id_tipo", TRUE);

        if (is_null($nombre) || is_null($texto) || is_null($id_medio) || empty($fecha_publicacion)) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Por favor revisa todos los campos");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("texto", $texto);
            $this->session->set_flashdata("fecha_publicacion", $fecha_publicacion);
            redirect("posts/new-post");
        }

        $creado = $this->Posts->new_post($id_tipo, $nombre, $texto, $id_medio, $fecha_publicacion);

        if ($creado) {
            $this->session->set_flashdata("alert", "success");
            $this->session->set_flashdata("alert_message", "Publicación creada correctamente!");
            redirect("posts");
        } else {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "Ocurrió un error al crear la publicación");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("texto", $texto);
            $this->session->set_flashdata("fecha_publicacion", $fecha_publicacion);
            redirect("posts/new-post");
        }
    }

    public function edit_post($id_post) {

        if (!is_integer(intval($id_post))) {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "No encontramos esa publicación!");
            redirect("posts");
        }

        $post = $this->Posts->get_post(intval($id_post));

        if (!$post) {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "No encontramos esa publicación!");
            redirect("posts");
        }

        $errores = array();
        if (intval($post->id_estado) === 3) {
            $errores = $this->Posts->get_errors($post->id_publicacion);
        }

        $this->load->view("posts/edit-post-view", array(
            'post' => $post,
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message"),
            "active_account" => $this->activeAccount,
            "errores" => $errores
        ));
    }

    public function edit_post_action() {
        $id_publicacion = $this->input->post("id_publicacion", TRUE);
        $nombre = $this->input->post("nombre", TRUE);
        $texto = $this->input->post("texto", TRUE);
        $id_medio = $this->input->post("id_medio", TRUE);
        $id_tipo = $this->input->post("id_tipo", TRUE);
        $fecha_publicacion = $this->input->post("fecha_publicacion", TRUE);


        if (is_null($nombre) || is_null($texto) || is_null($id_medio) || empty($fecha_publicacion)) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Por favor revisa todos los campos");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("texto", $texto);
            $this->session->set_flashdata("fecha_publicacion", $fecha_publicacion);
            redirect("posts/{$id_publicacion}");
        }

        $editado = $this->Posts->edit_post($id_publicacion, $id_tipo, $nombre, $texto, $id_medio, $fecha_publicacion);

        if ($editado) {
            $this->session->set_flashdata("alert", "success");
            $this->session->set_flashdata("alert_message", "Publicación editada correctamente!");
            redirect("posts");
        } else {
            $this->session->set_flashdata("alert", "error");
            $this->session->set_flashdata("alert_message", "Ocurrió un error al editar la publicación");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("texto", $texto);
            $this->session->set_flashdata("fecha_publicacion", $fecha_publicacion);
            redirect("posts/{$id_publicacion}");
        }
    }

    public function delete_post_action($id_publicacion) {
        $eliminado = $this->Posts->delete_post($id_publicacion);

        if ($eliminado) {
            $this->session->set_flashdata("alert", "success");
            $this->session->set_flashdata("alert_message", "Publicación eliminada correctamente!");
        } else {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Ocurrio un error al eliminar!");
        }

        redirect("posts");
    }

}
