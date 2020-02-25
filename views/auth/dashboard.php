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
                $arr_comments = $this->getData()['all_comments_per_post'];

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
                    $all_comments_for_this = 'all_comments_for_' . $current_post_id;
                    ?>
                    <a href=<?php echo "/ekom/public/post/editPost/" . $arr_my_posts[$i]['id']; ?>> Edit </a> | 
                    <button onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
                    <?php
                    echo "<hr>";
                    ?>
                    
                    <input type="text" id="comment_body" name="comment_body"/>
                    <button type="submit" onclick="comment(<?php echo $current_post_id; ?>)">Comment</button>
                    
                    <hr>
                    <div id='<?php echo $all_comments_for_this; ?>'>
                        <?php

                        if(count($arr_comments)>0)
                        {
                            for($i=0;$i<count($arr_comments[$current_post_id]); $i++)
                            {
                                echo '<h5>' . $arr_comments[$current_post_id][$i]['author'] . '</h5>';
                                echo '<h6>' . $arr_comments[$current_post_id][$i]['body'] . '</h6>';
                                //check owner then add edit and delete options
                                
                                if(intval($arr_comments[$current_post_id][$i]['author'])==$_SESSION['id'])
                                {
                                    ?>
                                    <h6> 
                                        <a href=
                                        <?php echo '/ekom/public/comment/editComment/'.
                                        $arr_comments[$current_post_id][$i]['id'];?>
                                        >Edit</a> or 
                                        <p style='cursor:pointer;' onclick=
                                        <?php 
                                            echo 'deleteComment(' . $arr_comments[$current_post_id][$i]['id'] .')';
                                        ?>>Delete</p> 
                                    </h6> 
                                    <br>
                                    <?php
                                }
                                echo '<br>';
                            }
                        }
                        
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

    function comment(post_id)
    {
        let comment_body = document.getElementById('comment_body').value;

        if(comment_body.length<1) {alert("empty comment"); return false;}

        let xhttp = new XMLHttpRequest;
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let holder = document.getElementById("all_comments_for_"+post_id).innerHTML;
                let new_comment = xhttp.responseText;

                document.getElementById("all_comments_for_"+post_id).innerHTML = new_comment + holder;
            }
        };
        xhttp.open("POST","/ekom/public/comment/newComment", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("comment_body="+comment_body+"&post_id="+post_id);
    }

    function deleteComment(id)
    {
        
    }
</script>
