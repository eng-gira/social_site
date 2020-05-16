<?php
    $note='';
    if(strlen($this->getData()['note']) > 0)
    {
        echo "IN<br>";
        $note=$this->getData()['note'];
        $err_msg='';
        $return_nothing=false;

        if($note==md5('err_em_unm'))
        {
            $err_msg.="Username AND Email already exist!";
        }
        else if($note==md5("err_em"))
        {
            $err_msg.="Email already exists!";   
        }
        else if($note==md5("err_unm"))
        {
            echo "Sure<br>";
            $err_msg.="Username already exists!";
        }
        else
        {
            $return_nothing=true;
        }
        
        if(!$return_nothing)
        {
            //style: color = red;
            echo "<h4>". $err_msg ."</h4><br>";   
        }
    }

    $link= strlen($note)>0 ? '../insertUser' : 'insertUser';
?>

<form action = <?php echo $link; ?> method="POST">
    Username: <input type="text" name="username" required/>
    Email: <input type="text" name="email" required/>
    Password: <input type="password" name="pw" required/>
    <button type="submit"> Register </button>
</form>

<p> Already have an account? <a href="/social_site/public/auth/logIn"> Log In </a></p>