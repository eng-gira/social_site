<?php
    class View
    {
        private $data;

        public function __construct($file = "home", $data=array())
        {
            $this->data = $data;

            if(file_exists(VIEW . $file . '.php'))
            {
              include VIEW . $file . '.php';
            }
        }

        public function getData()
        {
            return $this->data;
        }
    }
?>