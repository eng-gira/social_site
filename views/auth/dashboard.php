<?php

  //  echo $_SESSION['username'] . "<- from sessions. <br>";*/
    

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


            <?php
                $arr_my_posts = $this->getData()['all_posts'];
                if(count($arr_my_posts)>0)
                {
                ?>
                    <h4> Your Posts </h4><br>
                <?php
                }
                for($i=0; $i<count($arr_my_posts); $i++)
                {
                    ?>
                    <div class='post'>
                    <?php
                    echo "<h5>". $arr_my_posts[$i]['title'] . "</h5>";
                    echo "<h6>". $arr_my_posts[$i]['body'] . "</h6>";
                    echo "<hr>";
                    $delete_link = "/ekom/public/post/deletePost/" . $arr_my_posts[$i]['id'];
                    $current_post_id = $arr_my_posts[$i]['id'];
                    ?>
                    <a href=<?php echo "/ekom/public/post/editPost/" . $arr_my_posts[$i]['id']; ?>> Edit </a> | 
                    <button onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
                    <?php
                    echo "<hr>";
                    ?>
                    <form action=<?php echo '/ekom/public/comment/newComment/' . $current_post_id;?> method="POST">
                        <input type="text" name="comment_body"/>
                        <button type="submit">Comment</button>
                    </form>
                    <hr>
                    <div id='all_comments'>
                        <?php
                            //loop $this->getData()['all_comments'];
                        ?>
                    </div>
                    <hr>
                    </div>
                    <?php
                }
            ?>
        </main>
    </body>
</html>
<script>
    function confirmPostDeletion(link)
    {
        let r = confirm("Confirm Post DELETION");
        if (r == true) {
            let xhttp = new XMLHttpRequest;

            xhttp.open("POST", link, true);
            xhttp.send();
            location.reload();
        }
    }

    // function comment(post_id)
    // {
        //xhttp.open("POST","/ekom/public/comment/newComment", true);
        //Send the proper header information along with the request
        //xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //xhttp.send();
    //}
</script>
