<?php
    namespace FacioCMS\Versions\v3\API;

    /**
     * @name Auth
     * Controller for Authentication
     */
    trait Auth {
        public function HandleAPI_Login() {
            global $database;

            header('Content-Type: application/json');

            // Preparing data
            $body = file_get_contents('php://input');
            $data = json_decode($body);

            $username = $data->username;
            $password = $data->password;
            if(!$username || !$password) return ["error" => true, "content-message" => "Username or password not found!"];

            $hashed_password = hash('sha256', $password);    

            // Querying to database
            $query = "SELECT * FROM `fcms_users` WHERE `username`='$username' AND `password`='$hashed_password'";
            $matching = $database->Select($query);

            // Checking if response is empty
            if(count($matching) === 0) return ["error" => true, "content-message" => "Username or password is invalid!"];

            // If not then we got user
            $user = $matching[0];

            // Saving it
            $_SESSION["FACIOCMS_LOGGED"] = true;
            $_SESSION["USER_ID"] = $user["id"];

            return ["error" => false, "content-message" => "Successfully logged!"];
        }
    }