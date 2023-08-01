<?php
    namespace FacioCMS\Versions\v3\App\Source;

    trait Layout {
        public function GetLayouts() {
            $layouts = [];
            
            foreach(scandir("../layouts") as $layout_file) {
                if($layout_file == "." || $layout_file == "..") continue;
                
                $layout_folder = "../layouts/$layout_file";
                $layout_definition_file = $layout_folder . "/layout-definition.json";
                $layout_definition = json_decode(file_get_contents($layout_definition_file));

                $layouts[] = $layout_definition;
            }

            return $layouts;
        }

        public function GetLayoutDefinitionFile(string $layout_name) {
            return "../layouts/$layout_name/layout-definition.json";
        }

        public function LayoutExists(string $layout_name) {
            return file_exists($this->GetLayoutDefinitionFile($layout_name));
        }

        public function GetLayoutConfig(string $layout_name) {
            $definition_path = $this->GetLayoutDefinitionFile($layout_name);
            $definition_content = file_get_contents($definition_path);

            return json_decode($definition_content);
        }

        // TODO: Check if CMS Versions matches etc
        public function ValidateLayout(\stdClass $config) {

        }

        public function IncludeLayoutBody(string $layout_name, array $data) {
            if(!$this->LayoutExists($layout_name)) $this->QuitWithError("Layout not found", "Layout $layout_name was not found!");

            $config = $this->GetLayoutConfig($layout_name);
            $this->ValidateLayout($config);

            // Binding data
            foreach($data as $key => $item) {
                eval("$$key = \$item;");
            }
            
            // Including layout .php file
            $body_path = "../layouts/$layout_name/$config->body";
            require($body_path);
        }

        public function IncludeLayoutHead(string $layout_name, array $data) {
            if(!$this->LayoutExists($layout_name)) $this->QuitWithError("Layout not found", "Layout $layout_name was not found!");

            $config = $this->GetLayoutConfig($layout_name);
            $this->ValidateLayout($config);

            // Binding data
            foreach($data as $key => $item) {
                eval("$$key = \$item;");
            }
            
            // Including layout .php file
            $body_path = "../layouts/$layout_name/$config->head";
            require($body_path);
        }

        public function GetAllLayouts(): array {
            $layouts_folders = scandir("../layouts");
            $layouts = [];

            foreach($layouts_folders as $layout) {
                if($layout == "." || $layout == "..") continue;

                $layout_config_text = file_get_contents("../layouts/$layout/layout-definition.json");
                $layout_config = json_decode($layout_config_text);

                $layouts[] = $layout_config;
            }

            return $layouts;
        }
    }
