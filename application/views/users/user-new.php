<?php
$this->load->view("common/header-dashboard", array("title" => "Usuarios"));
?>

<div class="uk-container">
    <div class="uk-section-xsmall">

        <a class="uk-link-muted" href="<?php echo site_url("users") ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" ratio="1"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4"></polyline></svg>
            Volver al listado
        </a>
        <h2 class="uk-text-lead">Agregar usuario</h2>

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

        <form id="form-user" novalidate class="<?php //echo $clase_form;   ?> uk-form-stacked" method="POST" action="<?php echo site_url("users/new-user-action") ?>">

            <div class="uk-margin">
                <div class="uk-form-controls">
                    <input class="uk-input validate-input" name="nombre" placeholder="Nombre" required value="<?php echo $nombre; ?>" />
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-controls">
                    <input class="uk-input validate-input" name="email" placeholder="Email" required value="<?php echo $email; ?>" />
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-controls">
                    <input class="uk-input validate-input" name="password" placeholder="Password" required value="" />
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-controls">
                    <input class="uk-input validate-input" name="password2" placeholder="Repetir Password" required value="" />
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">                    
                    <button id="subir-publicacion" class="uk-button uk-button-primary" disabled>Crear usuario</button>
                </div>
            </div>

        </form>

    </div>
</div>


<?php $this->load->view("common/footer-dashboard"); ?>