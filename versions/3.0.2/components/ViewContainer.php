<div class="view admin-view col-xl-10 col-lg-9 col-md-8 col-12 position-relative full-height">
    <?php 
        $viewData = [ "cms" => $cms ];
        
        // Request URL & Parts
        $request_url = $_SERVER["REQUEST_URI"];
        $url_path_parts = explode("/", $request_url);

        // Subroute /admin/[SubRoute] for including correct view
        $subroute = ("/" . $url_path_parts[2]) ?? "/";
    ?>

    <?php if($subroute == "/"): ?>
        <?php $cms->View('Home', $viewData); ?>
    <?php elseif($subroute == "/pages"): ?>
        <?php $cms->View('Pages', $viewData); ?>
    <?php elseif($subroute == "/page"): ?>
        <?php $cms->View('Page', $viewData); ?>
    <?php elseif($subroute == "/performance"): ?>
        <?php $cms->View('Performance', $viewData); ?>
    <?php elseif($subroute == "/settings"): ?>
        <?php $cms->View('Settings', $viewData) ?>
    <?php elseif($subroute == "/license"): ?>
        <?php $cms->View('License', $viewData); ?>
    <?php elseif($subroute == "/users"): ?>
        <?php $cms->View('Users', $viewData); ?>
    <?php elseif($subroute == "/layouts"): ?>
        <?php $cms->View('Layouts', $viewData) ?>
    <?php elseif($subroute == "/layout"): ?>
        <?php $cms->View('LayoutEditor', $viewData) ?>
    <?php elseif($subroute == "/plugins"): ?>
        <?php $cms->View('Plugins', $viewData) ?>
    <?php elseif($subroute == "/plugin"): ?>
        <?php $cms->View('PluginConfig', $viewData) ?>
    <?php elseif($subroute == "/account"): ?>
        <?php $cms->View('Account', $viewData) ?>
    <?php elseif($subroute == "/analytics"): ?>
        <?php $cms->View('Analytics', $viewData); ?>
    <?php elseif($subroute == "/logout"): ?>
        <?php $cms->View('Logout', $viewData) ?>   
    <?php endif; ?>

    <?php $cms->IncludeComponent("Footer"); ?>
</div>