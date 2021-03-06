<?php

class Medias_model extends CI_Model {

    var $table_name = "medios";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model("Accounts_model", "Accounts");
    }

    public function get_media() {
        $cuenta_activa = $this->Accounts->get_active();
        $query = $this->db->get_where($this->table_name, array('id_cuenta' => $cuenta_activa));
        return $query->result();
    }

    public function new_media($nombre_archivo, $ruta_completa, $ancho, $alto, $tamaño, $es_imagen) {

        $cuenta_activa = $this->Accounts->get_active();

        $sql_insert = "INSERT INTO {$this->table_name} (id_cuenta,nombre_archivo,ruta_completa,ancho,alto,tamaño,es_imagen,fecha_creacion) VALUES (? , ? , ? , ? , ?, ?, ? ,NOW()) ";

        $this->db->query($sql_insert, array($cuenta_activa->id, $nombre_archivo, $ruta_completa, $ancho, $alto, $tamaño, $es_imagen));

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        };
    }

    public function get_media_list() {

        $sql_list = "SELECT * FROM {$this->table_name};";

        $query = $this->db->query($sql_list);

        return $query->result();
    }

}
