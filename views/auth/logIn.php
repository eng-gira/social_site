<?php

    $err_logIn = '';
    if($this->getData()['note']==md5("err_logIn"))
    {
        $err_logIn = md5("err_logIn");
        echo "<h4>Incorrect Password. <br></h4>";
    }

    $link = strlen($err_logIn) > 0 ? "../authenticate" : "authenticate";
?>

<form action = <?php echo $link; ?> method = "POST">
    Username: <input type="text" name="username" required/>
    Password: <input type="password" name="pw" required/>
    <button type="submit"> Login </button>
</form>

<p> Don't have an account? <a href="/ekom/public/auth/reg"> Register </a></p>