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
            if(User::findUserByEmail($email))
            {
                echo "Email exists<br>";
                return false;
            }
            if(User::findUserByUsername($username))
            {
                echo "Username exists<br>";
                return false;
            }

            
            if(User::newUser($username, $email, $password))
            {
                header("Location: auth_home");
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