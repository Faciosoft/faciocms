<?php
    namespace FacioCMS\Client;

    use FacioCMS\Client\Page;
    use FacioCMS\Client\Utils\Group;

    class ClientAPI {
        private $cms;

        public function __construct($cms) {
            $this->cms = $cms;
        }

        public function GetPage(): Page {
            $page_url = $_SERVER["REQUEST_URI"];

            $page = $this->cms->GetPageByFullURL($page_url);
            if(!$page) $page = $this->cms->GetHomePage();

            return new Page($page, $this->cms->GetCurrentGallery(), $this->cms);
        }

        public function GetPageById($id): Page|null {
            $page = $this->cms->GetPage($id);
            if(!$page) return null;

            return new Page($page, $this->cms->GetCurrentGallery(), $this->cms);
        }

        public function GetAllPages(): Group {
            return new Group($this->cms->GetPagesTree());
        }

        public function GetSetting($name) {
            return $this->cms->GetSetting($name);
        }
    }