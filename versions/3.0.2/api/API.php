<?php
    namespace FacioCMS\Versions\v3\API;
    use FacioCMS\Versions\v3\API\Router;

    /**
     * @name ApplicationProgrammingInterface
     * Provides methods for API
     */
    trait ApplicationProgrammingInterface {
        use Router;
        use Auth; 
        use Page;
        use PageMeta;
        use PageGallery;
        use Settings;
        use User;
        use Layout;
        use Utils;

        public function IsAPIRequest() {
            $uri = $_SERVER["REQUEST_URI"];
            $uri_path_parts = explode("/", $uri);

            return $uri_path_parts[1] == "api";
        }

        public function HandleAPI_Version() {
            return $this->generator_version;
        }

        public function HandleAPI_Status() {
            return "OK";
        }
    }