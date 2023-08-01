<?php   
    // Constants
    require_once(realpath(dirname(__FILE__)) . '/../lang/en.php');

    // Liblaries
    require_once(realpath(dirname(__FILE__)) . '/../libs/jewel/src/Requires/Requires.php');

    // Version source
    require_once('Page/Meta.php');
    require_once('PluginLoader/require.php');
    require_once('Caching/Caching.php');
    require_once('Auth/Auth.php');
    require_once('Layout/Layout.php');
    require_once('View/View.php');
    require_once('Lang/Lang.php');
    require_once('Error/Error.php');
    require_once('Install/Install.php');
    require_once('Component/Component.php');
    require_once('Page/Page.php');
    require_once('Utils/Utils.php');
    require_once('Settings/Settings.php');
    require_once('User/User.php');
    require_once('Gallery/Gallery.php');
    require_once('Permissions/Permissions.php');
    require_once('PluginLoader/PluginLoader.php');
    require_once('Faciocode/Faciocode.php');

    // Client API
    require_once('Client/Group.php');
    require_once('Client/Page.php');
    require_once('Client/ClientAPI.php');
    require_once('Client/Session.php');

    // API
    require_once(realpath(dirname(__FILE__)) . '/../api/Auth.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/Settings.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/Page.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/PageMeta.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/User.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/Layout.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/Utils.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/PageGallery.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/Router.php');
    require_once(realpath(dirname(__FILE__)) . '/../api/API.php');