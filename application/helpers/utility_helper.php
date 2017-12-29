<?php

function get_asset_url() {
    return base_url() . 'assets/';
}

function asset_url() {
    echo base_url() . 'assets/';
}

function get_upload_url() {
    return base_url() . 'uploads/';
}

function get_image_src($fileName) {
    return base_url() . "uploads/{$fileName}";
}

function checkLogged($userModel, $sessionModel) {
    if ($userModel->get_active() === NULL) {

        $sessionModel->set_flashdata("error", "Debes estar logueado para ver esta sección");

        redirect("/login");
        die();
    }
    return $userModel->get_active();
}

function getDateHuman($mysqlDate) {

    $date = DateTime::createFromFormat("Y-m-d H:i:s", $mysqlDate);

    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");

    return $dias[$date->format('w')] . " " . $date->format('d') . "/" . $date->format('n') . "/" . $date->format('Y') . "a las " . $date->format("h:i");
}
