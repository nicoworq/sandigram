<?php
$this->load->view("common/header-dashboard", array("title" => "Tus cuentas"));
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

        <a class="uk-button uk-button-primary" href="<?php echo site_url("/accounts/new-account/") ?>">
            Agregar cuenta
        </a>

        <br/>
        <br/>

        <?php if (!count($accounts)) { ?>
            <div class="uk-placeholder uk-text-center">
                No has cargado ninguna cuenta.
            </div>
        <?php } ?>

        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>

            <?php foreach ($accounts as $account) { ?>
                <a href="<?php echo site_url("/accounts/select-account/" . $account->id) ?>">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h3 class="uk-card-title"><?php echo $account->nombre ?></h3>                    
                    </div>
                </a>
            <?php } ?>

        </div>
    </div>
</div>



<?php
$this->load->view("common/footer-dashboard");

