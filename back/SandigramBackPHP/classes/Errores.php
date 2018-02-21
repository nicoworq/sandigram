<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Errores
 *
 * @author SERVIDOR
 */
include_once 'Database.php';

class Errores {

    public function logError($idPost, $isGeneralError, $errorMsg) {

        $db = Database::getInstance();
        $mysqli = $db->getConnection();

        echo 'logueo error \n\n';
        $id_post = isset($idPost) ? intval($idPost) : FALSE;
        $error_general = isset($isGeneralError) ? TRUE : FALSE;
        $texto_error = $mysqli->real_escape_string($errorMsg);

        $sql = "INSERT INTO errores  (id_publicacion, error_general, texto_error) VALUES  ({$id_post} , {$error_general}  ,'{$texto_error}' );";

        $result = $mysqli->query($sql);
        if ($result) {
            if ($mysqli->affected_rows) {
                return TRUE;
            }
        } else {
            echo 'error al insertar  \n\n' . $mysqli->error;
        }
        return FALSE;
    }

}
