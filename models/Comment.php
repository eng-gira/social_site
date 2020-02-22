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
                $stmt->bind_param("sssss", $body, $author, $post, $empty_string, $empty_string);

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

?>