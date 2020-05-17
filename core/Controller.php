<?php
    session_start();

    class Controller
    {
        protected static function goHome()
        {
            header("Location: /social_site/public/");
            return false;
        }

        protected static function goProfile()
        {
            //double check 
            if(!isset($_SESSION['username'])) self::goHome();

            header("Location: /social_site/public/auth/profile");
            return false;
        }
    }
?>