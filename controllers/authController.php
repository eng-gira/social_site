<?php

    class authController extends Controller
    {
        public function reg($note='')
        {
            if(isset($_SESSION['username']))
            {
                self::goProfile();
            }
            new view('auth' . DIRECTORY_SEPARATOR . 'reg', ['note' => $note]);
        }

        public function logIn($note='')
        {
            if(isset($_SESSION['username']))
            {   
                self::goProfile();
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
            if(User::getUserByEmail($email) || User::getUserByUsername($username)['id'] > -1)
            {                
                if(User::getUserByUsername($username)['id'] == -1)
                {
                    $err_em=md5("err_em"); //basic encryption
                    header("Location: reg/".$err_em);

                    return false; //safety
                }
                else if(!User::getUserByEmail($email))
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
                $_SESSION['id']=User::getUserByUsername($username)['id'];
                $_SESSION['message']=array();
                $_SESSION['count_times_message_shown']=0;
                
                self::goProfile();

                return true;
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
                $_SESSION['id']=User::getUserByUsername($username)['id'];
                $_SESSION['message']=array();
                $_SESSION['count_times_message_shown']=0;

                echo "AUTHENTICATED!! <br>";

                self::goProfile();
                
                return; //safety
            }

            $err_logIn = md5("err_logIn");

            header("Location: logIn/".$err_logIn);

            return false;
        }

        public function profile($id=-1)
        {
            //don't encode parameter here to avoid confusing errors
            if(!isset($_SESSION['username'])) {header("Location: logIn"); return false;}
            if($id==-1) $id=$_SESSION['id'];
            
            //show all posts by the authenticated
            $posts_of_profile_owner = Post::showPostsFor($id);

            $visited_data = User::getUserById($id);
            
            $all_comments_per_post = Comment::showCommentsForGroup($posts_of_profile_owner);

            $all_users = User::showAllUsers();
            $all_users = $all_users == false ? [] : $all_users;

            $f_unf = User::f_unf($id);

            new view('auth' . DIRECTORY_SEPARATOR . 'profile', ['visited_data'=>$visited_data, 
            'f_unf'=>$f_unf,  
            'posts_of_profile_owner' => $posts_of_profile_owner, 
            'all_comments_per_post' => $all_comments_per_post, 'all_users' => $all_users]);
        }

        public function logOut()
        {
            if(isset($_SESSION['username']))
            {
                unset($_SESSION['username']);
                unset($_SESSION['id']);
                unset($_SESSION['messages']);
                unset($_SESSION['count_times_message_shown']);

                session_destroy();

                self::goHome();
            }
        }

        public function follow($id_to_follow=-1)
        {
            if(!isset($_SESSION['username'])) self::goHome();
            if($id_to_follow==-1) self::goProfile();

            $ret = User::follow($id_to_follow);
            if($ret=='follow' || $ret=='unfollow') {echo $ret; return;}

            echo 'error';
        }
    }

?>
