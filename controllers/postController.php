<?php

    class postController extends Controller
    {
        public function new()
        {
            if(!isset($_SESSION['username']))
            {
                self::goHome();
            }
            new View('post'. DIRECTORY_SEPARATOR .'new_post');
        }

        public function insert()
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
                self::goHome();
                return false;
            }
            if(Post::insertPost($post_title, $post_body, $post_author))
            {
                self::goProfile();
                return true;
            }
        }
 
        public function edit($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                header("Location: /social_site/public/home");
                return false;
            }
            
            new View('post' . DIRECTORY_SEPARATOR. 'edit_post', 
                array('post_id'=>$id));
            
        }

        public function update($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                header("Location: /social_site/public/home");
                return false;
            }

            $new_title = isset($_POST['new_title']) ? htmlspecialchars($_POST['new_title']) : '';
            $new_body = isset($_POST['new_body']) ? htmlspecialchars($_POST['new_body']) : '';

            if(strlen($new_title) < 1 || strlen($new_body) <1) 
            {
                header("Location: /social_site/public/auth/dashboard");
                return false;
            }

            if(!Post::updatePost($id, $new_title, $new_body))
            {
                header("Location: /social_site/public/auth/dashboard");
                return false;
            }

            header("Location: /social_site/public/auth/dashboard");
            return true;
        }
        
        
        public function delete($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                header("Location: /social_site/public/home");
                return false;
            }

            if(!Post::deletePost($id)) 
            {
                header("Location: /social_site/public/auth/dashboard");
                return false;
            }

          //  header("Location: /ekom/public/auth/dashboard");
            return true;
        }

        public function upvote($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goProfile();

            if(Post::upvote($id)=='upvoted')
            {
                echo 'upvoted'; return;
            }

            echo 'upvote';
        }

        public function downvote($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goProfile();

            if(Post::downvote($id))
            {
                echo 'downvoted';return;
            }

            echo 'downvote';
        }
       
        public function show($id=-1)
        {
            if($id<0) self::goProfile();

            $post=Post::getPostOfId($id);

            if(isset($post))
            {
                $comments = Comment::showCommentsForPost($id);

                new View ('post' . DIRECTORY_SEPARATOR . 'show_post', ['post'=>$post, 
                'comments'=>$comments]);
            }

        }
    }
?>