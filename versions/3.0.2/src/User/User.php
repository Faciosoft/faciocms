<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name User
     * Provides methods for User Controllment
     */
    trait User {
        public function GetAllUsers(): array {
            global $database;
            return $database->Select("SELECT * FROM `fcms_users`");
        }

        // This functions set userLevel at class <Core>App (launcher)
        public function InitUserAtCMS(): void {
            global $database;

            // Checking if user is not logged into system
            if(!$this->user) return; 

            // Query
            $id = $this->user["id"];
            $query = "SELECT `permissions_level` FROM `fcms_users` WHERE `id`='$id'";

            // Getting results
            $results = $database->Select($query);
            if(empty($results)) return;

            $this->userLevel = $results[0]['permissions_level'];
        }

        // Get user by username
        public function GetUserByUsername(string $username): \stdClass|null {
            global $database;

            // Preparing query
            $query = "SELECT * FROM `fcms_users` WHERE `username`='$username'";

            // Results
            $results = $database->Select($query);

            // No user with this username
            if(empty($results)) return null;

            return json_decode(json_encode($results[0]));
        }

        // Get user by email
        public function GetUserByEmail(string $email): \stdClass|null {
            global $database;

            // Preparing query
            $query = "SELECT * FROM `fcms_users` WHERE `email`='$email'";

            // Results
            $results = $database->Select($query);

            // No user with this email
            if(empty($results)) return null;

            return json_decode(json_encode($results[0]));
        }

        // Avatar
        public function GetUserAvatar(): string {
            return "/assets/avatars/0000-default.png";
        }
    }