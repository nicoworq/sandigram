<?php
$this->load->view("common/header-dashboard", array("title" => "Usuarios"));
?>

<div class="uk-container">
    <div class="uk-section-xsmall">

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

        <a href="<?php echo site_url("/users/new") ?>" class="uk-button uk-button-primary">
            Crear usuario
        </a>

        <br/>
        <br/>


        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>

            <?php
            foreach ($usuarios as $usuario) {
                ?>
                <a href="<?php echo site_url("/users/{$usuario->id}") ?>">
                    <div>
                        <div class="uk-card uk-card-default sandigram-post">
                            <div class="uk-card-body ">
                                <p class="uk-text-meta uk-margin-remove-top  ">
                                    <?php echo $usuario->nombre ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </a> 

                <?php
            }
            ?>

        </div>

    </div>
</div>
<?php
$this->load->view("common/footer-dashboard");
