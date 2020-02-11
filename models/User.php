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
        
        public static function findUserByEmail($email)
        {
            $myCon=self::connect();

            $sql = "SELECT id FROM users WHERE email = ?";
            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("s", $email);
                if($stmt->execute())
                {
                    if($stmt->num_rows!=0) return true;
                }
                else{
                    echo "Couldn't Execute!<br>";
                    return false;
                }
            }

            return false;
        }

        public static function findUserByUsername($username)
        {
            $myCon = self::connect();

            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("s", $username);
                if($stmt->execute())
                {
                    if($stmt->num_rows != 0) return true;
                }
                else {echo "Couldn't execute<br>"; return false;}
            }
            return false;
        }

    }
?>