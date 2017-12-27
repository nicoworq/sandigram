<?php

class Posts_model extends CI_Model {

    var $table_name = "publicaciones";

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model("Accounts_model", "Accounts");
    }

    public function get_posts() {


        $cuenta_activa = $this->Accounts->get_active();
        $sql = "SELECT * FROM publicaciones p 
                LEFT JOIN medios m ON p.id_medio = m.id
                LEFT JOIN publicaciones_estados pe ON p.id_estado = pe.id
                WHERE p.id_cuenta = ?;";
        $query = $this->db->query($sql, array($cuenta_activa));

        return $query->result();
    }

    public function new_post($nombre, $texto, $id_medio, $fecha_publicacion) {

        $cuenta_activa = $this->Accounts->get_active();


        $data = array(
            'nombre' => $nombre,
            'texto' => $texto,
            'id_medio' => $id_medio,
            'fecha_publicacion' => $fecha_publicacion
        );

        $sql_insert = "INSERT INTO {$this->table_name} (id_cuenta,id_medio,nombre,texto,fecha_publicacion,fecha_creacion) VALUES (? , ? , ? , ? , ? ,NOW()) ";

        $this->db->query($sql_insert, array($cuenta_activa, $id_medio, $nombre, $texto, $fecha_publicacion));

        return $this->db->affected_rows();
    }

}
