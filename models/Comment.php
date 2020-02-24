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
                return inval($result['id']);
            }
        }
        
        return -1;
    }
?>
