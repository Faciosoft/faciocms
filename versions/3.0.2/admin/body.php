<div id="faciocms-admin">
    <?php if($cms->IsLogged()): ?>
        <div class="row margin-0">
            <?php $cms->IncludeComponent('Sidebar'); ?>
            <?php $cms->IncludeComponent('ViewContainer'); ?> 
        </div>
    <?php else: ?>
        <?php 
            $cms->View('Login', [ 
                "cms" => $cms 
            ]); 
        ?>
    <?php endif; ?>

    <?php $cms->IncludeComponent('ContextMenu'); ?>
</div>

<?php /* <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script> */ ?>

<?php /* ===== STARTOF: FacioCMS Core JS ===== */ ?>
<?php \FacioCMS\Includes::AdminIncludeScript('versions/' . $cms->generator_version . '/scripts/tinymce/tinymce.min.js', $cms->generator_version); ?>
<?php \FacioCMS\Includes::AdminIncludeScript('versions/' . $cms->generator_version . '/scripts/dist/admin.js', $cms->generator_version); ?>
<?php /* ===== ENDOF: FacioCMS Core JS ===== */ ?>