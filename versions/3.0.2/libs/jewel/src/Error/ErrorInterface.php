<?php
    namespace Jewel;

    interface ErrorInterface {
        /**
         * @name PreprocessError
         * @param {string $error_text}
         * @return void
         * 
         * Throws an preprocessing error
         */
        public function PreprocessError(string $error_text): void;

        /**
         * @name CompilationError
         * @param {string $error_text}
         * @param {int $line}
         * @return void
         * 
         * Throws an compilation error
         */
        public function CompilationError(string $error_text, int $line): void;
    }