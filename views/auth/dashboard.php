<?php
    /*echo "Welcome you, authenticated person! This is Your Dashboard<br>";
    if(strlen($this->getData()['unm'])>0)
    {
        $username=$this->getData()['unm'];
        echo "Your username is: " . $username . "<br>";
    }

    echo $_SESSION['username'] . "<- from sessions. <br>";*/

?>
<html>
    <head></head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/ekom/public/home"> Home </a>
            <a class="navbar-brand" href="/ekom/public/home/about"> About </a>
            
            <div class="container justify-content-md-end">            
                <a class="navbar-brand" href="/ekom/public/auth/dashboard"> <?php echo $_SESSION['username']; ?> </a>
                <a class="navbar-brand" href="/ekom/public/auth/logOut"> Log Out </a>
            </div>
        </nav> <br><br><br>
        <main>
            <h5> New Post </h5><br><br>
            <form action="/ekom/public/post/newPost" method="POST">
                Post Title: <input type="text" name="post_title" required/> <br><br>
                Post Body: <input name="post_body" style="height:200px;width:200px" required/> <br><br>
                <button type="submit"> Submit Post </button>
            </form><br><hr><br><br>
        </main>
    </body>
</html>