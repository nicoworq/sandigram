<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Posts_model", "Posts");
        $this->load->model("Users_model", "Users");
    }

    public function index() {

        $posts = $this->Posts->get_posts();

        $this->load->view("dashboard/main-dashboard", array("posts" => $posts));
    }

}
