<?php
$this->load->view("common/header-dashboard", array("title" => "Publicaciones"));

?>

<div class="uk-container">
    <div class="uk-section">
        <?php
        if ($alert) {
            ?>
            <div class="uk-alert-<?php echo $alert; ?>" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php echo $alert_message; ?></p>
            </div>
            <?php
        }
        ?>

        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>

            <a href="<?php echo site_url("/posts/new-post") ?>">
                <div class="uk-card uk-card-default uk-card-body">
                    <h3 class="uk-card-title">Crear publicación</h3>
                    <p>Selecciona para crear una nueva publicación</p>
                </div>
            </a>
            <?php foreach ($posts as $post) { ?>                   
                <a href="<?php echo site_url("/posts/{$post->id_publicacion}" ) ?>">
                    <div>
                        <div class="uk-card uk-card-default">
                            <?php
                            $label = $post->estado;
                            $label_color = getLabelColor($post->id_estado);
                            ?>
                            <div class="uk-card-badge uk-label <?php echo $label_color; ?>"><?php echo $label; ?></div>
                            <div class="uk-card-media-top">
                                <div class="uk-card-media-bg" style="background-image: url(<?php echo get_image_src($post->nombre_archivo) ?>)"></div>                                
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo $post->nombre ?></h3>
                                <p class="uk-text-meta uk-margin-remove-top"><time datetime="<?php echo $post->fecha_publicacion; ?>"><?php echo getDateHuman($post->fecha_publicacion); ?></time></p>

                            </div>
                        </div>
                    </div>
                </a> 
            <?php } ?>
        </div>
    </div>
</div>


<?php



function getLabelColor($id_estado) {
    $color = "";
    switch ($id_estado) {
        case 1:
            $color = "";
            break;
        case 2:
            $color = "uk-label-success";
            break;
        case 3:
            $color = "uk-label-danger";
            break;
    }
    return $color;
}

$this->load->view("common/footer-dashboard");
