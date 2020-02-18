<?php
    if(strlen($this->getData()['note']) > 0)
    {
        $note=md5($this->getData()['note']);
        $err_msg='';
        $return_nothing=false;

        switch($note)
        {
            case 'err_em_unm':
                $err_msg="Username AND Email already exist!";
            break;
            
            case 'err_em':
                $err_msg="Email already exists!";
            break;

            case 'err_unm':
                $err_msg="Username already exists!";
            break;

            default:
                $return_nothing=true;
        }

        if(!$return_nothing)
        {
            //style: color = red;
            echo "<h4>". $err_msg ."</h4><br>";   
        }
    }
?>

<form action = "insertUser" method="POST">
    Username: <input type="text" name="username" required/>
    Email: <input type="text" name="email" required/>
    Password: <input type="password" name="pw" required/>
    <button type="submit"> Register </button>
</form>