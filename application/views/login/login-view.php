<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?php asset_url() ?>css/uikit.min.css" />
        <script src="<?php asset_url() ?>js/uikit.min.js"></script>
        <script src="<?php asset_url() ?>js/uikit-icons.min.js"></script>
    </head>
    <body class="uk-height-1-1">
        <div class="uk-vertical-align uk-text-center uk-height-1-1">

            <div class="uk-vertical-align-middle ">

                <form class="uk-card uk-card-body" action="<?php echo site_url('/login-action') ?>" method="POST">
                    <?php
                    if ($error) {
                        echo $error;
                    }
                    ?>
                    <h1 class="uk-card-title">Iniciar sesión</h1>
                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input" type="text" name="email" placeholder="Email" value="<?php echo $email; ?>">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input class="uk-input" type="password" name="password" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="uk-margin">
                        <div class="uk-inline">                    
                            <button class="uk-button uk-button-primary">Iniciar sesión</button>
                        </div>
                    </div>

                    <div class="uk-inline">                    
                        <a href="#" class="uk-text-small">Olvidaste tu contraseña? Que garrón..</a>
                    </div>


                </form>
            </div>

        </div>


    </body>
</html>