<?php
$this->load->view("common/header-dashboard", array("title" => "Editar publicación"));
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="uk-container">
        <div class="uk-section-xsmall">
            <a class="uk-link-muted" href="<?php echo site_url("posts") ?>">
                <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" ratio="1"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4"></polyline></svg>
                Volver al listado
            </a>
            <h2 class="uk-text-lead">Editar publicación</h2>
            <?php
            if ($alert) {
                ?>
                <div class="uk-alert-<?php echo $alert; ?>" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p><?php echo $alert_message; ?></p>
                </div>
                <?php
            }

            if (intval($post->id_estado) === 3) {

                foreach ($errores as $error) {
                    ?>
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <p><?php echo $error->texto_error; ?></p>
                    </div>
                    <?php
                }
            }
            ?>
            <?php
            $clase_form = "form-timeline";
            switch (intval($post->id_tipo)) {
                case 2:
                    $clase_form = "form-story";
                    break;
                case 3:
                    $clase_form = "form-poll";
                    break;
            }
            ?>
            <form id="form-post" novalidate class="<?php echo $clase_form; ?> uk-form-stacked" method="POST" action="<?php echo site_url("posts/edit-post-action") ?>">
                <input id="id_publicacion" type="hidden" name="id_publicacion" value="<?php echo $post->id_publicacion ?>"/>
                <input id="id_medio" type="hidden" name="id_medio" value="<?php echo $post->id_medio ?>"/>
                <input type="hidden" name="pos_x" value="<?php echo $post->pos_x; ?>"/>
                <input type="hidden" name="pos_y" value="<?php echo $post->pos_y; ?>"/>
                <div class="uk-margin">
                    <div class="uk-form-controls">
                        <input class="uk-input" name="nombre" type="hidden" placeholder="Nombre" required value="<?php echo $post->nombre; ?>" />
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Tipo de publicación</label>
                    <div class="uk-form-controls">
                        <select name="id_tipo" class="uk-select">
                            <option value="1" <?php echo intval($post->id_tipo) === 1 ? 'selected="selected"' : ''; ?>>Timeline</option>
                            <option value="2" <?php echo intval($post->id_tipo) === 2 ? 'selected="selected"' : ''; ?>>Story</option>
                            <option value="3" <?php echo intval($post->id_tipo) === 3 ? 'selected="selected"' : ''; ?>>Poll</option>
                        </select>
                    </div>
                </div>
                <!-- pools -->
                <div class="uk-margin poll-control" id="pregunta-publicacion">
                    <label class="uk-form-label" for="form-stacked-text">Pregunta publicación</label>
                    <div class="uk-form-controls">
                        <input class="uk-input validate-change" name="pregunta" value="<?php echo isset($post->pregunta) ? $post->pregunta : ""; ?>" type="text" placeholder="Pregunta publicación" required/>
                    </div>
                </div>  
                <div class="uk-margin poll-control" id="respuesta-2-publicacion">
                    <label class="uk-form-label" for="form-stacked-text">Respuesta 1</label>
                    <div class="uk-form-controls">
                        <input class="uk-input validate-change" name="respuesta_1" value="<?php echo isset($post->respuesta_1) ? $post->respuesta_1 : ""; ?>" type="text" placeholder="Respuesta 1" required/>
                    </div>
                </div>  
                <div class="uk-margin poll-control" id="respuesta-2-publicacion">
                    <label class="uk-form-label" for="form-stacked-text">Respuesta 2</label>
                    <div class="uk-form-controls">
                        <input class="uk-input validate-change" name="respuesta_2" value="<?php echo isset($post->respuesta_2) ? $post->respuesta_2 : ""; ?>" type="text" placeholder="Respuesta 2" required/>
                    </div>
                </div>  

                <!-- / polls -->
                <div class="uk-margin timeline-control" id="texto-publicacion" >
                    <label class="uk-form-label" for="form-stacked-text">Texto de la publicación</label>
                    <div class="uk-form-controls">
                        <textarea class="uk-textarea validate-change" rows="5" name="texto" type="text" placeholder="Texto" required><?php echo base64_decode($post->texto); ?></textarea>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Subir archivo multimedia</label>
                    <div class="uk-form-controls">
                        <div id="input-file-sandigram">
                            <p id="msg"></p>
                            <input type="file" id="file" name="file" /><br/>

                            <?php
                            if ($post->es_imagen) {
                                ?>
                                <div id="imagen-preview" class="activo" style="background-image: url( <?php echo base_url() . "uploads/{$post->nombre_archivo}"; ?>);">
                                    <?php
                                    if (intval($post->id_tipo) === 3) {
                                        ?>
                                        <div id="poll-preview" draggable="true">
                                            <div id="poll-preview-inner">
                                                <div id="poll-respuesta1" class="poll-respuesta"><?php echo $post->respuesta_1 ?></div>
                                                <div id="poll-respuesta2" class="poll-respuesta"><?php echo $post->respuesta_2 ?></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div id="imagen-preview" class="activo">
                                    <video src="<?php echo base_url() . "uploads/{$post->nombre_archivo}"; ?>" controls>                                        
                                    </video>
                                </div>
                                <?php
                            }
                            ?>

                            <div id="upload" class="uk-button uk-button-default">Subir Archivo</div>
                        </div>
                    </div>

                </div>

                <?php
                if (intval($post->id_estado) !== 2) {
                    ?>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Fecha publicación</label>
                        <div class="uk-form-controls">
                            <input class="uk-input validate-change" id="picker-publicacion" type="text" value="<?php echo $post->fecha_publicacion; ?>" name="fecha_publicacion"/>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline">                    
                            <button id="subir-publicacion" class="uk-button uk-button-primary" disabled>Editar publicación</button>
                            <a href="<?php echo site_url("posts/delete-post/{$post->id_publicacion}") ?>" id="eliminar-publicacion" class="uk-button uk-button-danger" disabled>Eliminar publicación</a>
                        </div>
                    </div>
                <?php } else { ?>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Fecha publicación</label>
                        <div class="uk-form-controls">
                            <input  class="uk-input" type="text" value="<?php echo getDateHuman($post->fecha_publicacion); ?>" name="fecha_publicacion"/>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline">                    
                            <a href="<?php echo site_url("posts") ?>" class="uk-button uk-button-primary">Volver al listado</a>
                            <a href="<?php echo site_url("posts/delete-post/{$post->id_publicacion}") ?>" id="eliminar-publicacion" class="uk-button uk-button-danger" disabled>Eliminar publicación</a>    
                        </div>
                    </div>


                <?php } ?>

            </form>



        </div>
    </div>


    <?php
    $this->load->view("common/footer-dashboard");
    