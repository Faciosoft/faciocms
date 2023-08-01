<?php
    namespace FacioCMS\Versions\v3\API;

    define("FACIOCMS_BLOCKED_UPLOAD_EXTENSIONS", [
        "php",
        "phphtml",
        "php2",
        "php3",
        "php4",
        "php5",
        "php6",
        "php7",
        "php8",
        "html",
        "htm",
        "js",
        "ts",
        "htaccess",
        "ini",
        "config",
        "cfg"
    ]);

    trait PageGallery {
        public function HandleAPI_UploadGallery() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            
            $page_id = $_POST['page_id'];
            $file = $_FILES['file'];

            // Target file data
            $target_dir = "../storage/";
            $target_file = $target_dir . basename($file["name"]);

            $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            if(in_array($extension, FACIOCMS_BLOCKED_UPLOAD_EXTENSIONS)) return [ "error" => true, "content-message" => "Cannot upload file with extension $extension!" ];

            // Uploading
            $uuid = uniqid('asset_');
            $target_file = $target_dir . $uuid . '.' . $extension;

            if(!move_uploaded_file($file["tmp_name"], $target_file)) return [ "error" => true, "content-message" => "Upload failed - Unknown reason!" ];

            $query = "INSERT INTO `fcms_assets` VALUES ('$uuid.$extension', $page_id, 'gallery_image')";

            return $database->Raw($query) ?
                [ "error" => false, "content-message" => "Successfully uploaded to gallery" ] : 
                [ "error" => true, "content-message" => "Error while trying to upload to gallery" ];
        }

        public function HandleAPI_DeleteGalleryItem() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $id = $database->Escape($data->id);

            // Query
            $query = "DELETE FROM `fcms_assets` WHERE `id`='$id'";

            if($database->Raw($query)) {
                unlink("../storage/$id");

                return [ "error" => false, "content-message" => "Successfully deleted asset!" ];
            }

            return [ "error" => true, "content-message" => "Error while trying to delete asset!" ];
        }
    }