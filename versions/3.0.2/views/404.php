<style>
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-24px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .error-page {
        width: 100%;
        height: 100vh;

        background: #eee;

        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }   

    .error-header {
        font-size: 96px;
        font-weight: 900;
        height: 100px;
        margin-bottom: 48px;
        transform: translateX(-48px);
    }

    .char {
        position: absolute;
        animation: float .4s;
        animation-delay: .2s;
        text-shadow: 3px 3px #000;
    }

    .char-0 {
        margin-left: -96px;
        animation-delay: 0s;
    }

    .char-2 {
        margin-left: 96px;
        animation-delay: .4s;
    }

    .error-subheader {
        font-size: 36px;
    }

    .error-page span.mt-3 {
        margin-top: 96px!important;
    }

    .service {
        font-size: 32px;
    }
</style>

<div class="error-page">
    <h1 class="error-header"> 
        <span class="char char-0 theme-foreground">4</span>
        <span class="char char-1 secondary-foreground">0</span>
        <span class="char char-2 theme-foreground">4</span>    
    </h1>

    <h2 class="error-subheader">
        Sorry, our service cannot find this resource!
    </h2>

    <h4 class="service theme-foreground">
        Service: <?php echo $cms->GetSetting('website_name')->value; ?>
    </h4>

    <?php $cms->IncludeComponent('Powered'); ?>
</div>