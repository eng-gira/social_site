<?php

    class authController
    {
        public function reg()
        {
            new view(VIEW . 'auth' . DIRECTORY_SEPARATOR . 'reg.php');
        }

        public function logIn()
        {
            //POST REQUEST
        }

        public function newUser()
        {
            //INSERT USER INTO DB using User model
        }
    }

?>