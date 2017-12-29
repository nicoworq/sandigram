<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 
class Media extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->model("Medias_model", "Medias");
    }

    function index() {
        //       $this->load->view('file_upload_ajax', NULL);
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
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_filename'] = '255';
                    $config['encrypt_name'] = TRUE;
                    $config['max_size'] = '2048'; //2 MB
                    
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file')) {
                        $response = array("subido" => FALSE, 'error' => $this->upload->display_errors());
                    } else {
                        $id_medio = $this->upload_file_database($this->upload->data());
                        $nombre_archivo = $this->upload->data()["file_name"];
                        if ($id_medio) {
                            $response = array("subido" => TRUE, 'id_medio' => $id_medio,'nombre_archivo' => $nombre_archivo);
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
        $ancho = $fileData['image_width'];
        $alto = $fileData['image_height'];
        $tamaño = $fileData['file_size'];
        return $this->Medias->new_media($nombre_archivo, $ruta_completa, $ancho, $alto, $tamaño);
    }

}
