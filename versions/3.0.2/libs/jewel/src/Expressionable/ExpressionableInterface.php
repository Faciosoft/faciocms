<?php
    namespace Jewel;

    interface ExpressionableInterface {
        /**
         * @name HasExpression
         * @param {string $content}
         * @param {string $exp}
         * @return bool
         * 
         * Check if string matches expression
         */
        public function HasExpression(string $content, string $exp): bool;
    }