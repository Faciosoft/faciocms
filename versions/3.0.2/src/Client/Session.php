<?php
    namespace FacioCMS\Client;

    use FacioCMS\Client\ClientAPI;

    class Session {
        public static function Init($cms): ClientAPI {
            return new ClientAPI($cms);
        }
    }