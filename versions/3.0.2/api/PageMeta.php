<?php
    namespace FacioCMS\Versions\v3\API;

    use FacioCMS\Versions\v3\API\FACIOCMS_EMPTY_PAGE_META_KEYS;

    trait PageMeta {
        public function HandleAPI_DeleteMetaSetting() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $page_id    = $database->Escape($data->pageId);
            $key_name   = $database->Escape($data->keyName);

            foreach(FACIOCMS_EMPTY_PAGE_META_KEYS as $key => $value) {
                if($key === $data->keyName) return [ "error" => true, "content-message" => "Error $key_name is default FacioCMS Page Meta Setting and cannot be removed!" ];
            }
            
            // Query
            $query = "DELETE FROM `fcms_pagemeta` WHERE `owner_id`='$page_id' AND `name`='$key_name'";

            return $database->Raw($query) ?
                [ "error" => false, "content-message" => "Successfully deleted page's meta setting" ] : 
                [ "error" => true, "content-message" => "Error while trying to delete page's meta setting" ];
        }

        public function HandleAPI_CreateMetaSetting() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $page_id        = $database->Escape($data->pageId);
            $name_modal     = $database->Escape($data->nameModal);
            $value_modal    = $database->Escape($data->valueModal);

            // Query
            $query = "INSERT INTO `fcms_pagemeta` VALUES ('', '$page_id', '$name_modal', '$value_modal')";
            
            // Query
            return $database->Raw($query) ? 
                [ "error" => false, "content-message" => "Successfully created page's meta setting" ] :
                [ "error" => true, "content-message" => "Error while trying to delete page's meta setting" ];
        }

        public function HandleAPI_SaveMetaSetting() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $page_id = $data->page_id;
            $values  = $data->values;

            foreach($values as $key => $value) {
                if($key === 'Is_Home' && $value == '1') {
                    $database->Raw("UPDATE `fcms_pagemeta` SET `value`='0' WHERE `name`='Is_Home'");
                }

                $query = "UPDATE `fcms_pagemeta` SET `value`='$value' WHERE `name`='$key' AND `owner_id`='$page_id'";

                if(!$database->Raw($query)) return [ "error" => true, "content-message" => "Error while trying to save page's meta setting (key: $key)" ];
            }

            return [ "error" => false, "content-message" => "Successfully saved page's meta settings" ];
        }
    }