<?php
    namespace FacioCMS\Client\Utils;

    class Group {
        private $items;

        public function __construct($items) {
            $this->items = $items;
        }

        public function All() {
            return $this->items;
        }

        public function First() {
            return count($this->items) > 0 ? $this->items[0] : null;
        } 

        public function Last() {
            return count($this->items) > 0 ? $this->items[count($this->items) - 1] : null;
        }

        public function IsEmpty() {
            return !count($this->items) > 0;
        }

        public function IsNotEmpty() {
            return !$this->IsEmpty();
        }

        public function At($index) {
            return $this->items[$index];
        }

        public function Count() {
            return count($this->items);
        }

        public function Clear() {
            $this->items = [];
        }

        public function PushToEnd($item) {
            $this->items[] = $item;
        }

        public function PushToStart($item) {
            array_unshift($this->items, $item);
        }
    }