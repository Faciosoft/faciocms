<?php 
    $page           = null; 
    $title          = null;
    $follow_links   = null;
    $index          = null;
    $active         = null;
    $author         = null;
    $description    = null;    
?>
<meta name="generator" content="FacioCMS <?php echo $cms->generator_version; ?>">

<?php if($cms->IsInAdminPanel()): ?>
    <?php require_once('admin/head.php') ?>
<?php else: ?>
    <?php 
        $page_url = $_SERVER["REQUEST_URI"];
        
        $page = $cms->GetPageByFullURL($page_url);
        if(!$page) $page = $cms->GetHomePage();
    ?>
    <?php if(@$page["error"] || !$page): ?>
        <script>window.error=404</script>
    <?php else: ?>
        <?php
            if(!$page) exit();
            $page_layout = $page["layout"];

            $cms->current_page_id = $page["id"];

            $cms->IncludeLayoutHead($page_layout, [
                "page" => json_decode(json_encode($page)),
                "cms" => $cms
            ]);
        ?>
    <?php endif; ?>
<?php endif; ?>

<meta name="theme-color" content="<?php echo $cms->GetSetting('theme_color')->value; ?>">
<meta name="secondary-color" content="<?php echo $cms->GetSetting('secondary_color')->value; ?>">

<style>
    .theme-foreground { color: <?php echo $cms->GetSetting('theme_color')->value; ?> }
    .theme-background { background: <?php echo $cms->GetSetting('theme_color')->value; ?> }
    .secondary-foreground { color: <?php echo $cms->GetSetting('secondary_color')->value; ?> }
    .secondary-background { background: <?php echo $cms->GetSetting('secondary_color')->value; ?> }
</style>

<?php if($page): ?>
    <?php 
        $page_meta = $cms->ExtractMeta($page);
        
        $title          = @$page_meta["Title"];
        $follow_links   = @$page_meta["Follow_Links"];
        $index          = @$page_meta["Index"];
        $active         = @$page_meta["Active"];
        $author         = @$page_meta["Author"];
        $description    = @$page_meta["Description"];

        $robots = '';
        $robots .= $index ? 'index' : 'noindex';
        $robots .= $follow_links ? ', follow' : ', nofollow';
    ?>

    <?php if($robots): ?>
        <!-- ROBOTS -->
        <meta name="robots" value="<?php echo $robots; ?>">
        <!-- END ROBOTS -->
    <?php endif; ?>

    <?php if($author): ?>
        <!-- AUTHOR -->
        <meta name="author" value="<?php echo $author; ?>">
        <!-- END AUTHOR -->
    <?php endif; ?>

    <?php if($description): ?>
        <!-- DESCRIPTION -->
        <meta name="description" value="<?php echo $description; ?>">
        <!-- END DESCRIPTION -->
    <?php endif; ?>

    <?php if($title): ?>
        <!-- TITLE -->
        <title force><?php echo $title; ?></title>
        <script id="title-script">
            if(document.title !== "<?php echo $title; ?>") document.title = "<?php echo $title; ?>";
        </script>
        <!-- END TITLE -->
    <?php endif; ?>
<?php endif; ?>

<?php 
    use FacioCMS\Plugins\FacioCMSPlugin\ClientResponseGeneratingEvent;

    $event = new ClientResponseGeneratingEvent;
    $event->state = ClientResponseGeneratingEvent::$HEAD;
    $cms->FireEvent($event);
?>
