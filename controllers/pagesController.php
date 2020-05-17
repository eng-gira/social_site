<?php

    class pagesController extends Controller
    {
        public function index()
        {
            new View('home', 
                ['all_posts'=>Post::getAllPosts()]);
        }

        public function about()
        {
            new View('about');
        }

        public function settings()
        {
            
        }

        public function pageNotFound()
        {
            self::goHome();
        }
    }
?>