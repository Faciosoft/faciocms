<?php
    namespace FacioCMS\Versions\v3\App\Source;

    trait Gallery {
        public function GetCurrentGallery(): array {
            $page_id = $this->GetCurrentPageId();
            
            return $this->GetPageGallery($page_id);
        }

        public function GetPageGallery(int|string $page_id): array {
            global $database;

            $query = "SELECT * FROM `fcms_assets` WHERE `owner_id`='$page_id' AND `type`='gallery_image'";
            $results = $database->Select($query);

            foreach($results as $key=> $result) {
                $owner = $result["owner_id"];
                $id = str_replace(".", "_fassetdot_", $result["id"]);

                $results[$key]["path"] = "/static-content/$owner/$id";
            }

            return json_decode(json_encode($results));
        }
    }