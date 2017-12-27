<?php
$this->load->view("common/header-dashboard", array("title" => "Crear cuenta"));
?>

<div class="uk-container">
    <div class="uk-section">

        <form class="uk-form-stacked" method="POST" action="<?php echo site_url("/accounts/new-account-action") ?>">

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Nombre de la cuenta</label>
                <div class="uk-form-controls">
                    <input required class="uk-input uk-form-width-large" name="nombre" id="form-stacked-text" type="text" placeholder="Cuenta">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline">                    
                    <button class="uk-button uk-button-primary">Crear cuenta</button>
                </div>
            </div>

        </form>
    </div>

</div>
<?php
$this->load->view("common/footer-dashboard");

