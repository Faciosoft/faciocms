<?php $faciocms_server_config = require("../server.config.php"); ?>

<footer class="admin-footer">
    <span class="thin-line"></span>

    <div class="top">
        <?php $cms->IncludeComponent('Powered'); ?> <span class="vertical-line"></span> 
        Copyright &copy; FacioCMS 2021 - <?php echo date("Y"); ?> <span class="vertical-line"></span> 
        Created by <a class="cms-link m-1" href="https://maciejdebowski.pl">Maciej Dębowski</a> <span class="vertical-line"></span> 
        <a class="cms-link" href="https://app.faciocms.com/dev">For developers</a> <span class="vertical-line"></span> 
        <a class="cms-link" href="/admin/license">License / Terms of usage</a>
    </div> 

    <span class="thin-line"></span>

    <span class="lead app-build-id">
        App Id: <?php echo $faciocms_server_config["faciocms"]["app_id"]; ?>
    </span>
</footer>