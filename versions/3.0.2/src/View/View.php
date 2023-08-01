<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name View
     * Provides methods for view templating
     */
    trait View {
        private function IncludeView(string $path, array $data): void {
            global $cms;
            global $app;

            // Parsing data
            foreach($data as $key => $item) {
                eval("$$key = \$item;");
            }

            // Including view
            try {
                include($path);
            } 
            catch(Exception $e) {
                echo 'Error whilst including view: ' . $path;
                echo $e;
            }
        }
        
        public function View(string $viewName, array $data): void {
            global $cms;
            global $app;
            
            // if($this->isInAdminPanel()) {
                $this->IncludeView(realpath(dirname(__FILE__)) . '/../../views/' . $viewName . '.php', $data);
            // }

        }
    }