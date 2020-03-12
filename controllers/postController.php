<?php

    class postController extends Controller
    {
        public function newPost()
        {
            if(!isset($_SESSION['username']))
            {
                self::goHome();
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
 
        public function editPost($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                header("Location: /ekom/public/home");
                return false;
            }
            
            new View('auth' . DIRECTORY_SEPARATOR . 'editPost', array('post_id'=>$id));
            
        }

        public function updatePost($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                header("Location: /ekom/public/home");
                return false;
            }

            $new_title = isset($_POST['new_title']) ? htmlspecialchars($_POST['new_title']) : '';
            $new_body = isset($_POST['new_body']) ? htmlspecialchars($_POST['new_body']) : '';

            if(strlen($new_title) < 1 || strlen($new_body) <1) 
            {
                header("Location: /ekom/public/auth/dashboard");
                return false;
            }

            if(!Post::updatePost($id, $new_title, $new_body))
            {
                header("Location: /ekom/public/auth/dashboard");
                return false;
            }

            header("Location: /ekom/public/auth/dashboard");
            return true;
        }
        
        
        public function deletePost($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                header("Location: /ekom/public/home");
                return false;
            }

            if(!Post::deletePost($id)) 
            {
                header("Location: /ekom/public/auth/dashboard");
                return false;
            }

          //  header("Location: /ekom/public/auth/dashboard");
            return true;
        }

        public function upvote($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goDashboard();

            if(Post::upvote($id))
            {
                echo 'upvoted'; return;
            }

            echo 'upvote';
        }

        public function downvote($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goDashboard();

            if(Post::downvote($id))
            {
                echo 'downvoted';return;
            }

            echo 'downvote';
        }
       
    }
?>