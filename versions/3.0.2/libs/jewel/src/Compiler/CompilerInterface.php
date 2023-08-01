<?php
    namespace Jewel;

    interface CompilerInterface {
        /**
         * @name Run
         * @param {string $source_file}
         * @param {string $dist_file}
         * @return void
         * 
         * This method starts whole template compiling process
         */
        public function Run(string $source_file, string $dist_file): void;

        /**
         * @name ReadSourceBuffer
         * @param {string $filename}
         * @return string
         * 
         * This method read source file of layout
         */
        public function ReadSourceBuffer(string $filename): string;

        /**
         * @name BufferToLines
         * @param {string $source_buffer}
         * @return array
         * 
         * This method returns array of lines of source buffer
         */
        public function BufferToLines(string $source_buffer): array;

        /**
         * @name TransformLines
         * @param {array $lines}
         * @return string
         * 
         * This method returns compiled buffer
         */
        public function TransformLines(array $lines): string;

        /**
         * @name TransformLine
         * @param {int $line_number}
         * @param {string $line_buffer}
         * @return string
         * 
         * This method returns compiled line
         */
        public function TransformLine(int $line_number, string $line_buffer): string;

        /**
         * @name Parse<TAG>TagExpr
         * @param {string $line_buffer}
         * @return string
         * 
         * This methods returns line with parsed <TAG>
         */
        public function ParseContentTagExpr(string $line_buffer): string;
        public function ParseIfTagExpr(string $line_buffer): string;
        public function ParseElseIfTagExpr(string $line_buffer): string;
        public function ParseForeachTagExpr(string $line_buffer): string;
        public function ParseSwitchTagExpr(string $line_buffer): string;
        public function ParseCaseTagExpr(string $line_buffer): string;
        public function ParseForTagExpr(string $line_buffer): string;
        public function ParseWhileTagExpr(string $line_buffer): string;
    }