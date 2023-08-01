<?php
    namespace FacioCMS\Versions\v3\App\Source;

    // Main Idea:
    /** When any user first see page which is not in admin panel it will save cache version of it on drive example in /cache/pages directory as md5($_SERVER['REQUEST_URI']).
     *  When another user will enter this URL this cached page will be required and we just give it simple informations like current page description etc.
     *  In admin panel in page editor button "CLEAR THIS PAGE CACHE" which will delete this page cache
     */ 

    // Super Caching System
    /**
     * This system disable all dynamic website and cache every page.
     */
    trait Caching {
        public function CachingEnabled(): bool {
            $value = $this->GetSetting('supercaching')->value;

            return $value === 'false' ? false : true;
        }

        public function LoadCachedPage(): void {
            $uri = $_SERVER["REQUEST_URI"];
            $cache_hash = md5($uri);
            $cache_file_path = "../cache/pages/$cache_hash.cache.html";

            if(file_exists($cache_file_path)) {
                require $cache_file_path;
                exit();
            }
        }

        public function CachePage($content) {
            $uri = $_SERVER["REQUEST_URI"];
            $cache_hash = md5($uri);
            $cache_file_path = "../cache/pages/$cache_hash.cache.html";

            echo $cache_file_path;

            // https://phppot.com/php/php-cache-for-dynamic-web-pages/
            file_put_contents($cache_file_path, $content);

            return $content . '';
        }
    }