<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Utils
     * Provides utilities
     */
    trait Utils {
        public function PerformanceMeter() {
            $microtime = FACIOCMS_START;
            $meter_id = uniqid();

            echo <<<EOD
                <div class="meter" id="meter-$meter_id" style="font-weight:900">
                    <script>
                        const microtime = $microtime;
                        document.addEventListener('DOMContentLoaded', () => {
                            document.querySelector('#meter-$meter_id').innerHTML = 'Page loaded and rendered in: ' + Math.round((new Date().getTime()) - microtime) + 'ms <span title="It\'s sum of php loading time and generating response and loading and rendering webpage in client browser">(?)</span>';
                        });    
                    </script>
                </div>
            EOD;
        }

        public function IsProduction() {
            global $database;

            // Query to get `prod` from cms config
            $query = "SELECT `prod` FROM `fcms_settings` LIMIT 1";
            $data = $database->Select($query);

            if(count($data) === 0) return false; // If there is no config in database we return that cms is in dev mode.

            return !!$data[0]["prod"]; // Return true or false
        }
        
        public function IsDevelopment() {
            return !$this->IsProduction();
        }

        public function ArrayToObject(array $arr): \stdClass {
            return json_decode(json_encode($arr));
        }

        public function IntToBoolString(int $number): string {
            return $number > 0 ? "true" : "false";
        }

        public function FlatPageArray($tree): array {
            $flatArray = [];

            // Each children
            foreach($tree as $page) {
                // Get it's children flattend array (recursive)
                $child_flatArray = $this->FlatPageArray($page["children"]);

                // Push it to flat array (foreach for flatting)
                foreach($child_flatArray as $item) {
                    $flatArray[] = $item;
                }
                
                // Add current foreach item to flattened array
                $flatArray[] = $page;
            }
            
            return $flatArray;
        }

        public function FormatName(string $name) {
            return str_replace("_", " ", $name);
        }

        public function RecursiveDelete($str) {
            if (is_file($str)) {
                return @unlink($str);
            }
            elseif (is_dir($str)) {
                $scan = glob(rtrim($str,'/').'/*');
                foreach($scan as $index=>$path) {
                    $this->RecursiveDelete($path);
                }
                return @rmdir($str);
            }
        }
    }