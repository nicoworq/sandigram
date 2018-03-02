<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("Service_model", "Service");
        date_default_timezone_set('America/Buenos_Aires');
    }

    public function index() {
        
    }

    public function is_service_active() {

        $last_seen = $this->Service->get_service_last_seen();
        $now = new DateTime();
        $fecha_servicio = new DateTime($last_seen[0]->ultima_vez_visto);
        $diff = abs($fecha_servicio->getTimestamp() - $now->getTimestamp()) / 60;

        $servicio_activo = TRUE;

        if ($diff > 6) {
            $servicio_activo = FALSE;
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(200)
                        ->set_output(json_encode(array("servicio_activo" => $servicio_activo, "last_seen" => $diff)));
    }

}
