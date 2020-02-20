<?php
    echo "Welcome you, authenticated person! This is Your Dashboard<br>";
    if(strlen($this->getData()['unm'])>0)
    {
        $username=$this->getData()['unm'];
        echo "Your username is: " . $username . "<br>";
    }

    echo $_SESSION['username'] . "<- from sessions. <br>";

?>