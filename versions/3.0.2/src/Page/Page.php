<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Page
     * Provides methods for Page Controllment
     */
    trait Page {
        use \FacioCMS\Versions\v3\App\Source\Page\Meta;

        // Return subpages
        public function GetSubpages(int $parent_id) {
            global $database;

            $parent_id = $database->Escape($parent_id);

            $query = "SELECT * FROM `fcms_pages` WHERE `parent_id`='$parent_id'";
            return $database->Select($query);
        }

        // Recursive method that make flat page array into multidimensional array. Page tree. 
        private function ProcessPages(array $pages) {
            foreach($pages as $key => $page) {
                // $page["children"] Had some problem with reference and in effect method wasn't applying children
                $pages[$key]["children"] = $this->ProcessPages($this->GetSubpages($page["id"]));
            }

            return $pages;
        }

        // Return tree with pages
        public function GetPagesTree() {
            $pages = $this->GetSubpages(-1);
            $pages = $this->ProcessPages($pages);

            return $pages;
        }

        // Returns page full url
        public function GetFullUrl($page, $parts = []) { 
            // Pushing url
            $url = $page["url"];
            $parts[] = $url;

            // Getting parent
            $parent_id = $page["parent_id"];

            // We gotta went to lowest page. Oldest page (in hierarchy) so return url parts
            if($parent_id == -1) return "/" . implode("/", array_reverse($parts));

            $parent = $this->GetPage($parent_id, false);
            return $this->GetFullUrl($parent, $parts);
        }

        // Give page more details like `fullUrl` etc
        public function FullPage($page) {
            $page["fullUrl"] = $this->GetFullUrl($page);

            return $page;
        }

        // Return page as array or null
        public function GetPage(int $page_id, bool $full = true): array | null {
            global $database;
            
            $page_id = $database->Escape($page_id);

            $query = "SELECT * FROM `fcms_pages` WHERE `id`='$page_id'";
            $pages = $database->Select($query);

            return count($pages) > 0 ? ($full ? $this->FullPage($pages[0]) : $pages[0]) : null;
        }

        // Returns page by url and parent id
        public function GetPageByUrlAndParentId(string $url, int $parent_id) {
            global $database;

            $url = $database->Escape($url);
            $parent_id = $database->Escape($parent_id);

            $query = "SELECT * FROM `fcms_pages` WHERE `parent_id`='$parent_id' AND `url`='$url'";
            $pages = $database->Select($query);

            return count($pages) === 0 ? null : $pages[0];
        }

        // Returns page which full url matches given
        public function GetPageByFullURL(string $url) {
            // Getting url parts
            $parts = explode("/", $url);
            if($parts[0] === "") array_shift($parts);

            // Getting page id by url
            $last_id = '-1';
            foreach($parts as $part) {
                if($part == "") continue;

                $page = $this->GetPageByUrlAndParentId($part, $last_id);
                if(!$page) return [ "error" => true, "message" => "Page at url: \"$url\" doesn't exists!" ];

                $last_id = $page["id"];
            }

            return $this->GetPage($last_id);
        }

        // Returns New Page #new_page_id
        public function GenerateNewPageTitle() {
            global $database;

            $query = "SELECT `title` from `fcms_pages` WHERE `title` LIKE 'New page (%' ORDER BY `id` DESC";
            $results = $database->Select($query);

            if(empty($results)) return "New page (1)";

            $page = $results[0];
            $title = $page["title"];

            // Getting the id: New Page (<Id>)
            $id_str = explode(")", explode("(", $title)[1])[0];
            $id_num = intval($id_str) + 1;

            return "New page ($id_num)";
        }

        // Delete all subpages
        public function DeleteAllSubpagesFor(int $id) {
            global $database;

            $query = "SELECT * FROM `fcms_pages` WHERE `parent_id`='$id'";
            $results = $database->Select($query);

            foreach($results as $res) {
                $this->DeleteAllMetaKeysFor($res["id"]);
                $this->DeleteAllSubpagesFor($res["id"]);
            }

            $query = "DELETE FROM `fcms_pages` WHERE `parent_id`='$id'";
            $database->Raw($query);
        }

        // Get Current page id if it exists
        public function GetCurrentPageId() {
            return $this->IsInAdminPanel() ? $this->GetAdminPanelPageId() : $this->current_page_id;
        }

        public function GetAdminPanelPageId(): string|int|null {
            $uri = $_SERVER["REQUEST_URI"];

            return stristr($uri, "/admin/page/") ? \FacioCMS\Versions\v3\App\Source\decrypt_faciocode(explode("/admin/page/", $uri)[1]) : null;
        }

        public function GetHomePage(): array | null {
            global $database;

            $query = "SELECT `owner_id` FROM `fcms_pagemeta` WHERE `name`='Is_Home' AND `value`=1 LIMIT 1";
            $results = $database->Select($query);

            if(empty($results)) return null;

            return $this->GetPage($results[0]["owner_id"]);
        }
    }