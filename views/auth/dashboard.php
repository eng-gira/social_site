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
            <h4> New Post </h4><br><br>
            <form action="/ekom/public/post/newPost" method="POST">
                Post Title: <input type="text" name="post_title" required/> <br><br>
                Post Body: <input name="post_body" style="height:200px;width:200px" required/> <br><br>
                <button type="submit"> Submit Post </button>
            </form><br><hr><br>

            <h4> Your Posts </h4><br>
            <?php
                $arr_my_posts = $this->getData()['all_posts'];
                for($i=0; $i<count($arr_my_posts); $i++)
                {
                    echo "<h5>". $arr_my_posts[$i]['title'] . "</h5>";
                    echo "<h6>". $arr_my_posts[$i]['body'] . "</h6>";
                    echo "<hr>";
                }
            ?>
        </main>
    </body>
</html>