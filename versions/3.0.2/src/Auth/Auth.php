<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Auth
     * Provides methods for authorization (login / signup etc)
     */
    trait Auth {
        public function IsLogged(): bool {
            return array_key_exists("FACIOCMS_LOGGED", $_SESSION) && $_SESSION["FACIOCMS_LOGGED"] == true;
        }

        public function GetUser() {
            global $database;

            // Can return value only when user is logged
            if(!$this->IsLogged()) return null;

            // Query
            $id = $_SESSION["USER_ID"];
            $query = "SELECT * FROM `fcms_users` WHERE `id`='$id'";
            $data = $database->Select($query);

            // No user with this id
            if(count($data) === 0) return null;

            // Returning first user
            return $data[0];
        }
    }