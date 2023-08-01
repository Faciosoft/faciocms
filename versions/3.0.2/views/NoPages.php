<?php $faciocms_server_config = require_once("../server.config.php"); ?>

<div class="no-pages-error">
    <h1 class="error-title">Whoops!</h1>
    <h3 class="error-subtitle">It seems that this website has no pages</h3>

    <span class="thin-line darken"></span>

    <?php if($cms->user && $cms->user["permissions_level"] > 0): ?>
        <div class="logged-content">
            <a class="cms-btn" role="button" href="/admin/pages">Admin panel</a>
            <a class="cms-btn" role="button" href="/admin/logout"><em class="fas fa-sign-out-alt"></em> Sign out</a>
        </div>
    <?php else: ?>
        <div class="unlogged-content">
            <h5>If you see this you can report it to site owner</h5>
            <a class="link" href="https://app.faciocms.com/visitor/<?php echo $faciocms_server_config["faciocms"]["app_id"]; ?>/report-bug/empty-site">Report here</a>
        </div>
    <?php endif; ?>

    <span class="thin-line darken"></span>

    <footer>
        <?php $cms->IncludeComponent('Powered'); ?>
    </footer>
</div>

<style>
    .no-pages-error {
        width: 100%;
        height: 100vh;
        padding: 120px 24px;
        
        text-align: center;
        
        background: #dfe4eb;
        color: #1b2029;
        box-shadow: inset 0 0 16px 8px #0004;
    }

    .error-title {
        font-size: 64px;
        font-weight: 900;
        color: #fff;
        text-shadow: -2px -2px #1b2029, -2px 2px #1b2029, 2px -2px #1b2029, 5px 5px #1b2029;
    }

    .error-subtitle {
        margin-top: 16px;
    }

    .thin-line {
        width: 50%;
        margin: 48px auto;
        border-radius: 4px;
    }

    .link {
        color: #0099ff;
        text-decoration: none;
        font-size: 20px;
        margin-top: 12px;
        display: block; 
    }

    .cms-btn {
        text-decoration: none;
        display: inline-block;

        background: rgb(252, 51, 51);
        color: #fff;
        box-shadow: 2px 2px 8px #0004;

        padding: 7.5px 12.5px;
        border-radius: 8px;
    }
</style>