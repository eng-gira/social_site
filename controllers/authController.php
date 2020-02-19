<?php

    class authController
    {
        public function reg($note='')
        {
            new view('auth' . DIRECTORY_SEPARATOR . 'reg', ['note' => $note]);
        }

        public function logIn($note='')
        {
            new view('auth' . DIRECTORY_SEPARATOR . 'logIn', ['note' => $note]);
        }

        public function insertUser()
        {
            if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['pw'])) return "NO POST REQUEST";
           
            $username= htmlspecialchars($_POST['username']);
            $email= htmlspecialchars($_POST['email']);
            $password= md5($_POST['pw']);
            
            //check if username and/or email already exist
            if(User::findUserByEmail($email) || User::findUserByUsername($username) > -1)
            {                
                if(User::findUserByUsername($username) == -1)
                {
                    $err_em=md5("err_em"); //basic encryption
                    header("Location: reg/".$err_em);

                    return false; //safety
                }
                else if(!User::findUserByEmail($email))
                {
                    $err_unm=md5("err_unm"); //basic encryption
                    header("Location: reg/".$err_unm);

                    return false; //safety
                }

                $err_em_unm = md5("err_em_unm"); //basic encryption

                header("Location: reg/".$err_em_unm);

                return false;
            }
            
            if(User::newUser($username, $email, $password))
            {
                header("Location: auth_home/".$username);
            }

            return "Failed";
        }

        public function authenticate()
        {
            $username= htmlspecialchars($_POST['username']);
            $password= md5($_POST['pw']); //as it's stored in encrypted form in the DB

            if(User::auth($username, $password))
            {
                echo "AUTHENTICATED!! <br>";
                header("Location: auth_home/" . $username);
                return; //safety
            }

            $err_logIn = md5("err_logIn");

            header("Location: logIn/".$err_logIn);

            return false;
        }

        public function auth_home($unm='')
        {
            //don't encode parameter here to avoid confusing errors
            new view('auth' . DIRECTORY_SEPARATOR . 'auth_home', ['unm' => $unm]);
        }
    }

?>