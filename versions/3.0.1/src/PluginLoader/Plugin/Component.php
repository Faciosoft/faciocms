<?php
    namespace FacioCMS\Plugins\FacioCMSPlugin;

    trait Component {
        public function IncludeComponent(string $componentName, array $data = []) {
            if(!$componentName || $componentName == '') {
                $this->PluginError("Component name error", "Cannot include component with name \"$componentName\" the name is empty!");
            }

            // Getting path
            $path = __DIR__ . "/../../../../" . $this->path . "/components/$componentName.php";
            
            if(!file_exists($path)) {
                $this->PluginError("Component including error", "Component with name \"$componentName\" don't exists in currently installed FacioCMS Version. See documentation or check if FacioCMS is installed properly!");
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
                $this->PluginError("Component including error", "Component with name \"$componentName\" somehow cannot be included. See documentation or check if FacioCMS is installed properly!");
            }
        }
    }