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
                $_SESSION['message']=array('error', 'Missing field(s)');
                self::goHome();
            }

            $comment_author = User::getUserByUsername($_SESSION['username']);
            $id = Comment::newComment($body, $comment_author['id'], $post);

            if($id>-1)
            {

                echo '<div>
                <h5 class="comment" style="display:inline-block;">' . $comment_author['username'] .':&nbsp</h5>'
                .
                
                '<h5 class="comment" style="display:inline-block;">' . $body. '</h5>
                </div>'
                
                .
                
                '<h6 class="comment_options d-inline-block"> 
                        <a class="d-inline-block" href="/social_site/public/comment/editComment/'. $id . '">Edit</a> |  
                        <p class="d-inline-block" style="cursor:pointer;" onclick="deleteComment('. $id.')">
                        Delete </p>
                        | 
                </h6>'
            
                .
                
                '<h6 class="comment_options d-inline-block" id="upvote_'.$id.'" onclick="upvote('.$id.')" style="cursor:pointer"> upvote</h6> |'
                
                .

                '<h6 class="comment_options d-inline-block" id="downvote_'.$id.'" onclick="downvote('.$id.')" style="cursor:pointer"> downvote </h6>'
                
                .

                '<br>';

                return true;
            }
            
            self::goProfile();
        }

        public function editComment($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goProfile();

            $comment = Comment::findCommentById($id);
            $original_comment_body='';
            if(is_array($comment))
            {
                $original_comment_body = $comment['body'];

                new View('comment' . DIRECTORY_SEPARATOR . 'editComment', ['comment_id' => $id, 
                'original_comment_body'=>$original_comment_body]);

                return;
            }
            
            echo "CouldNOT get comment";
        }

        public function updateComment($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            
            if(!isset($_POST['new_comment_body']) || $id<0)
            {
                self::goProfile();
            }

            $new_comment_body = htmlspecialchars($_POST['new_comment_body']);
            
            if(!Comment::updateComment($id, $new_comment_body))
            {
                $_SESSION['message']=array('error', 'Could not update comment');
                $_SESSION['count_times_message_shown']=0;

                self::goProfile();

                return;
            }

            $_SESSION['message']=array('success', 'Comment updated');
            $_SESSION['count_times_message_shown']=0;

            self::goProfile();
        }

        public function deleteComment($comment_id)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            

            Comment::deleteComment($comment_id);

            // $arr_comments = Comment::showCommentsForPost($post_id);

            // $comments = '';
            // if(!is_array($arr_comments)) return $comments;

            // for($i=0;$i<count($arr_comments);$i++)
            // {
            //     $comments .= $arr_comments[$i]['body'];
            //     $comments .='<br>';
            // }
            
            // echo $comments;
        }

        public function upvote($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goProfile();

            if(Comment::upvote($id))
            {
                echo 'upvoted';return;
            }
            
            echo 'upvote';
        }

        public function downvote($id=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id<0) self::goProfile();

            if(Comment::downvote($id))
            {
                echo 'downvoted';return;
            }

            echo 'downvote';
        }
    }

?>
