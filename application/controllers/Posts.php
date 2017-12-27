<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Posts_model", "Posts");
    }

    public function index() {
        $this->load->helper('date');
        $posts = $this->Posts->get_posts();
        $this->load->view("posts/posts-list", array(
            "posts" => $posts,
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message"))
        );
    }

    public function new_post() {
        $this->load->view("posts/new-post-view", array(
            'nombre' => $this->session->flashdata("nombre"),
            'texto' => $this->session->flashdata("texto"),
            'fecha_publicacion' => $this->session->flashdata("fecha_publicacion"),
            "alert" => $this->session->flashdata("alert"),
            "alert_message" => $this->session->flashdata("alert_message")
        ));
    }

    public function new_post_action() {
        $nombre = $this->input->post("nombre", TRUE);
        $texto = $this->input->post("texto", TRUE);
        $id_medio = $this->input->post("id_medio", TRUE);
        $fecha_publicacion = $this->input->post("fecha_publicacion", TRUE);


        if (is_null($nombre) || is_null($texto) || is_null($id_medio) || empty($fecha_publicacion)) {
            $this->session->set_flashdata("alert", "danger");
            $this->session->set_flashdata("alert_message", "Por favor revisa todos los campos");
            $this->session->set_flashdata("nombre", $nombre);
            $this->session->set_flashdata("texto", $texto);
            $this->session->set_flashdata("fecha_publicacion", $fecha_publicacion);
            redirect("posts/new-post");
        }

        $creado = $this->Posts->new_post($nombre, $texto, $id_medio, $fecha_publicacion);

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

}
