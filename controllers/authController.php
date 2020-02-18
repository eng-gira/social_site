<?php

    class authController
    {
        public function reg()
        {
            new view('auth' . DIRECTORY_SEPARATOR . 'reg');
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
            $password= $_POST['pw'];
            
            //check if username and/or email already exist
            if(User::findUserByEmail($email) || User::findUserByUsername($usenrname))
            {                
                if(!User::findUserByUsername($username))
                {
                    $err_em=md5("err_em"); //basic encryption
                    header("Location: auth_home?note=".$err_em);

                    return false; //safety
                }
                else if(!User::findUserByEmail($email))
                {
                    $err_unm=md5("err_unm"); //basic encryption
                    header("Location: auth_home?note=".$err_unm);

                    return false; //safety
                }

                $err_em_unm = md5("err_em_unm"); //basic encryption

                header("Location: auth_home?note=".$err_em_unm);

                return false;
            }
            
            if(User::newUser($username, $email, $password))
            {
                $encd_username=md5($username); //basic encryption

                header("Location: auth_home?unm=".$encd_username);
            }

            return "Failed";
        }

        public function authenticate()
        {

        }

        public function auth_home()
        {
            new view('auth' . DIRECTORY_SEPARATOR . 'auth_home');
        }
    }

?>