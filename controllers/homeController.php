<?php

    class homeController extends Controller
    {
        public function index($error='')
        {
            // echo "index() from homeController. id = ". $id . ", name = ". $name . "<br>";
            $view = new View('home' . DIRECTORY_SEPARATOR . 'index', ['error' => $error]);
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