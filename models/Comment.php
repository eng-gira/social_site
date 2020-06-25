<?php

    class Comment extends DB
    {
        /**
         * @method newComment($body, $author, $post)
         *
         * @param string (body): comment body
         * @param int (author): author's id
         * @param int (post) post's id
         * 
         * @return int: new comment is added? the comment's id. Otherwise, -1;
         */
        public static function newComment($body, $author, $post)
        {
            $myCon = self::connect();
            $sql = "INSERT INTO comments (body, author, post, up_voters, down_voters, date_time) VALUES (?, ?, ?, ?, ?, ?)";

            if($stmt=$myCon->prepare($sql))
            {
                // echo 'prepared = true <br>'; //debug
                $empty_string='';
                $date_time = date('y').date('m').date('d').'_'.date('H').date('i').date('s');
                $stmt->bind_param("siisss", $body, $author, $post, $empty_string, $empty_string, $date_time);

                if(!$stmt->execute())
                {
                    //echo 'couldn't execute <br>'; //debug
                    return -1;
                }
            }
            else
            {
                //echo 'couldn't prepare <br>'; //debug
                return -1;
            }

            //returning this comment's id;
            $ret_id = -1;

            $select_sql = 'SELECT id FROM comments WHERE author = ? AND date_time = "' . 
                $date_time . '"';

            if($stmt2=$myCon->prepare($select_sql))
            {
                $stmt2->bind_param('i', $author);

                if($stmt2->execute())
                {
                    $stmt2->store_result();
                    if($stmt2->num_rows != 0) {
                        $stmt2->bind_result($ret_id); 
                        
                        $stmt2->fetch(); 
                    }
                }
            }
            return $ret_id;
        }

        public static function showCommentsForPost($post_id)
        {
            $myCon = self::connect();

            $sql = "SELECT * FROM comments WHERE post = $post_id ORDER BY id DESC";

            $comments = array();

            $result=$myCon->query($sql);
            if($result->num_rows!=0)
            {
                while($row=$result->fetch_assoc())
                {
                    $comments[count($comments)] = array(
                        'id'=>$row['id'], 'body'=>$row['body'], 'author'=>User::getUserById($row['author'])
                        , 'post'=>$row['post'],
                        'up_voters'=>$row['up_voters'], 'down_voters'=>$row['down_voters']
                    );
                }
            }else {return false;}

            return $comments;
        }

        public static function showCommentsForGroup($posts_group)
        {
            $myCon = self::connect();

            $comments = array();

            $base_sql = "SELECT * FROM comments WHERE post = ";

            $errors = 0;

            for($i=0; $i<count($posts_group); $i++)
            {
                $current_post_id = intval($posts_group[$i]['id']);

                $sql = $base_sql . $current_post_id . " ORDER BY id DESC";

                $result = $myCon->query($sql);
                
                if($result->num_rows != 0)
                {
                    $arr=array();
                    while($row=$result->fetch_assoc())
                    {
                        
                        $arr[count($arr)]=array('id'=>$row['id'], 'body' => $row['body'], 
                        'author' => User::getUserById($row['author']), 'up_voters' => $row['up_voters'], 
                        'down_voters' => $row['down_voters']);
                        
                        /*
                        Expected OP:
                        ----------- 

                        $comments["post_of_id_4"] = array(array('body' => 'the comment', 'author' => 'author_id', 
                        'up_voters' => 'id1;id2;id3;', 'down_voters' => 'id1;id2;id3;'), 
                        array(...), array(...), array(...));
                        
                        */
                    }
                    $comments[$current_post_id]=$arr;
                }
                else{
                    $errors++; //debugging thing
                }
            }

            return $comments;
        }

        public static function updateComment($id, $new_comment_body)
        {
            $myCon = self::connect();

            $sql = "UPDATE comments SET body = ? WHERE id = $id";

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("s", $new_comment_body);

                if($stmt->execute())
                {
                    return true;
                }
            }

            return false;
        }

        public static function deleteComment($id)
        {
            $myCon = self::connect();

            $sql = "DELETE FROM comments WHERE id = $id";

            if($myCon->query($sql)) return true;

            return false;
        }

        /*
        @returns Comment id or -1;
        */
        public static function findCommentById($id)
        {            
            $myCon = self::connect();
            
            $sql = "SELECT id, body FROM comments WHERE id = ?";
            
            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param('i', $id);

                if($stmt->execute())
                {
                    $stmt->store_result();

                    $comment_id = -1;
                    $comment_body = '';
                    
                    if($stmt->num_rows!=0)
                    {
                        $stmt->bind_result($comment_id, $comment_body); 
                        
                        $stmt->fetch();
                    }
                    
                    return ['id'=>$comment_id, 'body'=>$comment_body];
                }
            }

            return -2;
        }
        
        public static function upvote($id)
        {
            $myCon = self::connect();

            $up_voter = $_SESSION['id'];

            //getting old upvoters (WORKS)
            $sql_1 = "SELECT up_voters FROM comments WHERE id = ?";
            $old_up_voters = '';
            if($stmt=$myCon->prepare($sql_1))
            {
                $stmt->bind_param("i", $id);

                if($stmt->execute())
                {
                    $stmt->store_result();
                    if($stmt->num_rows != 0) {
                        $stmt->bind_result($old_up_voters); 
                        
                        $stmt->fetch(); 
                    }
                    else {echo "NO ROWS!<br>"; return false;}
                }
                else{
                    echo "failed to execute 1 <br>";
                    return false;
                }
            }else {echo "FAILED TO PREPARE 1 <br>"; return false;}
            
            $arr_old_up_voters = explode(';', $old_up_voters, -1);

            if(in_array($up_voter, $arr_old_up_voters))
            {
                //remove upvote (WORKS)
                $old_up_voters = str_replace($up_voter.';', '', $old_up_voters);
                $up_voter='';
            }

            else {$up_voter .= ';';}

            $sql_2 = 'UPDATE comments SET up_voters = ? WHERE id = ?';

            if($stmt=$myCon->prepare($sql_2))
            {
                $param1=$old_up_voters . $up_voter;
                $stmt->bind_param("si", $param1, $id);

                if(!$stmt->execute())
                {
                    echo "FAILED TO EXECUTE 2<br>"; return false;
                }

                self::removeOtherVote($id, 'upvote');

            }else {echo "FAILED TO PREPARE 2<br>"; return false;}


            return strlen($up_voter)>1;
        }

        public static function downvote($id)
        {
            $myCon = self::connect();

            $down_voter = $_SESSION['id'];

            //getting old upvoters (WORKS)
            $sql_1 = "SELECT down_voters FROM comments WHERE id = ?";
            $old_down_voters = '';
            if($stmt=$myCon->prepare($sql_1))
            {
                $stmt->bind_param("i", $id);

                if($stmt->execute())
                {
                    $stmt->store_result();
                    if($stmt->num_rows != 0) {
                        $stmt->bind_result($old_down_voters); 
                        
                        $stmt->fetch(); 
                    }
                    else {echo "NO ROWS!<br>"; return false;}
                }
                else{
                    echo "failed to execute 1 <br>";
                    return false;
                }
            }else {echo "FAILED TO PREPARE 1 <br>"; return false;}
            
            $arr_old_down_voters = explode(';', $old_down_voters, -1);

            if(in_array($down_voter, $arr_old_down_voters))
            {
                //remove downvote
                $old_down_voters = str_replace($down_voter.';', '', $old_down_voters);
                $down_voter='';
            }

            else {$down_voter .= ';';}

            $sql_2 = 'UPDATE comments SET down_voters = ? WHERE id = ?';

            if($stmt=$myCon->prepare($sql_2))
            {
                $param1=$old_down_voters . $down_voter;
                $stmt->bind_param("si", $param1, $id);

                if(!$stmt->execute())
                {
                    echo "FAILED TO EXECUTE 2<br>"; return false;
                }

                self::removeOtherVote($id, 'downvote');

            }else {echo "FAILED TO PREPARE 2<br>"; return false;}


            return strlen($down_voter)>1;
        }
    
        private function removeOtherVote($comment_id, $vote_type)
        {
            $myCon = self::connect();

            //if upvoted -> check if was downvoter and remove it

            $sql = "SELECT down_voters FROM comments WHERE id = ?";    
         
            if($vote_type=='downvote')
            {
                $sql = "SELECT up_voters FROM comments WHERE id = ?";    
            }
            else if($vote_type!='upvote') {return false;}

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param('i', $comment_id);
                
                $voters = '';
                $voter = $_SESSION['id'];

                if($stmt->execute())
                {
                    $stmt->store_result();
                    if($stmt->num_rows != 0) {
                        $stmt->bind_result($voters); 
                        
                        $stmt->fetch(); 

                        $arr_voters = explode(';', $voters, -1);

                        if(in_array($voter, $arr_voters))
                        {
                            $voters = str_replace($voter.';', '', $voters);

                            $sql_2 = $vote_type=='upvote'?"UPDATE comments SET down_voters = ? WHERE id = ?" : 
                                "UPDATE comments SET up_voters = ? WHERE id = ?";
                        
                            if($stmt2=$myCon->prepare($sql_2))
                            {
                                $stmt2->bind_param('si', $voters, $comment_id);

                                if($stmt2->execute())
                                {
                                    return true;
                                }
                            }   
                        }
                        else {return false;}
                    }               
                }
            }
            return false;
        }
    }
?>
