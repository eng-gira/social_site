<?php


?>

<form action = <?php echo _PUBLIC . "/auth/newUser"; ?> method="POST">
    Name: <input type="text" name="name" required/>
    Email: <input type="text" name="email" required/>
    Password: <input type="password" name="pw" required/>
    <button type="submit"> Register </button>
</form>