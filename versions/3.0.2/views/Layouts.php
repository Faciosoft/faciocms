<script>window.onScriptLoaded(() => window.setDisplayView('layouts'))</script>
<?php $faciocms_server_config = require_once("../server.config.php"); ?>

<div class="top-flex d-flex justify-content-between">
    <h1><?php $cms->PrintTranslate('Layouts'); ?></h1>
    
    <div class="buttons">
        <button @click="() => openWindow('https://faciocms.com/marketplace/layouts')" class="cms-btn btn-iconed"> <?php $cms->PrintTranslate('DownloadLayout'); ?> <em class="fas fa-download"></em></button>
        <!-- <button @click="() => openWindow('https://faciocms.com/layouts/migrate')" class="cms-btn btn-iconed"> <?php $cms->PrintTranslate('MigrateFromCloud'); ?> <em class="fas fa-download"></em></button> -->

        <button @click="() => setView('create-layout')" class="cms-btn btn-iconed" v-if="view === 'layouts'"> <?php $cms->PrintTranslate('CreateLayout'); ?> <em class="fas fa-plus"></em></button>
        <button @click="() => setView('layouts')" class="cms-btn btn-iconed" v-if="view === 'create-layout'"> <?php $cms->PrintTranslate('Back'); ?> <em class="fas fa-arrow-left"></em></button>
    </div>
</div>

<div class="layouts-container" v-if="view === 'layouts'">
    <?php $layouts = $cms->GetAllLayouts(); ?>

    <?php foreach($layouts as $layout): ?>
        <div class="layout-tile">
            <header class="layout-tile__title"><?php echo $layout->name; ?> v.<?php echo $layout->version; ?></header>
            <header class="layout-tile__fcms-version">
                <?php $cms->PrintTranslate('Compatibile'); ?> <?php $cms->PrintTranslate('With'); ?> FacioCMS
                v.<?php echo $layout->requirements->faciocms->version->min; ?>
                <?php if($layout->requirements->faciocms->version->max == 'unset'): ?>
                    +
                <?php else: ?>
                    - v.<?php echo $layout->requirements->faciocms->version->max; ?>
                <?php endif; ?>
            </header>

            <div class="buttons">
                <?php /*<a href="/admin/layout/<?php echo $layout->name ?>" class="cms-btn" role="button"><em class="fas fa-pen"></em></a> */ ?>
                <?php if($cms->HasAtLeast("Admin")): ?>
                    <button @click="deleteLayout('<?php echo $layout->name; ?>')" class="cms-btn" role="button"><em class="fas fa-trash no"></em></button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="layout-create mt-3" v-else-if="view === 'create-layout'">
    <form class="create-user cms-form full-width">
        <h3 class="mb-3"><?php $cms->PrintTranslate('CreateLayout'); ?></h3>

        <div class="form-group">
            <label class="form-label" for="name"><?php $cms->PrintTranslate('Name'); ?></label>
            <input id="name" type="text" class="form-input" v-model="forms.layouts.createLayout.name"> 
        </div>

        <button type="button" class="cms-btn" @click="createLayout"><?php $cms->PrintTranslate('Create'); ?></button>
    </form>
</div>