<?php

    class Mini {
    
        private static $container = [];

        public static function init($path_array) {

            $path_array[] = 'mini';
            $current_path = getcwd();
            $paths        = get_include_path();

            foreach ($path_array as $path) {
                $paths .= ':' . $current_path . '/' . $path; 
            } 

            set_include_path($paths);
            spl_autoload_extensions('.php');
            spl_autoload_register();

            self::register(['env'      => new Env(),
                            'request'  => new Request(),
                            'route'    => new Route(), 
                            'response' => new Response()]);

            self::get('env')->load();
        }

        public static function register($entity) {
            self::$container = array_merge(self::$container, $entity);
        }

        public static function get($entity) {
            return self::$container[$entity];
        }

    }
