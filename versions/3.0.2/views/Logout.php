<?php 
    session_destroy();
    session_unset();
?>

<div class="logout-container d-flex align-items-center justify-content-center flex-column mt-5">
    <h2 class="blazing"><em class="fas fa-sign-out-alt"></em></h2>
    <h1><?php $cms->PrintTranslate('Logout'); ?></h1>

    <h3 class="mt-3 lead gray">You have been logged out!</h3>
    <h4 class="refresh lead gray">This website will reload within: <span id="seconds">5</span>s</h4>
</div>

<script id="refresh">
    let time_left = 5;

    function update() {
        time_left --;
        document.querySelector('#seconds').innerHTML = time_left;

        if(time_left === 0) window.location.href = window.location;
    }

    setInterval(update, 1000);
</script>