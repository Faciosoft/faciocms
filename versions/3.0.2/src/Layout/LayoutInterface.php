<?php
    namespace FacioCMS\Versions\v3\App\Source;

    // @notused
    interface LayoutInterface {
        /**
         * @name GetLayoutDefinitionFile 
         * @param {string $layout_name}
         * @return string
         * 
         * Return path to layout definition
         */
        public function GetLayoutDefinitionFile(string $layout_name);

        /**
         * @name LayoutExists 
         * @param {string $layout_name}
         * @return bool
         * 
         * Return if layout with name $layout_name exists
         */
        public function LayoutExists(string $layout_name): bool;

        /**
         * @name GetLayoutConfig 
         * @param {string $layout_name}
         * @return stdClass
         * 
         * Return layout config as json object
         */
        public function GetLayoutConfig(string $layout_name): \stdClass;

        /**
         * @name IsJewelLayout 
         * @param {string $path} Layout file path
         * @return bool
         * 
         * Checks if file is a .jewel file
         */
        public function IsJewelLayout(string $path): bool;

        /**
         * @name IncludeLayoutBody 
         * @param {string $layout_name} 
         * @param {array $data} Data variables that should be passed
         * 
         * Includes layout body
         */
        public function IncludeLayoutBody(string $layout_name, array $data);

        /**
         * @name IncludeLayoutHead 
         * @param {string $layout_name} 
         * @param {array $data} Data variables that should be passed
         * 
         * Includes layout head
         */
        public function IncludeLayoutHead(string $layout_name, array $data);

        /**
         * @name GetAllLayouts 
         * @return array
         * 
         * Returns all avaliable layouts
         */
        public function GetAllLayouts(): array;
    }