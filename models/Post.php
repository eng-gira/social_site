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

        public static function getPostOfId($id)
        {
            $myCon = self::connect();
            $sql = "SELECT * FROM posts WHERE id = $id";
            $post = array();
            $result = $myCon->query($sql);

            if($result->num_rows==1)
            {
                while($row=$result->fetch_assoc())
                {
                    $post['id']=$row['id'];
                    $post['title']=$row['title'];
                    $post['body']=$row['body'];
                    $post['author']=$row['author'];
                    $post['up_voters']=$row['up_voters'];
                    $post['down_voters']=$row['down_voters'];
                }
            }else {return false;}

            return $post;
        }
        
        public static function showPostsFor($id)
        {
            $ret = array();
            $ret_counter = 0;
            $myCon = self::connect();
            $sql = "SELECT id, title, body, up_voters, down_voters FROM posts WHERE author = $id ORDER BY id DESC";

            $result = $myCon->query($sql);
            if($result->num_rows!=0)
            {
                while($row = $result->fetch_assoc()) {
                    $ret[$ret_counter] = array('id'=>$row['id'], 'title'=>$row['title'], 'body' => $row['body'], 
                'up_voters' => $row['up_voters'], 'down_voters' => $row['down_voters']);
                    $ret_counter++;
                }   
            }

            return $ret;
        }

        public static function upvote($post_id)
        {
            $myCon = self::connect();
            
            $old_up_voters = '';
            $old_down_voters = '';

            $sql_1 = "SELECT up_voters, down_voters FROM posts WHERE id = ?";

            if($stmt_1=$myCon->prepare($sql_1))
            {
                $stmt_1->bind_param('i', $post_id);

                if($stmt_1->execute())
                {
                    $stmt_1->store_result();
                    if($stmt_1->num_rows != 0) {
                        $stmt_1->bind_result($old_up_voters, $old_down_voters);
                        $stmt_1->fetch();
                    }
                    else {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else {return false;}

            $up_voter = $_SESSION['id'];
            $arr_old_up_voters = explode(';', $old_up_voters, -1);
            $arr_old_down_voters = explode(';', $old_down_voters, -1);

            if(in_array($up_voter, $arr_old_down_voters))
            {
                //remove the down vote
                $old_down_voters = str_replace($up_voter.';', '', $old_down_voters);
            }

            if(in_array($up_voter, $arr_old_up_voters))
            {
                //remove the up vote
                $old_up_voters = str_replace($up_voter.';', '', $old_up_voters);
                $up_voter = '';
            }

            $sql_2 = 'UPDATE posts SET up_voters = ?, down_voters = ? WHERE id = ?';

            if($stmt_2=$myCon->prepare($sql_2))
            {
                if(strlen($up_voter)>0) $up_voter.=';';
                $old_up_voters .= $up_voter;
                $stmt_2->bind_param('ssi', $old_up_voters, $old_down_voters, $post_id);

                if($stmt_2->execute())
                {
                    return strlen($up_voter) > 0 ? 'upvoted' : false;
                }
            }
            return false;
        }

        public static function downvote($post_id)
        {
            $myCon = self::connect();
            
            $old_up_voters = '';
            $old_down_voters = '';

            $sql_1 = "SELECT up_voters, down_voters FROM posts WHERE id = ?";

            if($stmt_1=$myCon->prepare($sql_1))
            {
                $stmt_1->bind_param('i', $post_id);

                if($stmt_1->execute())
                {
                    $stmt_1->store_result();
                    if($stmt_1->num_rows != 0) {
                        $stmt_1->bind_result($old_up_voters, $old_down_voters);
                        $stmt_1->fetch();
                    }
                    else {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else {return false;}

            $down_voter = $_SESSION['id'];
            $arr_old_up_voters = explode(';', $old_up_voters, -1);
            $arr_old_down_voters = explode(';', $old_down_voters, -1);

            if(in_array($down_voter, $arr_old_down_voters))
            {
                //remove the down vote
                $old_down_voters = str_replace($down_voter.';', '', $old_down_voters);
                $down_voter='';
            }

            if(in_array($down_voter, $arr_old_up_voters))
            {
                //remove the up vote
                $old_up_voters = str_replace($down_voter.';', '', $old_up_voters);
            }

            $sql_2 = 'UPDATE posts SET up_voters = ?, down_voters = ? WHERE id = ?';

            if($stmt_2=$myCon->prepare($sql_2))
            {
                if(strlen($down_voter)>0) $down_voter.=';';
                $old_down_voters .= $down_voter;
                $stmt_2->bind_param('ssi', $old_up_voters, $old_down_voters, $post_id);

                if($stmt_2->execute())
                {
                    return strlen($down_voter) > 0 ? 'upvoted' : false;
                }
            }
            return false;
        }

        public static function getAllPosts()
        {
            $myCon = self::connect();

            $sql_get_all_posts = 'SELECT users.username, posts.id, posts.title, posts.body, posts.up_voters, 
            posts.down_voters FROM posts INNER JOIN users ON users.id=posts.author ORDER BY 
            posts.id DESC';

            $result = $myCon->query($sql_get_all_posts);

            if($result->num_rows>0)
            {
                $posts=array();
                while($row=$result->fetch_assoc())
                {
                    $posts[count($posts)]= [
                        'post_id'=>$row['id'],
                        'post_title'=>$row['title'], 'post_body'=>$row['body'], 
                        'post_up_voters'=>$row['up_voters'], 'post_down_voters'=>$row['down_voters'], 
                        'post_author'=>$row['username']
                    ];
                }

                return $posts;
            }

            else
            {
                return 'Couldnt get results.';
            }
        }
    }

?>