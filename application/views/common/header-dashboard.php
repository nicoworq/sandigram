<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php asset_url() ?>css/uikit.min.css" />
        <link rel="stylesheet" href="<?php asset_url() ?>css/sandia.css" />
       
    </head>
    <body class="uk-background-muted" style="min-height: 100vh">

        <?php $this->load->view("common/nav-dashboard"); ?>
