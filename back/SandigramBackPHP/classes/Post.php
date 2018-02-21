<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Post
 *
 * @author SERVIDOR
 */
class Post {

    public $id;
    public $id_cuenta;
    public $id_estado;
    public $id_medio;
    public $nombre;
    public $texto;
    public $fecha_publicacion;
    public $fecha_creacion;

    /*
      public function __construct($id, $id_cuenta, $id_estado, $id_medio, $nombre, $texto, $fecha_publicacion, $fecha_creacion) {

      $this->id = $id;
      $this->id_cuenta = $id_cuenta;
      $this->id_estado = $id_estado;
      $this->id_medio = $id_medio;
      $this->nombre = $nombre;
      $this->texto = $texto;
      $this->fecha_publicacion = date_create_from_format('Y-m-d H:i:s', $fecha_publicacion);
      $this->fecha_creacion = date_create_from_format('Y-m-d H:i:s', $fecha_creacion);
      }
     */

    public function isPostToPublish() {

        $now = new DateTime();
        $fecha_publicacion_date = new DateTime($this->fecha_publicacion);
        $diff = abs($fecha_publicacion_date->getTimestamp() - $now->getTimestamp()) / 60;
        if ($diff < 10) {
            return TRUE;
        }
        return FALSE;
    }

    public function getPostText() {
        return base64_decode($this->texto);
    }
    
    public function updateStatus(){
        
    }

}
