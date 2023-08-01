<div class="top-flex d-flex justify-content-between">
    <h1><?php $cms->PrintTranslate('Pages'); ?></h1>
    <div class="buttons">
        <button class="cms-btn btn-iconed" @click="toggleExpand()"> <?php $cms->PrintTranslate('Expand'); ?> <em class="fas fa-eye"></em></button> 
        <?php if($cms->HasAtLeast("Admin")): ?>
            <button class="cms-btn btn-iconed" @click="deleteAllPages()"> <?php $cms->PrintTranslate('DeleteAllPages'); ?> <em class="fas fa-trash"></em></button>
        <?php endif; ?>

        <?php if($cms->HasAtLeast("Moderator")): ?>
            <button class="cms-btn btn-iconed" @click="createPage()"> <?php $cms->PrintTranslate('CreatePage'); ?> <em class="fas fa-plus"></em></button>
        <?php endif; ?>
    </div>
</div>

<div class="pages-container">
    <?php $pages = $cms->GetPagesTree(); ?>

    <?php if(empty($pages)): ?>
        <div class="center-message mt-5 mb-5">
            <em class="far fa-folder-open mb-3 logo-icon"></em>

            <h3><?php $cms->PrintTranslate('txt_7'); ?></h3>
            <h5 class="gray"><?php $cms->PrintTranslate('txt_9'); ?></h5>
        </div>
    <?php else: ?>
        <h5 class="count-desc mb-4"> <em class="fas fa-file"></em> <?php $cms->PrintTranslate('txt_8'); ?>: <span class="count-red"><?php echo count($cms->FlatPageArray($pages)); ?></span> </h5>

        <?php foreach($pages as $page): ?>
            <?php $cms->IncludeComponent("PageItem", [ "page" => $page, "depth" => 1 ]); ?>
        <?php endforeach; ?>

        <?php if($cms->HasAtLeast("Moderator")): ?>
            <div class="d-flex justify-content-center">
                <button class="cms-btn mt-2" @click="createPage()">  <em class="fas fa-plus no"></em></button>
            </div>
        <?php endif; ?>
        
    <?php endif; ?>
</div>