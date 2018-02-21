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
        if (!isset($cuenta_activa->id)) {
            return array();
        }
        $sql = "SELECT p.id as id_publicacion, id_estado, estado, nombre, nombre_archivo, texto, es_imagen, fecha_publicacion FROM publicaciones p 
                LEFT JOIN medios m ON p.id_medio = m.id
                LEFT JOIN publicaciones_estados pe ON p.id_estado = pe.id
                WHERE p.id_cuenta = ? ORDER BY p.fecha_creacion DESC;";
        $query = $this->db->query($sql, array($cuenta_activa->id));

        return $query->result();
    }

    public function get_post($id_post) {

        if (!is_integer($id_post)) {
            return false;
        }
        $cuenta_activa = $this->Accounts->get_active();
        $sql = "SELECT p.id AS id_publicacion, id_estado,id_tipo, estado, nombre,m.id AS id_medio, nombre_archivo, texto,es_imagen, fecha_publicacion FROM publicaciones p 
                LEFT JOIN medios m ON p.id_medio = m.id
                LEFT JOIN publicaciones_estados pe ON p.id_estado = pe.id
                WHERE p.id_cuenta = ? AND p.id = ? ;";
        $query = $this->db->query($sql, array($cuenta_activa->id, $id_post));
        $post = isset($query->result()[0]) ? $query->result()[0] : FALSE;
        return $post;
    }

    public function new_post($id_tipo, $nombre, $texto, $id_medio, $fecha_publicacion) {

        $cuenta_activa = $this->Accounts->get_active();

        $sql_insert = "INSERT INTO {$this->table_name} (id_cuenta,id_tipo,id_medio,nombre,texto,fecha_publicacion,fecha_creacion) VALUES (?, ? , ? , ? , ? , ? ,NOW()) ";

        $this->db->query($sql_insert, array($cuenta_activa->id, $id_tipo, $id_medio, $nombre, base64_encode($texto), $fecha_publicacion));

        return $this->db->affected_rows();
    }

    public function edit_post($id_publicacion, $id_tipo, $nombre, $texto, $id_medio, $fecha_publicacion) {

        $cuenta_activa = $this->Accounts->get_active();

        $sql_insert = "UPDATE {$this->table_name}  SET id_estado = 1, id_tipo = ? , id_medio = ?,nombre = ?,texto = ?,fecha_publicacion = ? WHERE id_cuenta = ? AND id = ?; ";

        $this->db->query($sql_insert, array($id_tipo, $id_medio, $nombre, base64_encode($texto), $fecha_publicacion, $cuenta_activa->id, $id_publicacion));

        return $this->db->affected_rows();
    }

    public function get_errors($id_publicacion) {
        $sql = "SELECT * FROM errores  WHERE id_publicacion = ?;";

        $query = $this->db->query($sql, array($id_publicacion));

        return $query->result();
    }

    public function delete_post($id_publicacion) {

        $cuenta_activa = $this->Accounts->get_active();

        $sql_insert = "DELETE FROM {$this->table_name} WHERE id = ? AND id_cuenta = ? ;";

        $this->db->query($sql_insert, array($id_publicacion, $cuenta_activa->id));

        return $this->db->affected_rows();
    }

}
