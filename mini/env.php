<?php

    class Env {
       
        private $d = [];
 
        public function load() {
            $ini = parse_ini_file('.env');
            foreach ($ini as $k => $v) {
                $this->d[$k] = $v; 
            }
        }

        public function get($key) {
            return $this->d[$key];
        }

    }
