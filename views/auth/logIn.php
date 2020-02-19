<?php

    $err_logIn = md5("err_logIn");
    if($this->getData()['note']==$err_logIn)
    {
        echo "<h4>Incorrect Password. <br></h4>";
    }

?>

<form action = "authenticate" method = "POST">
    Username: <input type="text" name="username" required/>
    Password: <input type="password" name="pw" required/>
    <button type="submit"> Login </button>
</form>