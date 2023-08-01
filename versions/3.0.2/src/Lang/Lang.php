<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Lang
     * Language
     */
    trait Lang {
        public function Translate(string $trans): string {
            $locale = 'EN';
            $transname = strtoupper($locale . '_' . $trans);
            $string = 'return ' . ($transname) . ';';

            if(!defined($transname)) return "Translation for \"$trans\" not found in locale $locale";

            return eval($string) ?? "Translation for \"$trans\" not found in locale $locale";
        }

        public function PrintTranslate(string $trans) {
            echo $this->Translate($trans);
        }
    }