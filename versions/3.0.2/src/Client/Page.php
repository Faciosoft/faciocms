<?php
    namespace FacioCMS\Client;

    use FacioCMS\Client\Utils\Group;

    class Page {
        private $page;
        private $gallery;
        private $cms;
        private $link;

        public function __construct($page, $gallery, $cms) {
            $this->page = $page;
            $this->gallery = $gallery;
            $this->cms = $cms;
            $this->link = $this->cms->GetFullUrl($this->page);
        }

        public function GetPage(): array|Page {
            return $this->page;
        }

        public function GetTitle(): string {
            return $this->page["title"];
        }

        public function GetSubtitle(): string {
            return $this->page["subtitle"];
        }

        public function GetContent(): string {
            return $this->page["content"];
        }

        public function GetGallery(): array {
            return $this->gallery;
        }

        public function GetLink(): string {
            return $this->link;
        }

        public function GetChildren(): Group {
            $pages = [];

            foreach($this->cms->GetSubpages($this->page["id"]) as $page) {
                $pages[] = new Page($page, $this->cms->GetPageGallery($page["id"]), $this->cms);
            }

            return new Group($pages);
        }

        public function GetSiblings(): Group {
            $pages = [];
            $parent_id = $this->page["parent_id"];

            foreach($this->cms->GetSubpages($parent_id) as $page) {
                if($page["id"] === $this->page["id"]) continue;

                $pages[] = new Page($page, $this->cms->GetPageGallery($page["id"]), $this->cms);
            }

            return new Group($pages);
        }
    
        public function GetSetting($name) {
            $value = $this->cms->GetMetaKey($this->page["id"], $name);
            if(!$value) return null;
            
            return $value["value"];
        }
    }