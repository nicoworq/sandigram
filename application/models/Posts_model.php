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
        $sql = "SELECT p.id as id_publicacion, id_estado, estado, nombre, nombre_archivo, texto, fecha_publicacion FROM publicaciones p 
                LEFT JOIN medios m ON p.id_medio = m.id
                LEFT JOIN publicaciones_estados pe ON p.id_estado = pe.id
                WHERE p.id_cuenta = ?;";
        $query = $this->db->query($sql, array($cuenta_activa->id));

        return $query->result();
    }

    public function get_post($id_post) {

        if (!is_integer($id_post)) {
            return false;
        }
        $cuenta_activa = $this->Accounts->get_active();
        $sql = "SELECT p.id AS id_publicacion, id_estado, estado, nombre,m.id AS id_medio, nombre_archivo, texto, fecha_publicacion FROM publicaciones p 
                LEFT JOIN medios m ON p.id_medio = m.id
                LEFT JOIN publicaciones_estados pe ON p.id_estado = pe.id
                WHERE p.id_cuenta = ? AND p.id = ? ;";
        $query = $this->db->query($sql, array($cuenta_activa->id, $id_post));
        $post = $query->result();
        return isset($post[0]) ? $post[0] : FALSE;
    }

    public function new_post($nombre, $texto, $id_medio, $fecha_publicacion) {

        $cuenta_activa = $this->Accounts->get_active();

        $sql_insert = "INSERT INTO {$this->table_name} (id_cuenta,id_medio,nombre,texto,fecha_publicacion,fecha_creacion) VALUES (? , ? , ? , ? , ? ,NOW()) ";

        $this->db->query($sql_insert, array($cuenta_activa->id, $id_medio, $nombre, $texto, $fecha_publicacion));

        return $this->db->affected_rows();
    }

    public function edit_post($id_publicacion, $nombre, $texto, $id_medio, $fecha_publicacion) {

        $cuenta_activa = $this->Accounts->get_active();

        $sql_insert = "UPDATE {$this->table_name} SET id_medio = ?,nombre = ?,texto = ?,fecha_publicacion = ? WHERE id_cuenta = ? AND id = ?; ";

        $this->db->query($sql_insert, array($id_medio, $nombre, $texto, $fecha_publicacion, $cuenta_activa->id, $id_publicacion));

        return $this->db->affected_rows();
    }

}
