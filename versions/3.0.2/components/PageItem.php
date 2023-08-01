<details class="page page-<?php echo $page["id"]; ?>" @click="openPageDetails()" :open="IsExpanded(<?php echo $page["id"]; ?>)">
    <summary class="page-content" style="padding-left: <?php echo $depth * 6; ?>px" title="<?php $cms->PrintTranslate('ClickToExpand'); ?>">
        <div class="page-top">
            <div class="page-left">
                <a <?php if($cms->HasAtLeast("Moderator")): ?>href="/admin/page/<?php echo \FacioCMS\Versions\v3\App\Source\encrypt_faciocode($page["id"]); ?>"<?php endif; ?> class="page__title link"><?php echo $page["title"]; ?></a>
            </div>
            
            <div class="controls">
                <?php if($cms->HasAtLeast("Moderator")): ?>
                    <button class="times-tool-btn" @click="deletePage(<?php echo $page["id"]; ?>)"><em class="fas fa-trash"></em></button>
                    <a role="button" href="/admin/page/<?php echo \FacioCMS\Versions\v3\App\Source\encrypt_faciocode($page["id"]); ?>" class="success-tool-btn"><em class="fas fa-pen"></em></a>    
                    <button class="success-tool-btn" @click="createPage(<?php echo $page["id"]; ?>)"><em class="fas fa-plus"></em></button>
                <?php endif; ?>

                <span class="page-icon"></span>
            </div>
        </div>
        
    </summary>
    
    <div class="page__children">
        <?php foreach($page["children"] as $subpage): ?>
            <?php $cms->IncludeComponent("PageItem", [ "page" => $subpage, "depth" => $depth + 1 ]); ?>
        <?php endforeach; ?>
    </div>

    <!-- <div class="d-flex justify-content-center">
        <button class="cms-btn btn-iconed mt-2 mb-8px" @click="createPage(<?php echo $page["id"]; ?>)"> <?php $cms->PrintTranslate('CreatePage'); ?> <em class="fas fa-plus"></em></button>
    </div> -->
</details>