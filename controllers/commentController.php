<?php

    class commentController extends Controller
    {
        public function newComment()
        {
            if(!isset($_SESSION['username']))
            {
                self::goHome();
            }

            $post = isset($_POST['post_id']) ? $_POST['post_id'] : -1;
            $body = isset($_POST['comment_body']) ? htmlspecialchars($_POST['comment_body']) : '';

            if($post < 0 || strlen($body)<1)
            {
                self::goHome();
            }

            if(Comment::newComment($body, User::findUserByUsername($_SESSION['username']), $post))
            {
                echo $body."<br>";
                return true;
            }

            self::goDashboard();
        }
    }

?>