<?php
    namespace FacioCMS\Versions\v3\App\Source;

    define("FACIOCMS_FACIOCODE_MULPT", 0xABCD);
    define("FACIOCMS_FACIOCODE_ENABLED", true);

    function encrypt_faciocode(int $number, bool $special = false): string {
        if(!FACIOCMS_FACIOCODE_ENABLED) return "" . $number;

        $sormap = [7, 3, 8, 2, 9, 4, 7, 1, 6, 7];
        $netmap = [5, 7, 2, 1, 8, 3, 1, 2, 9, 2];

        $seed = $special ? random_int(16, 256) : random_int(1024 * 1024, 8192 * 8192);

        $number *= $seed;

        $str = "$number";
        $encrypted = "$seed-";

        foreach(str_split($str) as $key => $char) {
            $num = (intval($char) + 1) * FACIOCMS_FACIOCODE_MULPT;
            $index = $key % 10;

            $v_index = $sormap[$key] ** $netmap[9 - $key];
            $num *= $v_index;
            
            $encrypted .= base_convert($num, 10, 16);

            if($key !== strlen($str) - 1) $encrypted .= "-";
        }

        return $encrypted;
    }

    function decrypt_faciocode(string $encrypted): int {
        if(!FACIOCMS_FACIOCODE_ENABLED) return intval($encrypted);

        $sormap = [7, 3, 8, 2, 9, 4, 7, 1, 6, 7];
        $netmap = [5, 7, 2, 1, 8, 3, 1, 2, 9, 2];

        $number_str = '';
        $seed = 1;

        foreach(explode('-', $encrypted) as $key => $enc_part) {
            if($key === 0) {
                $seed = intval($enc_part);
                continue;
            }

            $num = intval(base_convert($enc_part, 16, 10));
            $index = ($key - 1) % 10;

            $v_index = $sormap[$key - 1] ** $netmap[9 - ($key - 1)];
            $num /= $v_index;
            $num = round($num);

            $number_str .= $num / FACIOCMS_FACIOCODE_MULPT - 1;
        }

        return round(intval($number_str) / $seed);
    }

    function faciocode_encrypt_string(string $text): string {
        $out_text = '';
        
        foreach(str_split($text) as $key => $char) {
            $char_code = ord($char);
            $out_text .= encrypt_faciocode($char_code, true) . ($key === strlen($text) - 1 ? '' : '--');
        }

        return $out_text;
    }

    function faciocode_decrypt_string(string $text): string {
        $out_text = '';

        foreach(explode("--", $text) as $part) {
            $char_code = decrypt_faciocode($part);
            $char = chr($char_code);

            $out_text .= $char;
        }

        return $out_text;
    }