<?php
    namespace Jewel\Compiler\Concerns;

    trait Buffer {
        public function BufferToLines(string $source_buffer): array {
            return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? explode('\r\n', $source_buffer) : explode('\n', $source_buffer);
        }

        public function ReadSourceBuffer(string $filename): string {
            return file_get_contents($filename);
        }
    }