<?php

    echo "Welcome you, authenticated person!<br>";
    if(strlen($this->getData()['unm'])>0)
    {
        $username=md5($this->getData()['unm']);
        echo "Your username is: " . $username . "<br>";
    }
?>