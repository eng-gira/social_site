<?php

    class homeController extends Controller
    {
        public function index()
        {
            // echo "index() from homeController. id = ". $id . ", name = ". $name . "<br>";
            $view = new View('home' . DIRECTORY_SEPARATOR . 'index');
        }

        public function about()
        {
            echo "ABOUT<br>";
        }

        public function pageNotFound()
        {
            self::goHome();
        }
    }
?>