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

        public static function updatePost($id, $new_title, $new_body)
        {
            $myCon = self::connect();
            $sql = "UPDATE posts SET title = ?, body = ? WHERE id = $id";
            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("ss", $new_title, $new_body);
                if(!$stmt->execute()) return false;

                return true;
            }

            return false;
        }

        
        public static function deletePost($id)
        {
            $myCon = self::connect();
            $sql = "DELETE FROM posts WHERE id = $id";

            if($myCon->query($sql)) return true;

            return false;
        }

        public static function getPostById($id)
        {
            $myCon = self::connect();
            $sql = "SELECT * FROM posts WHERE id = $id";
            $post = array();
            $result = $myCon->query($sql);

            if($reuslt->num_rows==1)
            {
                while($row=$result->fetch_assoc())
                {
                    $post['id']=$row['id'];
                    $post['title']=$row['title'];
                    $post['body']=$row['body'];
                    $post['author']=$row['author'];
                }
            }else {return false;}

            return $post;
        }
        
        public static function showPostsFor($id)
        {
            $ret = array();
            $ret_counter = 0;
            $myCon = self::connect();
            $sql = "SELECT id, title, body FROM posts WHERE author = $id ORDER BY id DESC";

            $result = $myCon->query($sql);
            if($result->num_rows!=0)
            {
                while($row = $result->fetch_assoc()) {
                    $ret[$ret_counter] = array('id'=>$row['id'], 'title'=>$row['title'], 'body' => $row['body']);
                    $ret_counter++;
                }   
            }

            return $ret;
        }
    }

?>