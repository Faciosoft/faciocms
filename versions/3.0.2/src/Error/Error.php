<?php
    namespace FacioCMS\Versions\v3\App\Source;

    trait Error {
        public function QuitWithError($error_name, $error_description) {
            echo "<h1>$error_name</h1>";
            echo "<p>$error_description</p>";
            exit();
        }
    }