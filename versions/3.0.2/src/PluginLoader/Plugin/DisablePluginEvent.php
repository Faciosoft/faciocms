<?php
    namespace FacioCMS\Plugins\FacioCMSPlugin;

    use \FacioCMS\Plugins\FacioCMSPlugin\Event;

    class DisablePluginEvent extends Event {
        protected string $name = "DisablePluginEvent";
    }