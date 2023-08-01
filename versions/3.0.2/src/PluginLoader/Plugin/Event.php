<?php
    namespace FacioCMS\Plugins\FacioCMSPlugin;

    class Event {
        protected string $name;

        public function __construct() {}

        public function setName(string $newName): void {
            $this->name = $newName;
        }

        public function getName(): string {
            return $this->name;
        }
    }