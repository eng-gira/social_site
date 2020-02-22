<?php

    class homeController extends Controller
    {
        public function index($id='', $name='')
        {
            // echo "index() from homeController. id = ". $id . ", name = ". $name . "<br>";
            $view = new View('home' . DIRECTORY_SEPARATOR . 'index', ['id' => $id, 'name' => $name]);
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