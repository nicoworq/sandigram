<?php
$this->load->view("common/header-dashboard", array("title" => "Dashboard"));
?>

<div class="uk-container">
    <div class="uk-section">

        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>

            <a href="<?php echo site_url("/posts/new-post") ?>">
                <div class="uk-card uk-card-default uk-card-body">
                    <h3 class="uk-card-title">Crear publicación</h3>
                    <p>Selecciona para crear una nueva publicación</p>
                </div>
            </a>
            <?php foreach ($posts as $post) { ?>
                <a href="<?php echo site_url("/accounts/select-account/" . $post->id) ?>">
                    <div class="uk-card uk-card-default uk-card-body">
                        <h3 class="uk-card-title"><?php echo $post->nombre ?></h3>                    
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>


<?php
$this->load->view("common/footer-dashboard");
