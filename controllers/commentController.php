<?php

    class commentController extends Controller
    {
        public function newComment($post = -1)
        {
            if(!isset($_SESSION['username']))
            {
                self::goHome();
            }

            $body = isset($_POST['comment_body']) ? htmlspecialchars($_POST['comment_body']) : '';

            if($post < 0 || strlen($body)<1)
            {
                self::goHome();
            }

            Comment::newComment($body, User::findUserByUsername($_SESSION['username']), $post);

            self::goDashboard();
        }
    }

?>