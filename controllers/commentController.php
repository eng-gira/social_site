<?php

    class commentController extends Controller
    {
        public function newComment()
        {
            if(!isset($_SESSION['username']))
            {
                self::goHome();
            }

            $post = isset($_POST['post']) ? intval($_POST['post']) : -1;
            $body = isset($_POST['body']) ? $_POST['body'] : '';

            if($post < 0 || strlen($body) < 1)
            {
                self::goHome();
            }

            if(!Comment::newComment($body, intval($_SESSION['username']), $post))
            {
                self::goDashboard();
            }

            return true;
        }
    }

?>