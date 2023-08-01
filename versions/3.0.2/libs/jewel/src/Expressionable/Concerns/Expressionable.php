<?php
    namespace Jewel\Expressionable\Concerns;

    trait Expressionable {
        public function HasExpression(string $content, string $exp): bool {
            return preg_match($exp, $content);
        }
    }