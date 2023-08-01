<?php
    namespace Jewel\Valid\Concerns;

    trait Valid {
        public function Valid(string $file_name): bool {
            // TODO: Checking other params
            return file_exists($file_name);
        }
    }