<?php

    class DB
    {
        private static $host = "localhost";
        private static $user = "root";
        private static $pw = "";
        private static $DB = "ekom_db";

        protected static function connect()
        {
            $conn = new mysqli(self::$host, self::$user, self::$pw, self::$DB);
            
            return $conn;
        }
    }

?>