<?php
    
    echo "Welcome you, authenticated person!<br>";
    if(strlen($this->getData()['unm'])>0)
    {
        $username=$this->getData()['unm'];
        echo "Your username is: " . $username . "<br>";
    }
?>