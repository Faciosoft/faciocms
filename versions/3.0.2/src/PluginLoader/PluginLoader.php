<?php
    namespace FacioCMS\Versions\v3\App\Source;

    use FacioCMS\Plugins\FacioCMSPlugin\Event;
    use FacioCMS\Plugins\FacioCMSPlugin\EnablePluginEvent;
    use FacioCMS\Plugins\FacioCMSPlugin\DisablePluginEvent;
    use FacioCMS\Plugins\FacioCMSPlugin\ClientResponseGeneratingEvent;

    trait PluginLoader {
        protected array $plugin_instances = [];
        private $cms;

        public function GetInitializedPlugins(): array {
            return $this->plugin_instances;
        }

        public function LoadPlugins($cms): void {
            $this->cms = $cms;

            $plugin_folders = scandir("../plugins");
            
            // Initializing plugins
            foreach($plugin_folders as $name) {
                if($name === "." || $name === "..") continue;

                $this->InitPlugin($name);
            }
        }

        public function UnloadPlugins(): void {
            foreach($this->plugin_instances as $plugin) {
                $plugin->OnDisable(new DisablePluginEvent);
                unset($plugin);
            }
        }

        private function GetPluginPath(string $name) {
            return "../plugins/$name/";
        }

        protected function GetPluginConfig(string $name) {
            $config_path = $this->GetPluginPath($name) . "plugin.json";
            $config_text = file_get_contents($config_path);
            return json_decode($config_text);
        }

        private function InitPlugin(string $name): void {
            $config = $this->GetPluginConfig($name);
            $path = $this->GetPluginPath($name);

            if(!$this->VerifyPlugin($config->identifies->{'~uuid'})) return;

            // Including plugin
            require($path . $config->source);
            
            $plugin_class = null;
            eval("\$plugin_class = \\FacioCMS\\Plugins\\$name\\$name::class;");

            if(!$plugin_class) return;

            // Initializing the plugin
            $plugin = new $plugin_class($this->cms, $path, $name, $config);
            $plugin->OnEnable(new EnablePluginEvent);

            $this->plugin_instances[] = $plugin;
        }

        // TODO
        private function VerifyPlugin(string $plugin_uuid): bool {
            return true;
        }

        protected function FireEvent(Event|EnablePluginEvent|DisablePluginEvent|ClientResponseGeneratingEvent $event): void {
            foreach($this->plugin_instances as $plugin) {
                $plugin->FireEvent($event);
            }
        }
    }