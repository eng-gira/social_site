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

        /*
            @return id or -1;
        */
        public static function findUserByUsername($username)
        {
            $myCon = self::connect();

            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt=$myCon->prepare($sql))
            {
              //  echo "inside... <br>";
                $stmt->bind_param("s", $username);
                if($stmt->execute())
                {
                   // echo "executed...<br>";
                    $stmt->store_result();
                    if($stmt->num_rows != 0) {
                        $stmt->bind_result($id); 
                        while ($stmt->fetch()) {
                           // echo "username exists with id: ". $id . "<br>";
                            $stmt->close();
                            return $id;
                        }
                    }
                }
                else {echo "Couldn't execute method: findUserByUsername<br>"; $stmt->close(); return -1;}
            }
           echo "username doesn't exist<br>";
            $stmt->close();
            return -1;
        }

        public static function auth($username, $pw)
        {
            $id = self::findUserByUsername($username);
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
    }
?>