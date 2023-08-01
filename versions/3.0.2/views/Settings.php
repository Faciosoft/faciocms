<?php
    $size_of_cache = 0;

    foreach(scandir("../cache/pages") as $page) {
        if($page === "." || $page === "..") continue;

        $size_of_cache += filesize("../cache/pages/$page");
    }

    // Versions
    $versions = json_decode(file_get_contents("../versions/versions.json"));
    $current_version = $cms->generator_version;
?>

<script>window.onScriptLoaded(() => window.setDisplayView('General'))</script>
<script>
    window.secureData = {
        prod_mode: <?php echo $cms->GetSetting('prod')->value; ?>,
        auto_updates: <?php echo $cms->GetSetting('autoupdate')->value; ?>,
        website_name: "<?php echo $cms->GetSetting('website_name')->value; ?>",
        website_url: "<?php echo $cms->GetSetting('website_url')->value; ?>",
        theme_color: "<?php echo $cms->GetSetting('theme_color')->value; ?>",
        secondary_color: "<?php echo $cms->GetSetting('secondary_color')->value; ?>",
        super_caching: <?php echo $cms->GetSetting('supercaching')->value; ?>,
        version: "<?php echo $current_version; ?>"
    }
</script>

<h1 class="welcome-header"><?php $cms->PrintTranslate('Settings'); ?></h1>
<div class="settings-panel mt-4">
    <ViewSelector
        @view-select="(view) => setView(view)"
        :views="['<?php $cms->PrintTranslate('General'); ?>', '<?php $cms->PrintTranslate('OptimalizationAndCaching'); ?>', '<?php $cms->PrintTranslate('Updates'); ?>', '<?php $cms->PrintTranslate('Versions'); ?>']"
        :view="view"
    ></ViewSelector>

    {{ initSettings() }}

    <div class="settings-container">
        <div id="page-path">
            <em class="fas fa-cog"></em> <strong class="delimeter">&gt;</strong> <?php $cms->PrintTranslate('Settings'); ?> <strong class="delimeter">&gt;</strong> {{ view }}
        </div>

        <span class="thin-line"></span>

        <div class="settings-view view" v-if="view === '<?php $cms->PrintTranslate('General'); ?>'">
            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="website-name">Website name</label></h3>

                <div class="d-flex align-items-center">
                    <input class="setting-group__item cms-input" id="website-name" type="text" v-model="settings.opt_cache.website_name">
                </div>
            </div>

            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="production-mode">Website url</label></h3>

                <div class="d-flex align-items-center">
                    <input class="setting-group__item cms-input" id="production-mode" type="text" v-model="settings.opt_cache.website_url">
                </div>
            </div>

            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="production-mode">Theme color</label></h3>

                <div class="d-flex align-items-center">
                    <input class="setting-group__item cms-color-input" id="production-mode" type="color" v-model="settings.opt_cache.theme_color">
                </div>
            </div>
            
            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="production-mode">Secondary color</label></h3>

                <div class="d-flex align-items-center">
                    <input class="setting-group__item cms-color-input" id="production-mode" type="color" v-model="settings.opt_cache.secondary_color">
                </div>
            </div>
        </div>

        <div class="settings-view view" v-else-if="view === '<?php $cms->PrintTranslate('OptimalizationAndCaching'); ?>'">
            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="production-mode"><?php $cms->PrintTranslate('Prod_mode'); ?></label></h3>

                <div class="d-flex align-items-center">
                    <span class="setting-group__subtitle"><?php $cms->PrintTranslate('txt_5'); ?></span> 
                    <input :checked="settings.opt_cache.prod_mode" class="setting-group__item checkbox" id="production-mode" type="checkbox" v-model="settings.opt_cache.prod_mode">
                </div>
            </div>

            <span class="thin-line"></span>

            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="supercaching"><?php $cms->PrintTranslate('Super_Caching'); ?></label></h3>

                <div class="d-flex align-items-center">
                    <span class="setting-group__subtitle"><?php $cms->PrintTranslate('txt_23'); ?></span> 
                    <input :checked="settings.opt_cache.supercaching" class="setting-group__item checkbox" id="supercaching" type="checkbox" v-model="settings.opt_cache.supercaching   ">
                </div>
            </div>

            <div class="caching-data">
                <h5 class="lead gray"><?php $cms->PrintTranslate('Size_of_cache') ?>: <?php echo round($size_of_cache / 1024, 2); ?> kB</h5>

                <button class="cms-btn btn-iconed mt-3" @click="ClearSuperCache"> <?php $cms->PrintTranslate('Clear'); ?> <em class="fas fa-trash"></em></button>
            </div>

        </div>

        <div class="settings-view view" v-else-if="view === '<?php $cms->PrintTranslate('Updates'); ?>'">
            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="auto-updates"><?php $cms->PrintTranslate('Auto_updates'); ?></label></h3>

                <div class="d-flex align-items-center">
                    <span class="setting-group__subtitle"><?php $cms->PrintTranslate('txt_6'); ?></span> <input class="setting-group__item checkbox" id="auto-updates" type="checkbox" v-model="settings.opt_cache.auto_updates">
                </div>

                <span class="warning mt-5 mt5"><strong class="">Warning: </strong> auto updates currently doesn't works</span>
            </div>
        </div>

        <div class="settings-view view" v-else-if="view === '<?php $cms->PrintTranslate('Versions'); ?>'">
            <div class="setting-group mt-3">
                <h3 class="setting-group__title"><label for="version-select"><?php $cms->PrintTranslate('Versions'); ?></label></h3>

                <div class="form">
                    <select class="editor-form__input form-input" id="version-select" name="version" v-model="settings.opt_cache.version">
                        <?php foreach($versions as $version): ?>
                            
                            <option 
                                value="<?php echo $version->version; ?>" 
                                <?php if($current_version == $version->version): ?> selected<?php endif; ?>
                            ><?php echo $version->version; ?></option>
                            
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex justify-content-end align-items-center mt-4">
                    <button class="cms-btn">Install new version</button>
                </div>

                <span class="warning mt-3 mt3"><strong class="">Warning: </strong> installing versions soon</span>
            </div>
        </div>

        <span class="thin-line"></span>

        <div class="d-flex justify-content-end align-items-center mt-4" v-if="view === '<?php $cms->PrintTranslate('Versions'); ?>'">
            <span class="text-success save-success-text" @click="info.settings.opt_cache.error = ''">{{ info.settings.opt_cache.error }}</span>
            <button class="cms-btn mb-0" @click="saveVersion"> <?php $cms->PrintTranslate('Save'); ?> <em class="fas fa-save"></em> </button>
        </div>
        <div class="d-flex justify-content-end align-items-center mt-4" v-else>
            <span class="text-success save-success-text" @click="info.settings.opt_cache.error = ''">{{ info.settings.opt_cache.error }}</span>
            <button class="cms-btn mb-0" @click="saveSettings"> <?php $cms->PrintTranslate('Save'); ?> <em class="fas fa-save"></em> </button>
        </div>
    </div>
</div>  