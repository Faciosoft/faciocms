<?php
    namespace FacioCMS\Versions\v3\API;

    /**
     * @name Utils
     * Controller for Utils
     */
    trait Utils {
        public function HandleAPI_DiskUsage() {
            global $database;

            header('Content-Type: application/json');

            function filesize_r($path){
                if(!file_exists($path)) return 0;
                if(is_file($path)) return filesize($path);
                
                $ret = 0;
                
                foreach(glob($path."/*") as $fn)
                  $ret += filesize_r($fn);
        
                return $ret;
            }

            $memory_usage = filesize_r("../");
            
            return [ "error" => false, "result" => $memory_usage ];
        }
    }