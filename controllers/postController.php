<?php
    session_start();

    class postController
    {
        public function newPost()
        {
            if(!isset($_SESSION['username']))
            {
                header("Location: ../home");
                return false;
            }

            $post_title = htmlspecialchars($_POST['post_title']);
            $post_body = htmlspecialchars($_POST['post_body']);
            $post_author = User::findUserByUsername($_SESSION['username']);

            if(strlen($post_title) < 1 || strlen($post_body) < 1 || $post_author < 0)
            {
                header("Location: ../home");
                return false;
            }

            if(Post::insertPost($post_title, $post_body, $post_author))
            {
                header("Location: ../auth/dashboard");
                return true;
            }
        }

        public function deletePost()
        {

        }
        
        public function editPost()
        {
            
        }

        public function updatePost()
        {

        }
    }
?>