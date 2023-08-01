<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Component
     * Provides methods component view management
     */
    trait Component {
        /**
         * This method include View Component (from path /[VERSION-FOLDER]/components/[COMPONENT-NAME].php)
         */
        public function IncludeComponent($componentName, $data = []) {
            if(!$componentName || $componentName == '') {
                $this->QuitWithError("Component name error", "Cannot include component with name \"$componentName\" the name is empty!");
            }

            // Getting path
            $path = __DIR__ . "/../../components/$componentName.php";
            
            if(!file_exists($path)) {
                $this->QuitWithError("Component including error", "Component with name \"$componentName\" don't exists in currently installed FacioCMS Version. See documentation or check if FacioCMS is installed properly!");
            }

            // Binding data
            foreach($data as $key => $item) {
                eval("$$key = \$item;");
            }

            // Binding CMS Variable to current application instance
            $cms = $this;

            // Including Component
            if(@!include($path)) {
                // Error
                $this->QuitWithError("Component including error", "Component with name \"$componentName\" somehow cannot be included. See documentation or check if FacioCMS is installed properly!");
            }
        }
    }