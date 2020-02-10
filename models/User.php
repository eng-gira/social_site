<?php
    
    class User extends DB
    {
        public static function newUser($name, $email, $pw)
        {
            $myCon = self::connect();
            
            $sql = "INSERT INTO users (username, email, pw) VALUES (?, ?, ?)";

            if($stmt=$myCon->prepare($sql))
            {
                $stmt->bind_param("sss", $username, $email, $password);
                $ret = $stmt->execute();
            }

            return $ret;
        }

        public static function findUser()
        {
        }
        
        public static function findUserByEmail($email)
        {

        }
    }
?>