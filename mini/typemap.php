<?php

    class TypeMap {

        private static $map = [
                                'json' => ['Content-Type: application/json'],
                                'pdf'  => ['Content-Type: application/pfd',
                                           'Content-Disposition: inline; filename="%s"']
                              ];

        public static function get($entity) {
            return self::$map[$entity];
        }

    }
