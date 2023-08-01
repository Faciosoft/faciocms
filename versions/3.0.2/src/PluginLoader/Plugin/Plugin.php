<?php
    namespace FacioCMS\Plugins\FacioCMSPlugin;

    use FacioCMS\Plugins\FacioCMSPlugin\Event;
    use FacioCMS\Plugins\FacioCMSPlugin\EnablePluginEvent;
    use FacioCMS\Plugins\FacioCMSPlugin\DisablePluginEvent;
    use FacioCMS\Plugins\FacioCMSPlugin\ClientResponseGeneratingEvent;

    class Plugin {
        protected $cms;
        protected string $path;
        protected string $name;
        protected \stdClass $config;

        public function __construct($cms, string $path, string $name, \stdClass $config) {
            $this->cms = $cms;
            $this->path = $path;
            $this->name = $name;
            $this->config = $config;
        }

        public function FireEvent(Event|EnablePluginEvent|DisablePluginEvent|ClientResponseGeneratingEvent $event): void {
            $name = $event->getName();

            switch($name) {
                case 'DisablePluginEvent':
                    $this->OnDisable($event);
                    break;
                case 'EnablePluginEvent':
                    $this->OnEnable($event);
                    break;
                case 'ClientResponseGeneratingEvent':
                    $this->OnClientResponseGenerating($event);
                    break;
            }
        }

        protected function PluginError(string $error): void {
            echo "<!-- Plugin Error: $error -->";

            $event = new DisablePluginEvent;
            $this->FireEvent($event);
        }
    
        public function GetName(): string {
            return $this->name;
        }

        public function GetConfig(): \stdClass {
            return $this->config;
        }
    }