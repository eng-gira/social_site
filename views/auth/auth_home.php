<?php

    echo "Welcome you, authenticated person!<br>";
    if(isset($_GET['unm']))
    {
        $username=md5($_GET['unm']);
        echo "Your username is: " . $username . "<br>";
    }
?>