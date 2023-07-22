<?php   
    // Constants
    require_once(realpath(dirname(__FILE__)) . '/../lang/en.php');

    // Libs protos
    require_once('Page/Meta.php');
    require_once('PluginLoader/require.php');

    // Libs
    require_once('Caching.php');
    require_once('Auth.php');
    require_once('Layout.php');
    require_once('View.php');
    require_once('Lang.php');
    require_once('Error.php');
    require_once('Install.php');
    require_once('Component.php');
    require_once('Page.php');
    require_once('Utils.php');
    require_once('Settings.php');
    require_once('User.php');
    require_once('Gallery.php');
    require_once('Permissions.php');
    require_once('PluginLoader.php');
    require_once('Faciocode.php');

    // Client API
    require_once('client/Group.php');
    require_once('client/Page.php');
    require_once('client/ClientAPI.php');
    require_once('client/Session.php');

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