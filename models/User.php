<?php
    
    class User extends DB
    {
        public static function newUser($username, $email, $pw)
        {
            $myCon = self::connect();
            
            $sql = "INSERT INTO users (username, email, pw) VALUES (?, ?, ?)";
            
            $ret= false;

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("sss", $username, $email, $pw);
                $ret = $stmt->execute();
            }
            
            return $ret;
        }
        
        public static function getUserByEmail($email)
        {
            $myCon=self::connect();

            $sql = "SELECT id FROM users WHERE email = ?";
            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("s", $email);
                if($stmt->execute())
                {
                    $stmt->store_result();

                    if($stmt->num_rows!=0) return true;
                }
                else{
                    echo "Couldn't Execute!<br>";
                    return false;
                }
            }

            return false;
        }
        
        public static function getUserById($id)
        {
            $myCon = self::connect();

            $sql = "SELECT id, username, email, followers FROM users WHERE id = ?";

            if($stmt=$myCon->prepare($sql))
            {
              //  echo "inside... <br>";
                $stmt->bind_param("i", $id);
                if($stmt->execute())
                {
                    $stmt->store_result();
                 
                    if($stmt->num_rows != 0) {
                        // $id=-1;
                        // $username='';
                        // $email='';
                        // $followers='';
                        $stmt->bind_result($id, $username, $email, $followers); 

                        $stmt->fetch();

                        return ['id'=>$id, 'username'=>$username, 'email'=>$email, 'followers'=>$followers];
                    }
                }
                else 
                {
                    echo "id doesn't exist<br>";
                }
            }    
            else 
            {
                echo "Couldn't execute method: getUserById<br>"; 
            }

            return -1;
        }
        
        public static function getUserByUsername($username)
        {
            $myCon = self::connect();

            $sql = "SELECT id, username, email, followers FROM users WHERE username = ?";

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("s", $username);
                if($stmt->execute())
                {
                    $stmt->store_result();
                 
                    if($stmt->num_rows != 0) {
                        
                        $stmt->bind_result($id, $username, $email, $followers); 

                        $stmt->fetch();

                        return ['id'=>$id, 'username'=>$username, 'email'=>$email, 'followers'=>$followers];
                    }
                }
                else 
                {
                    echo "username doesn't exist<br>";
                }
            }    
            else 
            {
                echo "Couldn't execute method: getUserByUsername<br>"; 
            }

            return -1;
        }

        public static function auth($username, $pw)
        {
            $id = self::getUserByUsername($username)['id'];
            if($id > -1)
            {
                $myCon = self::connect();
                $sql = "SELECT pw FROM users WHERE id = " . intval($id); //no need for prepared statements here
                $result = $myCon->query($sql);
                if($result->num_rows!=0)
                {   
                    while($row = $result->fetch_assoc()) {
                        if($row['pw']==$pw)
                        {
                            echo "Authenticated <br>";
                            return true;
                        }
                    }
                }
                else {
                    echo "NO SUCH USER! <br>";
                    return false;
                }
            }
            return false;
        }

        public static function showAllUsers()
        {
            $myCon = self::connect();

            $this_id= $_SESSION['id'];

            $sql = 'SELECT id, username FROM users WHERE id <>'. $this_id;

            $arr_users=array();

            $result = $myCon->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $arr_users[count($arr_users)] = array('id'=>$row['id'], 'username'=>$row['username']);
                }


                return $arr_users;
            }

            return false;
        }

        public static function follow($id_to_follow)
        {
            $myCon = self::connect();

            $sql = "SELECT followers FROM users WHERE id = ?";

            $operation = 'follow';
            $follower = $_SESSION['id'];

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("i", $id_to_follow);
                if($stmt->execute())
                {
                    $stmt->store_result();
                    if($stmt->num_rows != 0) {
                        $old_followers = '';

                        $stmt->bind_result($old_followers); 
                        $stmt->fetch();

                        $arr_followers = explode(';', $old_followers, -1);

                        if(in_array($follower, $arr_followers))
                        {
                            $operation = 'unfollow';
                        }

                        //// UPDATE FOLLOWERS ////

                        $new_followers = $operation=='unfollow'? str_replace($follower . ';', '', $old_followers) : 
                            $old_followers . $follower . ';';
                        
                        $sql2 = "UPDATE users SET followers = ? WHERE id = ?";
                        if($stmt2=$myCon->prepare($sql2))
                        {
                            $stmt2->bind_param('si', $new_followers, $id_to_follow);

                            if($stmt2->execute())
                            {
                                return $operation=='follow'?'unfollow':'follow';
                            }
                        }
                        
                    }
                }
            }
        
            return false;
        }

        public static function f_unf($id)
        {
            $myCon = self::connect();

            $sql = "SELECT followers FROM users WHERE id = ?";

            $operation = 'follow';
            $visitor = $_SESSION['id'];

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("i", $id);
                if($stmt->execute())
                {
                    $stmt->store_result();
                    if($stmt->num_rows != 0) {
                        $followers = '';

                        $stmt->bind_result($followers); 
                        $stmt->fetch();

                        $arr_followers = explode(';', $followers, -1);

                        if(in_array($visitor, $arr_followers))
                        {
                            return 'unfollow';
                        }

                        else {return 'follow';}
                    }
                }
            }


            return 'error';
        }

    }
?>