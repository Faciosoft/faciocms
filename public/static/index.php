<?php
    /**
     * FacioCMS Static Resource 
     */ 

    $blocked_extensions = ["php", "php5", "php7", "php8", "htaccess", "md", "vue", "old", "html", "htm", "scss"];

    // FacioCMS Version
    $version;

    // If version was defined in request
    if(isset($_GET["version"])) {
        $version = $_GET["version"];
    }
    else { // If it's not (helps in case of liblaries)
        require_once('../../core/requires.php');

        $config = \FacioCMS\Loader\Config\LoadBasicConfig("../");
        $database = \FacioCMS\Loader\Database\SQL::Connect($config->database);

        // Checking if database has default tables:
        // + fcms_coreconfig
        if(!$database->HasDefault()) {
            // If don't have then initializing them

            $database->CreateDefault();
        }

        $version = $database->Select('SELECT `version` FROM `fcms_coreconfig` LIMIT 1')[0]['version'];
    }

    // Resource Path
    $full_path = str_replace("_", ".", $_SERVER["PHP_SELF"]);
    $short_path = str_replace("/static/index.php", "", $full_path);
    $path = __DIR__ . "/../../versions/$version$short_path";
    
    // Resource Extension
    $extension = strtolower(pathinfo($full_path, PATHINFO_EXTENSION));

    if(in_array($extension, $blocked_extensions)) {
        header('Content-Type: text/plain');
        echo "File with extension `.$extension` cannot be a static resource!";
        exit();
    }

    // Resource not exists!
    if(!file_exists($path)) {
        header('Content-Type: text/plain');
        echo '404';
        exit();
    }

    // Setting header
    if($extension === "css") {
        header('Content-Type: text/css');
    } else if($extension === "js") {
        header('Content-Type: text/js');
    }

    echo "/* FacioCMS v.$version Static Resource */\n";
    echo file_get_contents($path);