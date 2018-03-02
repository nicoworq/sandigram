<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model("Medias_model", "Medias");
        $this->load->model("Accounts_model", "Accounts");
        $this->activeAccount = $this->Accounts->get_active();
    }

    function index() {
        $media_list = $this->Medias->get_media_list();
        $this->load->view('media/media-list', array("media_list" => $media_list, "active_account" => $this->activeAccount));
    }

    function upload_file() {

        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists('uploads/' . $_FILES['file']['name'])) {
                    echo 'File already exists : uploads/' . $_FILES['file']['name'];
                } else {

                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|mp4';
                    $config['max_filename'] = '255';
                    $config['encrypt_name'] = TRUE;
                    $config['max_size'] = '20048'; //20 MB

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file')) {
                        $response = array("subido" => FALSE, 'error' => $this->upload->display_errors());
                    } else {
                        $id_medio = $this->upload_file_database($this->upload->data());

                        $nombre_archivo = $this->upload->data()["file_name"];
                        $es_imagen = $this->upload->data()["is_image"];
                        if ($id_medio) {
                            $response = array("subido" => TRUE, 'id_medio' => $id_medio, 'nombre_archivo' => $nombre_archivo, 'es_imagen' => $es_imagen);
                        } else {
                            $response = array("subido" => FALSE, 'error' => $this->db->error());
                        }
                    }

                    return $this->output->set_content_type('application/json')
                                    ->set_output(json_encode($response));
                }
            }
        } else {
            echo 'Please choose a file';
        }
    }

    function upload_file_database($fileData) {


        $nombre_archivo = $fileData['file_name'];
        $ruta_completa = $fileData['full_path'];
        $es_imagen = $fileData['is_image'];
        $ancho = $es_imagen ? $fileData['image_width'] : 0;
        $alto = $es_imagen ? $fileData['image_height'] : 0;
        $tamaño = $fileData['file_size'];

        return $this->Medias->new_media($nombre_archivo, $ruta_completa, $ancho, $alto, $tamaño, $es_imagen);
    }

}
