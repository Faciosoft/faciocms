<?php
    namespace FacioCMS\Plugins\FacioCMSPlugin;

    use \FacioCMS\Plugins\FacioCMSPlugin\Event;

    class ClientResponseGeneratingEvent extends Event {
        public static int $UNINITIALZIED = -1;
        public static int $BEGINNING = 0;
        public static int $ENDING = 1;
        public static int $HEAD = 2;

        protected string $name = "ClientResponseGeneratingEvent";
        public int $state = -1;
    }    