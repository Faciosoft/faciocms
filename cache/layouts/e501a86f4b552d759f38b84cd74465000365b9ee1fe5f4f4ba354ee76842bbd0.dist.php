<?php 
    use FacioCMS\Client\Session;

    $session = Session::Init($cms);
    $page = $session->GetPage();
?>

<h1><?php echo $page->GetTitle(); ?></h1>

<?php for ($i = 0; $i < 10; $i++): ?> 
    <?php echo $i ** 8; ?> <br>
<?php endfor; ?>