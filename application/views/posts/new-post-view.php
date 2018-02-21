<?php
$this->load->view("common/header-dashboard", array("title" => "Nueva publicación"));
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="uk-container">
    <div class="uk-section-xsmall">
        <h2 class="uk-text-lead">Nueva publicación</h2>
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

        <form class="uk-form-stacked" method="POST" action="<?php echo site_url("posts/new-post-action") ?>">
            <input id="id_medio" type="hidden" name="id_medio" value=""/>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Nombre de la publicación</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="nombre" type="text" placeholder="Nombre" required value="<?php echo $nombre; ?>" />
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Texto de la publicación</label>
                <div class="uk-form-controls">
                    <textarea class="uk-textarea validate-change" rows="5" name="texto" type="text" placeholder="Texto" required><?php echo $texto; ?></textarea>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Subir archivo multimedia (gif | jpg | png | mp4)</label>
                <div class="uk-form-controls">
                    <div id="input-file-sandigram">
                        <p id="msg"></p>
                        <input type="file" id="file" name="file" /><br/>
                        <div id="imagen-preview">

                        </div>
                        <div id="upload" class="uk-button uk-button-default">Subir Archivo</div>
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Tipo de publicación</label>
                <div class="uk-form-controls">
                    <select name="id_tipo" class="uk-select">
                        <option value="1" selected="selected">Timeline</option>
                        <option value="2">Story</option>
                    </select>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Fecha publicación</label>
                <div class="uk-form-controls">
                    <input class="uk-input validate-change" id="picker-publicacion" type="text" value="<?php echo $fecha_publicacion; ?>" name="fecha_publicacion"/>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline">                    
                    <button id="subir-publicacion" class="uk-button uk-button-primary" disabled>Crear publicación</button>
                </div>
            </div>


        </form>



    </div>
</div>


<?php
$this->load->view("common/footer-dashboard");
