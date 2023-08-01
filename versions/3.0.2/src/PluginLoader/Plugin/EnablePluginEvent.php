<?php
    namespace FacioCMS\Plugins\FacioCMSPlugin;

    use \FacioCMS\Plugins\FacioCMSPlugin\Event;

    class EnablePluginEvent extends Event {
        protected string $name = "EnablePluginEvent";
    }