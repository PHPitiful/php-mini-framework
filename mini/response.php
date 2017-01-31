<?php

    class Response {

        private $response_code = 200,
                $file_name     = false;

        public function setType($type) {
            $this->content_type = $type;
            return $this;
        }

        public function setFilename($file_name) {
            $this->file_name = $file_name;
            return $this;
        }
    
        public function setContent($data) {
            $this->content = $data;
            return $this;
        }

        public function setError() {
            $this->response_code = 404;
            $this->content_type  = 'json';
            $this->content       = json_encode(['success' => false]);
            return $this;
        }

        public function flush() {
            http_response_code($this->response_code);
            foreach (TypeMap::get($this->content_type) as $header_line) {
                $decorated_header = sprintf($header_line, $this->file_name);
                header($decorated_header);
            }
            echo $this->content;
            die();
        }

    }
