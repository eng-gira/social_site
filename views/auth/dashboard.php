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
            


            <?php
            
                $id_visited= $this->getData()['id_visited'][0];
                $f_unf = $this->getData()['id_visited'][1];
                if($id_visited!=$_SESSION['id'])
                {
                    ?>
                    <p id="follow_btn" style='cursor:pointer;width:45px' onclick=<?php echo 'follow('.$id_visited.')'; ?>> 
                        <?php echo $f_unf;?> 
                    </p>
                    <?php
                }
                else {
                    ?>
                    <h4> New Post </h4><br><br>
                    <form action="/ekom/public/post/newPost" method="POST">
                        Post Title: <input type="text" name="post_title" required/> <br><br>
                        Post Body: <input name="post_body" style="height:200px;width:200px" required/> <br><br>
                        <button type="submit"> Submit Post </button>
                    </form><br><hr><br>
                    <?php
                }
                $arr_my_posts = $this->getData()['all_posts'];
                $arr_comments = $this->getData()['all_comments_per_post'];
                $arr_all_users = $this->getData()['all_users'];

                if(count($arr_all_users)>0)
                {
                    echo "<b>Other users: </b>";
                    for($i=0; $i < count($arr_all_users); $i++)
                    {
                        $current_username = $arr_all_users[$i]['username'];
                        $current_id = $arr_all_users[$i]['id'];
                       ?>
                             <a style='display:inline-block' href=<?php 
                            echo '/ekom/public/auth/dashboard/'.$current_id; 
                        ?>
                             >  
                             <?php 
                                echo $current_username; 
                              ?>
                             </a>                        
                         <?php
                    }
                }

                if(count($arr_my_posts)>0)
                {
                ?>
                    <h4> Posts </h4><br>
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

                    $upvote_post_js_func= 'upvote_post(' . $current_post_id.')';
                    $downvote_post_js_func = 'downvote_post(' . $current_post_id .')';

                    $up_voters=explode(';', $arr_my_posts[$i]['up_voters'], -1);
                    $down_voters=explode(';', $arr_my_posts[$i]['down_voters'], -1);


                    $upvoted= in_array($_SESSION['id'], $up_voters);
                    $downvoted = in_array($_SESSION['id'], $down_voters);
                    ?>
                    <a href=<?php echo "/ekom/public/post/editPost/" . $arr_my_posts[$i]['id']; ?>> Edit </a> | 
                    <button onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
                    
                    <p id=<?php echo 'upvote_post_'.$current_post_id;?> style='cursor:pointer;width:50px' 
                        onclick='<?php echo $upvote_post_js_func; ?>'><?php echo $upvoted?'upvoted':'upvote'; ?> </p>
                    <p id=<?php echo 'downvote_post_'.$current_post_id;?> style='cursor:pointer;width:50px' 
                        onclick='<?php echo $downvote_post_js_func; ?>'><?php echo $downvoted?'downvoted':'downvote'; ?></p>
                    
                    <?php
                    echo "<hr>";
                    ?>
                    
                    <input type="text" id=<?php echo "comment_body_post_".$current_post_id;?> name="comment_body"/>
                    <button type="submit" onclick="comment(<?php echo $current_post_id; ?>)">Comment</button>
                    
                    <hr>
                    <!-- SHOW COMMENTS -->
                    <div id='<?php echo $all_comments_for_this; ?>'>
                        <?php
                        if(!isset($arr_comments[$current_post_id])) continue;
                        for($j=0;$j<count($arr_comments[$current_post_id]); $j++)
                        {
                            echo '<h5>' . $arr_comments[$current_post_id][$j]['author'] . '</h5>';
                            echo '<h6>' . $arr_comments[$current_post_id][$j]['body'] . '</h6>';
                            //check owner then add edit and delete options
                            
                            if(intval($arr_comments[$current_post_id][$j]['author'])==$_SESSION['id'])
                            {
                                ?>
                                <h6> 
                                    <a href=
                                    <?php echo '/ekom/public/comment/editComment/'.
                                    $arr_comments[$current_post_id][$j]['id'];?>
                                    >Edit</a> or 
                                    <p style='cursor:pointer;' onclick=
                                    '<?php 
                                        echo 'deleteComment(' . $current_post_id . 
                                        ', ' . $arr_comments[$current_post_id][$j]['id']
                                        .')';
                                    ?>'>Delete</p> 
                                </h6> 
                                <br>
                                <?php
                            // }
                            // else {
                                $arr_up_voters = explode(';', $arr_comments[$current_post_id][$j]['up_voters'], -1);

                                if(in_array($_SESSION['id'], $arr_up_voters))
                                {
                                ?>
                                    <h6 id=<?php echo 'upvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'upvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ',)';?> style='cursor:pointer'> upvoted </h6>
                                
                                <?php
                                }
                                else {
                                    ?>
                                    <h6 id=<?php echo 'upvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'upvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ')';?> style='cursor:pointer'> upvote </h6>
                                <?php
                                }

                                $arr_down_voters = explode(';', $arr_comments[$current_post_id][$j]['down_voters'], -1);

                                if(in_array($_SESSION['id'], $arr_down_voters))
                                {
                                ?>
                                    <h6 id=<?php echo 'downvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'downvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ',)';?> style='cursor:pointer'> downvoted </h6>
                                
                                <?php
                                }
                                else {
                                    ?>
                                    <h6 id=<?php echo 'downvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'downvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ')';?> style='cursor:pointer'> downvote </h6>
                                <?php
                                }
                            }
                            echo '<br>';
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
        let comment_body = document.getElementById('comment_body_post_'+post_id).value;

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

    function deleteComment(post_id, comment_id)
    {
        if(comment_id < 0 || post_id < 0) return false;

        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById("all_comments_for_"+post_id).innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("GET", "/ekom/public/comment/deleteComment/"+post_id+"/"+comment_id, true);
        xhttp.send();
    }

    function upvote_post(post_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('upvote_post_'+post_id).innerHTML = xhttp.responseText;
                document.getElementById('downvote_post_'+post_id).innerHTML = "downvote";

            }
        };
        xhttp.open("GET", "/ekom/public/post/upvote"+"/"+post_id, true);
        xhttp.send();
    }

    function downvote_post(post_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('downvote_post_'+post_id).innerHTML = xhttp.responseText;
                document.getElementById('upvote_post_'+post_id).innerHTML = "upvote";
            }
        };
        xhttp.open("GET", "/ekom/public/post/downvote"+"/"+post_id, true);
        xhttp.send();
    }

    function upvote(comment_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('upvote_'+comment_id).innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("GET", "/ekom/public/comment/upvote"+"/"+comment_id, true);
        xhttp.send();
    }

    function downvote(comment_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('downvote_'+comment_id).innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("GET", "/ekom/public/comment/downvote"+"/"+comment_id, true);
        xhttp.send();
    }

    function follow(to_follow)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange= function()
        {
            if(this.readyState==4 && this.status==200)
            {
                document.getElementById("follow_btn").innerHTML = xhttp.responseText;
            }
        };

        xhttp.open("GET", "/ekom/public/auth/follow/"+to_follow, true);
        xhttp.send();
    }

</script>
