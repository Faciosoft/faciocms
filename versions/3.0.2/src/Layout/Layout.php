<?php
    namespace FacioCMS\Versions\v3\App\Source;
    use Jewel\Compiler;

    trait Layout {
        /**
         * @name jewel_compiler
         * @type Jewel\Compiler
         * 
         */
        protected Compiler $jewel_compiler;

        // @duplicate
        public function GetLayouts() {
            return $this->GetAllLayouts();

            // $layouts = [];
            // 
            // foreach(scandir("../layouts") as $layout_file) {
            //     if($layout_file == "." || $layout_file == "..") continue;
            //     
            //     $layout_folder = "../layouts/$layout_file";
            //     $layout_definition_file = $layout_folder . "/layout-definition.json";
            //     $layout_definition = json_decode(file_get_contents($layout_definition_file));
            // 
            //     $layouts[] = $layout_definition;
            // }
            // 
            // return $layouts;
        }

        /**
         * @name GetLayoutDefinitionFile 
         * @param {string $layout_name}
         * @return string
         * 
         * Return path to layout definition
         */
        public function GetLayoutDefinitionFile(string $layout_name): string {
            return "../layouts/$layout_name/layout-definition.json";
        }

        /**
         * @name LayoutExists 
         * @param {string $layout_name}
         * @return bool
         * 
         * Return if layout with name $layout_name exists
         */
        public function LayoutExists(string $layout_name): bool {
            return file_exists($this->GetLayoutDefinitionFile($layout_name));
        }

        /**
         * @name GetLayoutConfig 
         * @param {string $layout_name}
         * @return stdClass
         * 
         * Return layout config as json object
         */
        public function GetLayoutConfig(string $layout_name): \stdClass {
            $definition_path = $this->GetLayoutDefinitionFile($layout_name);
            $definition_content = file_get_contents($definition_path);

            return json_decode($definition_content);
        }

        // TODO: Check if CMS Versions matches etc
        public function ValidateLayout(\stdClass $config) {

        }

        /**
         * @name IsJewelLayout 
         * @param {string $path} Layout file path
         * @return bool
         * 
         * Checks if file is a .jewel file
         */
        public function IsJewelLayout(string $path): bool {
            $extension = pathinfo($path, PATHINFO_EXTENSION);

            return $extension == "jewel";
        }

        /**
         * @name IncludeLayoutBody 
         * @param {string $layout_name} 
         * @param {array $data} Data variables that should be passed
         * 
         * Includes layout body
         */
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

            if($this->IsJewelLayout($body_path)) {
                $hash = hash('sha256', "$layout_name-body");
                $jewel_template_path = "../cache/layouts/$hash.dist.php";

                // if(!file_exists($jewel_template_path)) {
                $this->jewel_compiler ??= new Compiler;
                $this->jewel_compiler->Run($body_path, $jewel_template_path);
                //}

                require($jewel_template_path);
            }
            else require($body_path);
        }

        /**
         * @name IncludeLayoutHead 
         * @param {string $layout_name} 
         * @param {array $data} Data variables that should be passed
         * 
         * Includes layout head
         */
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
            
            if($this->IsJewelLayout($body_path)) {
                $hash = hash('sha256', "$layout_name-head");
                $jewel_template_path = "../cache/layouts/$hash.dist.php";

                // if(!file_exists($jewel_template_path)) {
                $this->jewel_compiler ??= new Compiler;
                $this->jewel_compiler->Run($body_path, $jewel_template_path);
                // }

                require($jewel_template_path);
            }
            else require($body_path);
        }

        /**
         * @name GetAllLayouts 
         * @return array
         * 
         * Returns all avaliable layouts
         */
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