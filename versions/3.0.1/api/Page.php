<?php
    namespace FacioCMS\Versions\v3\API;

    define("FACIOCMS_EMPTY_PAGE_META_KEYS", [
        "Active" => 1,
        "Index" => 1,
        "Follow_Links" => 1,
        "Is_Home" => 0,
        "Title" => "",
        "Description" => "",
        "Author" => "",
    ]);

    /**
     * @name Page
     * Controller for Pages
     */
    trait Page {
        public function HandleAPI_PageSave() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $title = $database->Escape($data->title);
            $subtitle = $database->Escape($data->subtitle);
            $content = $database->Escape($data->content);
            $layout = $database->Escape($data->layout);
            $url = $database->Escape($data->url);
            $id = $database->Escape($data->id);

            $query = "UPDATE `fcms_pages` SET `title`='$title', `subtitle`='$subtitle', `content`='$content', `layout`='$layout', `url`='$url' WHERE `id` = '$id'";
            if($database->Raw($query)) {
                return ["error" => false, "content-message" => "Successfully saved the page!"];
            }

            return ["error" => true, "content-message" => "Error while trying to save the page!"];
        }

        public function HandleAPI_CreatePage() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $parent_id = $database->Escape($data->parent_id);

            $title = $this->GenerateNewPageTitle();
            $uuid = uniqid();
            $current_date = date('Y-m-d H:i:s');

            $user_id = $_SESSION["USER_ID"];

            // Query
            $query = "INSERT INTO `fcms_pages` VALUES (NULL, '$parent_id', '$title', 'New page!', 'Lorem ipsum dolor sit amet...', '$current_date', '$current_date', '$user_id', '', '$uuid')";

            if($database->Raw($query)) {
                $new_page_id = $database->Select("SELECT `id` FROM `fcms_pages` ORDER BY `id` DESC LIMIT 1")[0]["id"];

                // Primary meta keys
                foreach(FACIOCMS_EMPTY_PAGE_META_KEYS as $key => $value) {
                    $this->CreatePageMetaPair($new_page_id, $key, $value);
                }
            
                return [ "error" => false, "content-message" => "Successfully created new page!" ];
            }

            return [ "error" => true, "content-message" => "Error while trying to create page!" ];
        }

        public function HandleAPI_DeletePage() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $id = $database->Escape($data->id);

            // Query
            $query = "DELETE FROM `fcms_pages` WHERE `id`='$id'";

            if($database->Raw($query)) {
                $this->DeleteAllSubpagesFor($data->id);
                $this->DeleteAllMetaKeysFor($data->id);

                return [ "error" => false, "content-message" => "Successfully deleted page!" ];
            }

            return [ "error" => true, "content-message" => "Error while trying to delete page!" ];
        }

        public function HandleAPI_DeleteAllPages() {
            global $database;
            global $app;

            header('Content-Type: application/json');

            // Query
            $query = "TRUNCATE TABLE `fcms_pages`";
            $query2 = "TRUNCATE TABLE `fcms_pagemeta`";

            return $database->Raw($query) && $database->Raw($query2) ? 
                [ "error" => false, "content-message" => "Successfully deleted all pages!" ] :
                [ "error" => true, "content-message" => "Failed to delete all pages!" ];
        }
    }