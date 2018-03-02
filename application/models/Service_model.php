<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service_model
 *
 * @author SERVIDOR
 */
class Service_model extends CI_Model {

    var $table_name = "servicio_back";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_service_last_seen() {

        $sql = "SELECT * FROM servicio_back;";
        $query = $this->db->query($sql);
        return $query->result();
    }

}
