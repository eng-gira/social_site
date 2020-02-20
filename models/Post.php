<?php
    
    class Post extends DB
    {
        public static function insertPost($post_title, $post_body, $post_author)
        {
            $myCon = self::connect();

            $sql = "INSERT INTO posts (title, body, author) VALUES (?, ?, ?)";

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("ssi", $post_title, $post_body, $post_author);
                if(!$stmt->execute()) return false;

                return true;
            }
            return false;
        }
    }

?>