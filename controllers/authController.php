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

        public function newUser()
        {
            //INSERT USER INTO DB using User model
        }

        public function authenticate()
        {

        }
    }

?>