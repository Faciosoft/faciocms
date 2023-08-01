<?php
    $url = $_SERVER["REQUEST_URI"];
    $url_path_parts = explode("/", $url);

    $page_id = count($url_path_parts) >= 4 ? \FacioCMS\Versions\v3\App\Source\decrypt_faciocode($url_path_parts[3]) : -1;
    $page = $cms->GetPage($page_id);
?>
<?php if($page_id > -1 && $page): ?>
    <script>window.secureContent=`<?php echo addslashes($page["content"]); ?>`;</script>
    <script>window.secureDefaultMetaSettings=<?php echo json_encode(FACIOCMS_EMPTY_PAGE_META_KEYS); ?>;</script>
    <script>window.pageUrl=`<?php echo $page["fullUrl"];?>`;</script>
    <script>window.onScriptLoaded(() => window.setDisplayView('editor'))</script>

    <div class="page-editor">
        <h1 class="welcome-header"><u><?php echo $page["title"]; ?></u></h1>

        <span class="thin-line mb-4"></span>

        <div class="navigation-container mb-3 mb3">
            <button @click="() => setViewWithEditor('editor')" :class="`cms-btn ${view === 'editor' ? 'active' : ''}`"><?php $cms->PrintTranslate('Basic'); ?></button>
            <button @click="() => setViewWithEditor('meta')" :class="`cms-btn ${view === 'meta' ? 'active' : ''}`"><?php $cms->PrintTranslate('Settings'); ?></button>
            <button @click="() => setViewWithEditor('gallery')" :class="`cms-btn ${view === 'gallery' ? 'active' : ''}`"><?php $cms->PrintTranslate('Gallery'); ?></button>
        </div>

        <div id="page-path">
            <em class="fas fa-newspaper"></em> <strong class="delimeter">&gt;</strong> <?php echo $page["title"]; ?> <strong class="delimeter">&gt;</strong> {{ capitalize(view) }}
        </div>

        <span class="thin-line"></span>

        <div class="view-container">

            <div class="view-editor view" v-if="view === 'editor'">
                <PageEditor
                    _title="<?php echo $page["title"]; ?>"
                    _subtitle="<?php echo $page["subtitle"]; ?>"
                    :_content="secureContent"
                    _layout="<?php echo $page["layout"]; ?>"
                    _layouts="<?php echo urlencode(json_encode($cms->GetLayouts())); ?>"
                    _url="<?php echo $page["url"]; ?>"
                    id="<?php echo $page["id"]; ?>"
                    text_title="<?php $cms->PrintTranslate('Title'); ?>"
                    text_subtitle="<?php $cms->PrintTranslate('Subtitle'); ?>"
                    text_content="<?php $cms->PrintTranslate('Content'); ?>"
                    text_save="<?php $cms->PrintTranslate('Save'); ?>"
                    text_layout="<?php $cms->PrintTranslate('Layout'); ?>"
                    text_url="<?php $cms->PrintTranslate('Url'); ?>"
                    text_preview="<?php $cms->PrintTranslate('Preview'); ?>"
                ></PageEditor>
            </div>

            <div class="view-meta view" v-else-if="view === 'meta'">
                <div class="top-flex top-right">
                    <div class="top-flex toggle-show-secret-meta-settings">
                        <?php if($cms->HasAtLeast("Admin")): ?>
                            <em class="help secret-icon fas fa-exclamation-triangle" title="<?php $cms->PrintTranslate('txt_11'); ?>"></em> <label class="form-label" for="show-secret-meta-settings"><?php $cms->PrintTranslate('txt_10'); ?></label> 
                            <input class="checkbox" id="show-secret-meta-settings" type="checkbox" v-model="show_secret_meta_settings">
                        <?php endif; ?>
                    </div>

                    <button class="cms-btn mb-0" @click="createMetaSetting(<?php echo $page["id"]; ?>)"> Add new <em class="fas fa-plus icon"></em></button>
                </div>

                <?php $meta_settings = $cms->GetAllMetaSettings($page["id"]); ?>
                <form class="meta-setting-container" name="form-meta-settings">
                    <?php foreach($meta_settings as $key => $setting): ?>
                        <?php $is_secret = $cms->IsSecretMetaSetting($setting["name"]); ?>
                        <?php // if($is_secret) continue; ?>

                        <div class="setting" v-if="!<?php echo $is_secret ? 'true' : 'false'; ?> || show_secret_meta_settings">
                            <label 
                                for="meta_<?php echo $setting["name"]; ?>" 
                                class="setting-title pointer" 
                                title="Raw: <?php echo $setting["name"]; ?>">
                
                                <?php if($is_secret): ?>
                                    <em class="help secret-icon fas fa-exclamation-triangle" title="<?php $cms->PrintTranslate('txt_11'); ?>"></em>
                                    <em class="help secret-icon fas fa-mask" title="<?php $cms->PrintTranslate('txt_12'); ?>"></em>
                                <?php endif; ?>

                                <?php echo $cms->FormatName($setting["name"]); ?>

                            </label>

                            <?php 
                                // Getting the type of key/value pair
                                // Default type is text
                                $type = 'text'; 

                                // Number
                                if(is_numeric($setting["value"])) {
                                    $type = 'number';

                                    if($setting["value"] == 0 || $setting["value"] == 1) $type = 'boolean';
                                }

                                // Advanced type - It contains json as value (scalable meta option)
                                json_decode($setting["value"]);
                                if(json_last_error() === JSON_ERROR_NONE && $type !== 'number' && $type !== 'boolean') $type = 'advanced';
                            ?>

                            <div class="setting-value">
                                <?php if($type === 'text'): ?>

                                    <input 
                                        return-value
                                        class="cms-input" 
                                        id="meta_<?php echo $setting["name"]; ?>" 
                                        name="meta_<?php echo $setting["name"]; ?>" 
                                        type="text" 
                                        value="<?php echo $setting["value"]; ?>">
                                        
                                <?php elseif($type === 'number'): ?>
                                
                                    <input 
                                        return-value
                                        class="cms-input" 
                                        id="meta_<?php echo $setting["name"]; ?>" 
                                        name="meta_<?php echo $setting["name"]; ?>" 
                                        type="number" 
                                        value="<?php echo $setting["value"]; ?>">
                                
                                <?php elseif($type === 'boolean'): ?>
                                    
                                    <input 
                                        return-value
                                        class="checkbox" 
                                        id="meta_<?php echo $setting["name"]; ?>" 
                                        name="meta_<?php echo $setting["name"]; ?>" 
                                        type="checkbox" 
                                        value="<?php echo $setting["value"]; ?>" <?php echo $setting["value"] == 1 ? "checked" : ""; ?>>

                                <?php else: ?>
                                    
                                    Currently complex type settings are under maintaince
                                
                                <?php endif; ?>

                                <button 
                                    v-if="!page_default_meta_keys.includes('<?php echo $setting["name"]; ?>')"
                                    class="btn-delete cms-btn" 
                                    @click="deleteMetaSetting(<?php echo $page["id"]; ?>, '<?php echo $setting["name"]; ?>')"
                                    ><em class="fas fa-times no"></em></button>
                            </div>
                        </div>

                        <?php if(count($meta_settings) - 1 !== $key): ?>
                            <span class="thin-line" v-if="!<?php echo $is_secret ? 'true' : 'false'; ?> || show_secret_meta_settings"></span>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </form>

                <div class="row form-group mt-5">
                    <div class="col-md-12">
                        <div class="form-group save">
                            <span class="text-success" @click="success_text = ''">{{ success_text }}</span>
                            <button class="success-cms-btn" @click="saveMetaSettings(<?php echo $page["id"]; ?>)" type="button"> <?php $cms->PrintTranslate('Save'); ?> <em class="fas fa-save"></em> </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php $gallery = $cms->GetCurrentGallery();?>
            <script>window.currentGallery = <?php echo json_encode($gallery); ?></script>

            <div class="view-gallery view" v-if="view === 'gallery'">
                <GalleryUploader page_id="<?php echo $page["id"] ?>" text="<?php $cms->PrintTranslate('txt_18'); ?>"></GalleryUploader>
                <h4 class="mt-5"><em class="fas fa-image mr-8px blazing"></em> <?php $cms->PrintTranslate('Images'); ?>: <?php echo count($gallery); ?></h4>

                <div class="gallery-container">
                    <?php foreach($gallery as $key => $image): ?>
                        <div class="gallery-image" @click="openGalleryItem(<?php echo $key; ?>)">
                            <img class="full-image fluid" src="<?php echo $image->path; ?>" alt="">
                        </div>
                    <?php endforeach; ?> 
                </div>

                <?php if(empty($gallery)): ?>
                    <div class="center-message mt-5 mb-5">
                        <em class="far fa-image mb-3 logo-icon"></em>

                        <h3><?php $cms->PrintTranslate('txt_19'); ?></h3>
                        <h5 class="gray"><?php $cms->PrintTranslate('txt_20'); ?></h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="gallery-modal" v-if="galleryOpened">
            <div class="backdrop" @click="closeGalleryItem"></div>

            <div class="content">
                <img :src="window.currentGallery[galleryIndex].path" alt="">
            </div>

            <button @click="changeGalleryNavigation(-1)" class="btn-arrow first"><em class="fas fa-chevron-left no"></em></button>
            <button @click="changeGalleryNavigation(+1)" class="btn-arrow second"><em class="fas fa-chevron-right no"></em></button>

            <div class="index">{{ galleryIndex + 1 }} / {{ window.currentGallery.length }}</div>

            <button class="cms-btn btn-iconed" @click="deleteGalleryImage">Delete <em class="fas fa-trash"></em></button>
        </div>

        <!-- <span class="thin-line"></span>
        <div class="page-editor__info">
            <span class="info-label">
                Id: <?php echo $page["id"]; ?>
            </span> 
            <span class="vertical-line"></span>
            <span class="info-label">
                Created at: <?php echo $page["created_at"]; ?>
            </span> 
            <span class="vertical-line"></span>
            <span class="info-label">
                Updated at: <?php echo $page["updated_at"]; ?>
            </span> 
            <span class="vertical-line"></span>
            <span class="info-label">
                Updated by: <?php echo $page["updated_by"]; ?>
            </span> 
        </div> 
        <span class="thin-line"></span> -->
    </div> 
<?php else: ?>
    <?php $cms->View('404', []); ?>
<?php endif; ?>