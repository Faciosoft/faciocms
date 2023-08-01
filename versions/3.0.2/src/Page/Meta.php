<?php
    namespace FacioCMS\Versions\v3\App\Source\Page;

    trait Meta {
        public function CreatePageMetaPair(string $owner, string $key, string $value): bool {
            global $database;

            // Escaping
            $owner  = $database->Escape($owner);
            $key    = $database->Escape($key);
            $value  = $database->Escape($value);
            
            // Query
            $query = "INSERT INTO `fcms_pagemeta` VALUES (NULL, '$owner', '$key', '$value')";

            return !!$database->Raw($query);
        } 

        public function GetMetaKey(string $owner, string $key) {
            global $database;

            // Escaping
            $owner  = $database->Escape($owner);
            $key    = $database->Escape($key);

            // Query
            $query = "SELECT `value` FROM `fcms_pagemeta` WHERE `owner_id`='$owner' AND `name`='$key'";

            $results = $database->Select($query);

            return count($results) === 0 ? null : $results[0];
        }

        public function DeleteAllMetaKeysFor(int $owner) {
            global $database;

            // Escaping
            $owner = $database->Escape($owner);

            // Query
            $query = "DELETE FROM `fcms_pagemeta` WHERE `owner_id`='$owner'";

            return !!$database->Raw($query);
        }

        public function GetAllMetaSettings(int $owner) {
            global $database;

            // Escaping
            $owner = $database->Escape($owner);

            // Query
            $query = "SELECT * FROM `fcms_pagemeta` WHERE `owner_id`='$owner'";

            return $database->Select($query);
        }

        public function IsSecretMetaSetting(string $name) {
            return $name[0] === "$";
        }
    
        public function ExtractMeta(array $page): array {
            global $database;

            $page_id = @$page["id"];
            if(!$page_id) return [ "error" => true ];

            $query = "SELECT * FROM `fcms_pagemeta` WHERE `owner_id`='$page_id'";
            $results = $database->Select($query);
            $out = [];

            // Formatting from ({ name: 'key', value: 'value' }) to ({ key: 'value' })
            foreach($results as $result) {
                $out[$result["name"]] = $result["value"];
            }

            return $out;
        }
    }