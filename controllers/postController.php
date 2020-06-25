<?php

    class postController extends Controller
    {
        public function new()
        {
            if(!isset($_SESSION['username']))
            {
                self::goHome();
                return;
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
            $post_author = User::getUserByUsername($_SESSION['username'])['id'];

            if(strlen($post_title) < 1 || strlen($post_body) < 1 || $post_author < 0)
            {
                $_SESSION['message']=array('error', 'Missing field(s)');
                $_SESSION['count_times_message_shown']=0;
                self::goHome();
                return false;
            }
            if(Post::insertPost($post_title, $post_body, $post_author))
            {
                $_SESSION['message']=array('success', 'Post inserted');
                $_SESSION['count_times_message_shown']=0;
                self::goProfile();
                return true;
            }
        }
 
        public function edit($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                self::goHome();
                return false;
            }
             
            //limiting access
            $post_author = Post::getPostOfId($id)['author'];
            if($post_author!=$_SESSION['id'])
            {
                $_SESSION['message']=array('error', 'Unauthorized access');
                $_SESSION['count_times_message_shown']=0;
                self::goHome();
            }

            new View('post' . DIRECTORY_SEPARATOR. 'edit_post', 
                array('post_id'=>$id));
            
        }

        public function update($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                self::goHome();
                return false;
            }
             
            //limiting access
             $post_author = Post::getPostOfId($id)['author'];
             if($post_author!=$_SESSION['id'])
             {
                $_SESSION['message']=array('error', 'Unauthorized access');
                $_SESSION['count_times_message_shown']=0;

                self::goHome();
            }

            $new_title = isset($_POST['new_title']) ? htmlspecialchars($_POST['new_title']) : '';
            $new_body = isset($_POST['new_body']) ? htmlspecialchars($_POST['new_body']) : '';

            if(strlen($new_title) < 1 || strlen($new_body) <1) 
            {
                $_SESSION['message']=array('error', 'Missing field(s)');
                $_SESSION['count_times_message_shown']=0;

                self::goProfile();
                return false;
            }

            if(!Post::updatePost($id, $new_title, $new_body))
            {
                $_SESSION['message']=array('error', 'Could not update post');
                $_SESSION['count_times_message_shown']=0;

                self::goProfile();
                return false;
            }

            $_SESSION['message']=array('success', 'Post updated');
            $_SESSION['count_times_message_shown']=0;

            self::goProfile();
            return true;
        }
        
        
        public function delete($id=-1)
        {
            if(!isset($_SESSION['username']) || $id < 0)
            {
                self::goHome();
                return false;
            }
            
            //limiting access
            $post_author = Post::getPostOfId($id)['author'];
            if($post_author!=$_SESSION['id'])
            {
                $_SESSION['message']=array('error', 'Unauthorized access');
                $_SESSION['count_times_message_shown']=0;

                self::goHome();
            }

            Post::deletePost($id);
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

            $author_data = User::getUserById($post['author']);
            
            if(isset($post))
            {
                $comments = Comment::showCommentsForPost($id);

                new View ('post' . DIRECTORY_SEPARATOR . 'show_post', ['post'=>$post, 
                'author_data'=>$author_data, 'comments'=>$comments]);
            }

        }

        public function search()
        {
            $search = isset($_POST['search']) ? $_POST['search'] : '';
            
            if(strlen($search)<1) self::goHome();
            
            $posts = Post::search($search);
            $count_search_res=count($posts);
            $authors = array();

            if(count($posts)>0)
            {
                foreach($posts as $post)
                {
                    $authors[$post['id']] = User::getUserById($post['author']);
                }
            }

            new View('post' . DIRECTORY_SEPARATOR . 'search', ['posts'=>$posts, 'authors'=>$authors, 
                'count_search_res'=>$count_search_res]);
        }
    }
?>