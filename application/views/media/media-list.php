<?php
$this->load->view("common/header-dashboard", array("title" => "Publicaciones"));
?>

<div class="uk-container">
    <div class="uk-section-xsmall">

        <?php
        if (!is_null($active_account)) {
            ?>
            <a href="#" class="uk-button uk-button-primary">
                Subir media
            </a>                    
            <?php
        }
        ?>

        <br/>
        <br/>


        <?php if (!count($media_list)) { ?>
            <div class="uk-placeholder uk-text-center">
                No has subido ningun medio.
            </div>
        <?php } ?>
        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>


            <?php foreach ($media_list as $media) { ?>      

                <a href="#">
                    <div>
                        <div class="uk-card uk-card-default sandigram-post">
                            <div class="uk-card-media-top">
                                <div class="uk-card-media-bg" style="background-image: url(<?php echo get_image_src($media->nombre_archivo) ?>)"></div>                                
                            </div>
                        </div>
                    </div>
                </a> 
            <?php } ?>
        </div>
    </div>
</div>

<?php
$this->load->view("common/footer-dashboard");
