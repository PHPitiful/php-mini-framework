<?php

    class Route {
   
        private $routes = [];

        public function register($regex, $callback) {
            $this->routes[$regex] = $callback;
        }
    
        public function handle() {
            $uri = Mini::get('request')->getUri();
            foreach ($this->routes as $regex => $callback) {
                if (preg_match($regex, $uri, $params)) {
                    array_shift($params);
                    return call_user_func_array($callback, array_values($params));
                }
            }
            Mini::get('response')->setError()->flush();
        }

    }
