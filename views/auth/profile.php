<?php include('C:\xampp\htdocs\social_site\inc\navbar.php');?>

<html>
    <head></head>
    <body>
        <main>
            <?php
                $message = $_SESSION['message'];
                $count_times_message_shown = $_SESSION['count_times_message_shown'];

                if(count($message)>0 && intval($count_times_message_shown)==0)
                {
                    $message_type= $message[0];
                    $message_content = $message[1];

                    $color = $message_type == 'success' ? '#a8d6b4' : '#ff7777';

                    ?>
                    <div class="message" style="<?php echo 'background-color:'.$color ?>">
                        <p style="<?php echo 'font-color:'.$color;?>"> <?php echo $message_content;?></p>
                    </div>
                    <?php
                    $_SESSION['count_times_message_shown']=1;
                }

                $visited_data = $this->getData()['visited_data'];
                $id_visited= $visited_data['id'];
                $username_visited = $visited_data['username'];
                $f_unf = $this->getData()['f_unf'];
                if($id_visited!=$_SESSION['id'])
                {
                    ?>
                    <p id="follow_btn" style='cursor:pointer;width:45px' onclick=<?php echo 'follow('.$id_visited.')'; ?>> 
                        <?php echo $f_unf;?> 
                    </p>
                    <?php
                }

                $posts_of_visited = $this->getData()['posts_of_profile_owner'];
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
                                if($i<count($arr_all_users)-1) echo ', ';
                              ?>
                             </a>                        
                         <?php
                    }
                }
                echo '<br><br><hr><br><br>';

                if(count($posts_of_visited)>0)
                {
                ?>
                    <h2> Posts by<?php echo ' <i>'.$username_visited.'</i>';?> </h2><br>
                <?php
                }
                for($i=0; $i<count($posts_of_visited); $i++)
                {
                    ?>
                <div class='post'>
                    <?php
                    echo "<div class='post_title'>". $posts_of_visited[$i]['title'] . "</div>";
                    echo "<div class='post_body'>". $posts_of_visited[$i]['body'] . "</div>";
                    echo "<hr>";
                    $delete_link = "/social_site/public/post/delete/" . $posts_of_visited[$i]['id'];
                    
                    $current_post_id = $posts_of_visited[$i]['id'];
                    
                    $all_comments_for_this = 'all_comments_for_' . $current_post_id;

                    $upvote_post_js_func= 'upvote_post(' . $current_post_id.')';
                    $downvote_post_js_func = 'downvote_post(' . $current_post_id .')';

                    $up_voters=explode(';', $posts_of_visited[$i]['up_voters'], -1);
                    $down_voters=explode(';', $posts_of_visited[$i]['down_voters'], -1);


                    $upvoted= in_array($_SESSION['id'], $up_voters);
                    $downvoted = in_array($_SESSION['id'], $down_voters);
                    
                    // LIMITING ACCESS
                    if($_SESSION['id'] == $id_visited)
                    {?>
                        <a class="edit_post_link" href=<?php echo "/social_site/public/post/edit/" . $posts_of_visited[$i]['id']; ?>> Edit </a> | 
                        <button style="margin-left:10px; height:28px;" class="del_post_btn" onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
                        
                        |

                    <?php
                    }
                    ?>
                    
                    
                    <p class="vote_on_post" id=<?php echo 'upvote_post_'.$current_post_id;?> style='cursor:pointer;width:50px;display:inline-block;' 
                        onclick='<?php echo $upvote_post_js_func; ?>'><?php echo $upvoted?'upvoted':'upvote'; ?> </p>
                    
                    |
                    
                    <p class="vote_on_post" id=<?php echo 'downvote_post_'.$current_post_id;?> style='cursor:pointer;width:50px;display:inline-block;margin-left:10px' 
                        onclick='<?php echo $downvote_post_js_func; ?>'><?php echo $downvoted?'downvoted':'downvote'; ?></p>
                    <br>
                
                    <input class="comment" type="text" style="height:25px;" id=<?php echo "comment_body_post_".$current_post_id;?> name="comment_body"/>
                    <button type="submit" style="height:28px;" onclick="comment(<?php echo $current_post_id; ?>)">Comment</button>
                    <hr>
                    <!-- SHOW COMMENTS -->
                    <div id='<?php echo $all_comments_for_this; ?>' class="comment_div">
                        <?php
                        if(!isset($arr_comments[$current_post_id])) {echo'</div>';continue;}
                        
                        for($j=0;$j<count($arr_comments[$current_post_id]); $j++)
                        {
                            echo 
                            '<div>
                                <h5 class="comment" style="display:inline-block;">' . 
                                    $arr_comments[$current_post_id][$j]['author']['username'] . ':&nbsp</h5>';
                            echo
                                '<h5 class="comment" style="display:inline-block;">'.$arr_comments[$current_post_id][$j]['body'].'</h5>
                            </div>';
                            
                            //check owner then add edit and delete options
                            
                            if(intval($arr_comments[$current_post_id][$j]['author']['id'])==$_SESSION['id'])
                            {
                                ?>
                                <h6 class="comment_options d-inline-block"> 
                                    <a class="d-inline-block" href=
                                    <?php echo '/social_site/public/comment/editComment/'.
                                    $arr_comments[$current_post_id][$j]['id'];?>
                                    >Edit</a> | 
                                    <p style='cursor:pointer;' class="d-inline-block" onclick=
                                    '<?php 
                                        echo 'deleteComment(' . $arr_comments[$current_post_id][$j]['id']
                                        .')';
                                    ?>'>Delete</p> 
                                </h6> 
                                
                                |


                                <?php
                            }
                         
                                $arr_up_voters = explode(';', $arr_comments[$current_post_id][$j]['up_voters'], -1);

                                if(in_array($_SESSION['id'], $arr_up_voters))
                                {
                                ?>
                                    <h6 class="comment_options d-inline-block" id=<?php echo 'upvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'upvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ')';?> style='cursor:pointer'> upvoted </h6> 
                                |

                                <?php
                                }
                                else {
                                    ?>
                                    <h6 class="comment_options d-inline-block" id=<?php echo 'upvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'upvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ')';?> style='cursor:pointer'> upvote </h6>

                                |


                                <?php
                                }

                                $arr_down_voters = explode(';', $arr_comments[$current_post_id][$j]['down_voters'], -1);

                                if(in_array($_SESSION['id'], $arr_down_voters))
                                {
                                ?>
                                    <h6 class="comment_options d-inline-block" id=<?php echo 'downvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'downvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ')';?> style='cursor:pointer'> downvoted </h6>
                                
                                <?php
                                }
                                else {
                                    ?>
                                    <h6 class="comment_options d-inline-block" id=<?php echo 'downvote_'. $arr_comments[$current_post_id][$j]['id']; ?> 
                                    onclick=<?php echo 'downvote(' . $arr_comments[$current_post_id][$j]['id'] . 
                                    ')';?> style='cursor:pointer'> downvote </h6>
                                <?php
                                }
                            
                            echo '<hr>';
                        }

                        ?>
                    </div>
                </div>
                    <?php
                   
                }
            ?>
        </main>
    </body>
</html>
