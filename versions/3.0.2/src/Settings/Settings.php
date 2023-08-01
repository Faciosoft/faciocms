<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Settings
     * Provides settings from database
     */
    trait Settings {
        public function GetSetting(string $setting_name) {
            global $database;

            // Getting settings row
            $query = "SELECT `$setting_name` FROM `fcms_settings` LIMIT 1";
            $data = $database->Select($query);

            if(count($data) === 0) return $this->ArrayToObject([ "exists" => false, "value" => null ]); // No setting like this

            $value = $data[0][$setting_name];
            return $this->ArrayToObject([ "exists" => true, "value" => is_numeric($value) ? $this->IntToBoolString($value) : $value ]);
        }
    }