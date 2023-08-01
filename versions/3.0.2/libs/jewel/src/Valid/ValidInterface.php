<?php
    namespace Jewel;

    interface ValidInterface {
        /**
         * @name Valid
         * @param {string $file_name}
         * @return bool
         * 
         * This method check if passed layout file is valid
         */
        public function Valid(string $file_name): bool;
    }