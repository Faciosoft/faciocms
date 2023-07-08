<?php
    namespace FacioCMS\Versions\v3_0_0\API;

    /**
     * @name Settings
     * Controller for Settings
     */
    trait Settings {
        public function HandleAPI_SettingsSave() {
            global $database;
            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            if(!$data) return ["error" => true, "content-message" => "Bad Request"];

            $is_prod = $data->prod_mode ? 1 : 0;
            $auto_update = $data->auto_updates ? 1 : 0;
            $website_name = $data->website_name;
            $website_url = $data->website_url;
            $theme_color = $data->theme_color;
            $secondary_color = $data->secondary_color;
            $supercaching = $data->supercaching ? 1 : 0;

            // Query
            $query = "UPDATE `fcms_settings` SET `prod`='$is_prod',`autoupdate`='$auto_update',`website_name`='$website_name',`website_url`='$website_url',`theme_color`='$theme_color',`secondary_color`='$secondary_color',`supercaching`='$supercaching'";
            $database->Raw($query);

            return ["error" => false, "content-message" => "Saved successfully!"];
        }

        public function HandleAPI_ClearCache() {
            global $database;
            header('Content-Type: application/json');

            foreach(scandir("../cache/pages") as $page) {
                if($page === "." || $page === "..") continue;
        
                unlink("../cache/pages/$page");
            }

            return [ "error" => false, "content-message" => "Successfully cleared cache!" ];
        }
    }