<?php $faciocms_server_config = require_once("../server.config.php"); ?>

<div class="top-flex d-flex justify-content-between">
    <h1><?php $cms->PrintTranslate('plugins'); ?></h1>
    
    <div class="buttons">
        <button @click="() => openWindow('https://faciocms.com/marketplace/plugins')" class="cms-btn btn-iconed"> <?php $cms->PrintTranslate('DownloadPlugin'); ?> <em class="fas fa-download"></em></button>
    </div>
</div>

<div class="plugins-container">
    <?php $plugins = $cms->GetInitializedPlugins(); ?>

    <?php foreach($plugins as $plugin): ?>
        <div class="plugin-tile">
            <header class="plugin-tile__title"><?php echo $plugin->GetName(); ?> </header>
            <header class="plugin-tile__fcms-version">
            v.<?php echo $plugin->GetConfig()->versions->plugin; ?>
            </header>

            <div class="buttons">
                <a href="/admin/plugin/<?php echo $plugin->GetName() ?>" class="cms-btn btn-iconed" role="button"> <?php $cms->PrintTranslate('Config'); ?> <em class="fas fa-cog"></em></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>