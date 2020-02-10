<?php

    class DB
    {
        private $host = "localhost";
        private $user = "root";
        private $pw = "";
        private $DB = "ekom_db";

        protected function connect()
        {
            $conn = new mysqli($host, $user, $pw, $DB);
            
            return $conn;
        }
    }

?>