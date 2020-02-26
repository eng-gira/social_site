<?php

    class Comment extends DB
    {
        public static function newComment($body, $author, $post)
        {
            $myCon = self::connect();
            $sql = "INSERT INTO comments (body, author, post, up_voters, down_voters) VALUES (?, ?, ?, ?, ?)";

            if($stmt=$myCon->prepare($sql))
            {
                // echo 'prepared = true <br>'; //debug
                $empty_string='';
                $stmt->bind_param("siiss", $body, $author, $post, $empty_string, $empty_string);

                if(!$stmt->execute())
                {
                    //echo 'couldn't execute <br>'; //debug
                    return false;
                }
            }
            else
            {
                //echo 'couldn't prepare <br>'; //debug
                return false;
            }

            //echo 'neat <br>';
            return true;
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
                        'id'=>$row['id'], 'body'=>$row['body'], 'author'=>$row['author'], 'post'=>$row['post'],
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
                        'author' => $row['author'], 'up_voters' => $row['up_voters'], 
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
            if(!is_int($id)) return -1;
            
            $myCon = self::connect();
            
            $sql = "SELECT id FROM comments WHERE id = $id";
            
            $result = $myCon->query($sql);
            
            if($result->num_rows!=0) 
            {
                while($row=$result->fetch_assoc())
                {
                    return inval($row['id']);
                }
            }
            
            return -1;
        }
    }

?>
