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

        public static function showPostsFor($id)
        {
            $ret = array();
            $ret_counter = 0;
            $myCon = self::connect();
            $sql = "SELECT title, body FROM posts WHERE author = $id ORDER BY id DESC";

            $result = $myCon->query($sql);
            if($result->num_rows!=0)
            {
                while($row = $result->fetch_assoc()) {
                    $ret[$ret_counter] = array("title"=>$row['title'], 'body' => $row['body']);
                    $ret_counter++;
                }   
            }

            return $ret;
        }
    }

?>