<?php

    session_start();
    class commentController
    {
        public function newComment()
        {
            if(!isset($_SESSION['username']))
            {
                $this->goHome();
                return false; // to never pass this line
            }

            $post = isset($_POST['post']) ? intval($_POST['post']) : -1;
            $body = isset($_POST['body']) ? $_POST['body'] : '';

            if($post < 0 || strlen($body) < 1)
            {
                $this->goHome();
                return false; // to never pass this line
            }

            if(!Comment::newComment($body, intval($_SESSION['username']), $post))
            {
                $this->gotHome();
                return false; // to never pass this line
            }

            return true;
        }

        public function goHome()
        {
            header("Location: /ekom/public/home");
        }
    }

?>