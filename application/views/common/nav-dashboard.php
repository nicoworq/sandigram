<?php
$routeClass = $this->router->fetch_class();
?>
<div uk-sticky="animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent ; top: 200">
    <nav class="uk-navbar-container">
        <div class="uk-container uk-container-expand">
            <div uk-navbar>
                <ul class="uk-navbar-nav">
                   <!-- <li class="<?php navActiva($routeClass, "dashboard"); ?>">
                        <a href="<?php echo site_url("dashboard") ?>">Dashboard</a>
                    </li>-->
                    <li class="<?php navActiva($routeClass, "posts"); ?>">
                        <a href="<?php echo site_url("posts") ?>">Publicaciones</a>
                    </li>
                    <li class="<?php navActiva($routeClass, "media"); ?>">
                        <a href="<?php echo site_url("media") ?>">Medios</a>
                    </li>                    
                    <li class="<?php navActiva($routeClass, "accounts"); ?>">
                        <a href="<?php echo site_url("accounts") ?>">Cuentas</a>
                    </li>
                </ul>
                <div id="active-account"><?php echo $active_account->nombre; ?></div>
            </div>
        </div>
    </nav>
</div>
<?php

function navActiva($routeClass, $menu) {
    echo $routeClass === $menu ? "uk-active" : "";
}
