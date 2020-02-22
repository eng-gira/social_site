<?php

    class authController extends Controller
    {
        public function reg($note='')
        {
            if(isset($_SESSION['username']))
            {
                self::goDashboard();
            }
            new view('auth' . DIRECTORY_SEPARATOR . 'reg', ['note' => $note]);
        }

        public function logIn($note='')
        {
            if(isset($_SESSION['username']))
            {   
                self::goDashboard();
            }
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
                $_SESSION['username']= $username;
                header("Location: dashboard");
            }

            return "Failed";
        }

        public function authenticate()
        {
            $username= htmlspecialchars($_POST['username']);
            $password= md5($_POST['pw']); //as it's stored in encrypted form in the DB

            if(User::auth($username, $password))
            {
                $_SESSION['username']=$username;
                echo "AUTHENTICATED!! <br>";
                header("Location: dashboard" );
                return; //safety
            }

            $err_logIn = md5("err_logIn");

            header("Location: logIn/".$err_logIn);

            return false;
        }

        public function dashboard()
        {
            //don't encode parameter here to avoid confusing errors
            if(!isset($_SESSION['username'])) {header("Location: logIn"); return false;}
            
            //show all posts by the authenticated
            $all_posts = Post::showPostsFor(User::findUserByUsername($_SESSION['username']));
            
            new view('auth' . DIRECTORY_SEPARATOR . 'dashboard', ['all_posts' => $all_posts]);
        }

        public function logOut()
        {
            if(isset($_SESSION['username']))
            {
                unset($_SESSION['username']);

                session_destroy();

                header("Location: ../home");
            }
        }
    }

?>