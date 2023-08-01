<?php
    namespace FacioCMS\Versions\v3\API;


    /**
     * @name User
     * Controller for Users
     */
    trait User {
        public function HandleAPI_CreateUser() {
            global $database;

            header('Content-Type: application/json');

            // Checking permissions
            if(!$this->HasAtLeast("Admin")) return ["error" => true, "content-message" => "Insufficient permissions"];            

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $username           = $database->Escape($data->username);
            $email              = $database->Escape($data->email);
            $password           = $database->Escape($data->password);
            $confirm_password   = $database->Escape($data->confirm_password);
            $role               = $database->Escape($data->role);
            $hashed_password    = hash('sha256', $password);
            $perm_level         = $this->GetUserPermissionLevelByRoleString($role);
            $date               = date('Y-m-d H:i:s');

            // Checking if passwords match
            if($password != $confirm_password) return [ "error" => true, "content-message" => "Passwords doesn't match" ];

            // Checking if user exists
            if($this->GetUserByUsername($username)) return [ "error" => true, "content-message" => "User with username: $username exists!" ];
            if($this->GetUserByEmail($email)) return [ "error" => true, "content-message" => "User with email: $email exists!" ];

            // Query
            $query = "INSERT INTO `fcms_users` VALUES ('', '$username', '$email', '$hashed_password', '$perm_level', '$date', '$date', '')";

            return $database->Raw($query) ?
                [ "error" => false, "content-message" => "Successfully created new user!" ]: 
                [ "error" => true, "content-message" => "Failed to create new user!" ];
        }

        public function HandleAPI_DeleteUser() {
            global $database;

            header('Content-Type: application/json');

            // Checking permissions
            if(!$this->HasAtLeast("Admin")) return ["error" => true, "content-message" => "Insufficient permissions"];

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $id = $database->Escape($data->id);

            // Query
            $query = "DELETE FROM `fcms_users` WHERE `id`=$id";

            return $database->Raw($query) ?
                [ "error" => false, "content-message" => "Successfully deleted user!" ]: 
                [ "error" => true, "content-message" => "Failed to delete user!" ];
        }
    }