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

        public function editComment($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goDashboard();

            new View('auth' . DIRECTORY_SEPARATOR . 'editComment', ['comment_id' => $id]);
        }

        public function updateComment($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            
            if(!isset($_POST['new_comment_body']) || $id<0)
            {
                self::goDashboard();
            }

            $new_comment_body = htmlspecialchars($_POST['new_comment_body']);
            
            if(!Comment::updateComment($id, $new_comment_body))
            {
                echo 'Error<br>';
            }

            self::goDashboard();
        }

        public function deleteComment($post_id = -1, $comment_id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($post_id< 0 || $comment_id <0) self::goDashboard();

            Comment::deleteComment($comment_id);

            $arr_comments = Comment::showCommentsForPost($post_id);

            $comments = '';

            for($i=0;$i<count($arr_comments);$i++)
            {
                $comments .= $arr_comments[$i]['body'];
                $comments .='<br>';
            }
            
            echo $comments;
        }
    }

?>