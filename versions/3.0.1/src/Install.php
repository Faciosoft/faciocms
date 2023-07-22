<?php
    namespace FacioCMS\Versions\v3\App\Source;

    use FacioCMS\Roles\Roles;

    define("FACIOCMS_REQUIRED_TABLES", [
        "fcms_pages" => "CREATE TABLE `fcms_pages` ( `id` INT NOT NULL AUTO_INCREMENT , `parent_id` INT NOT NULL , `title` TEXT NOT NULL , `subtitle` TEXT NOT NULL , `content` TEXT NOT NULL , `created_at` TEXT NOT NULL , `updated_at` TEXT NOT NULL , `updated_by` INT NOT NULL , `layout` TEXT NOT NULL , `url` TEXT NOT NULL, PRIMARY KEY (`id`))",
        "fcms_users" => "CREATE TABLE `fcms_users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` TEXT NOT NULL , `email` TEXT NOT NULL , `password` TEXT NOT NULL , `permissions_level` INT NOT NULL , `created_at` TEXT NOT NULL , `updated_at` TEXT NOT NULL , `last_login` TEXT NOT NULL , PRIMARY KEY (`id`) )",
        "fcms_settings" => "CREATE TABLE `fcms_settings` ( `id` INT NOT NULL AUTO_INCREMENT , `prod` INT NOT NULL , `website_name` TEXT NOT NULL , `website_url` TEXT NOT NULL , `theme_color` TEXT NOT NULL , `secondary_color` TEXT NOT NULL , `autoupdate` INT NOT NULL , `supercaching` INT NOT NULL , PRIMARY KEY (`id`))",
        "fcms_pagemeta" => "CREATE TABLE `fcms_pagemeta` ( `id` INT NOT NULL AUTO_INCREMENT , `owner_id` INT NOT NULL , `name` TEXT NOT NULL , `value` TEXT NOT NULL , PRIMARY KEY (`id`))",
        "fcms_assets" => "CREATE TABLE `fcms_assets` ( `id` TEXT NOT NULL , `owner_id` INT NOT NULL , `type` TEXT NOT NULL )"
    ]);

    /**
     * @name Install
     * Provides methods for Installation
     */
    trait Install {
        public function InstallCheck(): void {
            $this->InstallDatabase();
            $this->InstallAdminUser();
            $this->InstallSimpleConfig();
        }

        public function InstallDatabase(): void {
            global $database;

            foreach(FACIOCMS_REQUIRED_TABLES as $tableName => $tableQuery) {
                if(!$database->Describe($tableName)) {
                    // Table cannot be described so it don't exist!
                    $database->Raw($tableQuery);
                }
            }
        }

        private function InstallAdminUser(): void {
            global $database;

            $users = $database->Select('SELECT * FROM `fcms_users`');
            if(count($users) > 0) return; // There are some users.

            header('Content-Type: text/plain');

            // Creating user
            $username = 'admin';
            $password = uniqid();
            $hashed_password = hash('sha256', $password);
            $date = date("Y-m-d H:i:s");

            // 4 is Super Admin Permission Level
            $query = "INSERT INTO `fcms_users` VALUES (NULL, '$username', '', '$hashed_password', 4, '$date', '$date', '')";
            $error = !$database->Raw($query);

            // If error
            if($error) {
                echo "Error while creating auto-user.";
                exit();
            }

            // Outputting
            echo <<<EOD
            +++++++++++++++++++++++++++++++++++++++
            --- FacioCMS auto-generated message ---
            +++++++++++++++++++++++++++++++++++++++

            FacioCMS didn't detect any users in database!
            So FacioCMS automatically generated super user with this credentials:
            
            Username: $username
            Password: $password
            EOD;

            exit();
        }

        private function InstallSimpleConfig() {
            global $database;

            $query = "SELECT * FROM `fcms_settings`";
            if(count($database->Select($query)) > 0) return; // Config exists

            $query = "INSERT INTO `fcms_settings` (`id`, `prod`, `website_name`, `website_url`, `theme_color`, `secondary_color`, `autoupdate`, `supercaching`) VALUES (NULL, '0', 'FacioCMS website', 'https://faciocms.com', '#242b38', '#fc3333', '0', '0');";
            $database->Raw($query);
        }
    }