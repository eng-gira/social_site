<?php include('C:\xampp\htdocs\social_site\inc\navbar.php');?>

<html>
    <head></head>
    <body>
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

                $arr_my_posts = $this->getData()['posts_of_profile_owner'];
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
                            echo '/social_site/public/auth/profile/'.$current_id; 
                        ?>
                             >  
                             <?php 
                                echo $current_username; 
                              ?>
                             </a>                        
                         <?php
                    }
                }
                echo '<br><br><hr><br><br>';

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
                    $delete_link = "/social_site/public/post/delet_post/" . $arr_my_posts[$i]['id'];
                    
                    $current_post_id = $arr_my_posts[$i]['id'];
                    
                    $all_comments_for_this = 'all_comments_for_' . $current_post_id;

                    $upvote_post_js_func= 'upvote_post(' . $current_post_id.')';
                    $downvote_post_js_func = 'downvote_post(' . $current_post_id .')';

                    $up_voters=explode(';', $arr_my_posts[$i]['up_voters'], -1);
                    $down_voters=explode(';', $arr_my_posts[$i]['down_voters'], -1);


                    $upvoted= in_array($_SESSION['id'], $up_voters);
                    $downvoted = in_array($_SESSION['id'], $down_voters);
                    ?>
                    <a href=<?php echo "/social_site/public/post/edit/" . $arr_my_posts[$i]['id']; ?>> Edit </a> | 
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
                                    <?php echo '/social_site/public/comment/edit/'.
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
