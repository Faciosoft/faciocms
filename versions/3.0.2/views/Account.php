<?php $faciocms_server_config = require_once("../server.config.php"); ?>
<?php 
    // \FacioCMS\Versions\v3\App\Source\faciocode_encrypt_string
    $global_id = ($cms->user["id"] . ':' . $faciocms_server_config["faciocms"]["app_id"]);
    $global_id_hashed = \FacioCMS\Versions\v3\App\Source\faciocode_encrypt_string($global_id);

    $is_connected = false;
?>
<script>window.globalUserId = '<?php echo $global_id_hashed; ?>';</script>
<div class="account">
    <div class="account-top d-flex justify-content-start">
        <div class="account-top-left">
            <img class="avatar" src="<?php echo $cms->GetUserAvatar(); ?>" alt="">
        </div>

        <div class="account-top-right">
            <h2><?php echo $cms->user["username"]; ?> <strong>(<?php echo $cms->GetUserRoleByPermissionLevel($cms->user["permissions_level"]); ?>)</strong></h2>
            <span class="lead text gray">ID: <?php echo $global_id; ?></span>
        </div>
    </div>

    <div class="account-details p-3">
        <span class="thin-line"></span>
        
        <?php if($cms->user["email"] && $cms->user["email"] !== ""): ?>
        <div class="detail">
            <h5>E-mail:</h5>
            <span class="gray"><?php echo $cms->user["email"]; ?></span>
        </div>

        <span class="thin-line"></span>
        <?php endif; ?>

        <!-- SOON <div class="detail">
            <?php if(!$is_connected): ?>
                <div class="cloud-connect-center d-flex flex-column align-items-center">
                    <em class="fas fa-exclamation-triangle mb-3 icon-xl blazing"></em>
                    <h5><?php $cms->PrintTranslate('not_connected_with_cloud'); ?></h5>

                    <button class="cms-btn mt-3" @click="connectAccounts"><?php $cms->PrintTranslate('connect_with_cloud'); ?></button>
                </div>
            <?php endif; ?>
        </div>

        <span class="thin-line"></span> -->

        <div class="detail">
            <h5>Created at:</h5>
            <span class="gray"><?php echo $cms->user["created_at"]; ?></span>
        </div>
    </div>
</div>