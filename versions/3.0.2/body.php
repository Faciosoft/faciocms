<?php 
    use FacioCMS\Plugins\FacioCMSPlugin\ClientResponseGeneratingEvent;

    $event = new ClientResponseGeneratingEvent;
    $event->state = ClientResponseGeneratingEvent::$BEGINNING;
    $cms->FireEvent($event);
?>

<?php if($cms->IsInAdminPanel()): ?>
    <?php require_once('admin/body.php') ?>
<?php else: ?>
    <?php 
        $page_url = $_SERVER["REQUEST_URI"];

        $page = $cms->GetPageByFullURL($page_url);
        if(!$page) $page = $cms->GetHomePage();

        $page_count = -1;
        
        if(!$page || $cms->IsInAdminPanel()) $page_count = count($cms->GetPagesTree());
    ?>

    <?php if($page_count === 0): ?>
        <?php /* No pages */ ?>
        <?php $cms->View('NoPages', [ "cms" => $cms ]); ?>

    <?php elseif(@$page["error"] || !$page): ?>
        
        <?php $cms->View('404', [ "cms" => $cms ]); ?>
    
    <?php else: ?>
        <?php if($active): ?>
            <?php
                $page_layout = $page["layout"];

                $cms->IncludeLayoutBody($page_layout, [
                    "page" => json_decode(json_encode($page)),
                    "cms" => $cms
                ]);
            ?>
        <?php else: ?>
            <?php $cms->View('NotActive', [ "cms" => $cms ]) ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php
    $event->state = ClientResponseGeneratingEvent::$ENDING;
    $cms->FireEvent($event);

    unset($event);
?>