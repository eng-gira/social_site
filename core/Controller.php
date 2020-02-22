<?php
    session_start();

    class Controller
    {
        protected static function goHome()
        {
            header("Location: /ekom/public/home");
            return false;
        }

        protected static function goDashboard()
        {
            //double check 
            if(!isset($_SESSION['username'])) self::goHome();

            header("Location: /ekom/public/auth/dashboard");
            return false;
        }
    }
?>