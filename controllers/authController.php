<?php

    class authController
    {
        public function reg($note='')
        {
            new view('auth' . DIRECTORY_SEPARATOR . 'reg', ['note' => $note]);
        }

        public function logIn()
        {
            new view('auth' . DIRECTORY_SEPARATOR . 'logIn');
        }

        public function insertUser()
        {
            if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['pw'])) return "NO POST REQUEST";
           
            $username= htmlspecialchars($_POST['username']);
            $email= htmlspecialchars($_POST['email']);
            $password= md5($_POST['pw']);
            
            //check if username and/or email already exist
            if(User::findUserByEmail($email) || User::findUserByUsername($username))
            {                
                if(!User::findUserByUsername($username))
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

        }

        public function auth_home($unm='')
        {
            //don't encode parameter here to avoid confusing errors
            new view('auth' . DIRECTORY_SEPARATOR . 'auth_home', ['$unm' => $unm]);
        }
    }

?>