<?php
    $uri = $_SERVER["REQUEST_URI"];
    $uri_parts = explode('/', $uri);

    $layout_name = $uri_parts[3];
?>
<div class="is-fullscreen-layout"></div>

<div class="layout-fullscreen">
    <button class="transparent-button btn-close-fullscreen-layout" @click="window.closeLayoutEditor"><em class="fas fa-times"></em></button>

    <div class="layout-data">
        <h3><?php echo $layout_name; ?></h3>
    </div>

    <div class="row">
        <div class="col-md-6">
            asd
        </div>
        <div class="col-md-6">
            asd
        </div>
    </div>
</div>