<?php include('C:\xampp\htdocs\social_site\inc\navbar.php'); ?>


<?php
    $post = $this->getData()['post'];
    $author_data= $this->getData()['author_data'];
    $comments=$this->getData()['comments'];
?>

<div class='post'>
    <?php
    echo "<div class='post_title'>". $post['title'] . "</div>";
    echo "<h6> By: <i>" . $author_data['username'] . "</i></h6>";
    echo "<div class='post_body'>". $post['body'] . "</div>";
    echo "<hr>";
    $delete_link = "/social_site/public/post/delete_post/" . $post['id'];
    
    $post_id = $post['id'];
    
    $all_comments_for_this = 'all_comments_for_' . $post_id;

    if(isset($_SESSION['username']))
    {
        $upvote_post_js_func= 'upvote_post(' . $post_id.')';
        $downvote_post_js_func = 'downvote_post(' . $post_id .')';
    
        $up_voters=explode(';', $post['up_voters'], -1);
        $down_voters=explode(';', $post['down_voters'], -1);
    
    
        $upvoted= in_array($_SESSION['id'], $up_voters);
        $downvoted = in_array($_SESSION['id'], $down_voters);
        
    
        // LIMITING ACCESS
        if($_SESSION['id'] == $author_data['id'])
        {
            ?>
            <a class="edit_post_link" href=<?php echo "/social_site/public/post/edit/" . $post['id']; ?>> Edit </a> | 
            <button class="del_post_btn" style="margin-left:10px; height:28px;" onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
            
            |

            <?php
        }
        
        ?>
        
        <p class="vote_on_post" id=<?php echo 'upvote_post_'.$post_id;?> style='cursor:pointer;width:50px;display:inline-block;' 
            onclick='<?php echo $upvote_post_js_func; ?>'><?php echo $upvoted?'upvoted':'upvote'; ?> </p>

        |


        <p class="vote_on_post" id=<?php echo 'downvote_post_'.$post_id;?> style='cursor:pointer;width:50px;display:inline-block;' 
            onclick='<?php echo $downvote_post_js_func; ?>'><?php echo $downvoted?'downvoted':'downvote'; ?></p>

        
        <?php
        echo "<hr>";
        ?>
        
        <input type="text" id=<?php echo "comment_body_post_".$post_id;?> name="comment_body"/>
        <button type="submit" onclick="comment(<?php echo $post_id; ?>)">Comment</button>
        
        <hr>
        <?php
    }
    ?>
    <!-- SHOW COMMENTS -->
    <div id='<?php echo $all_comments_for_this; ?>' class="comment_div">
        <?php
        if(is_array($comments))
        {
            for($j=0;$j<count($comments); $j++)
            {
                echo '<div>
                    <h5 class="comment" style="display:inline-block;">' . $comments[$j]['author']['username'] .':&nbsp</h5>'; 
                    
                echo '<h5 class="comment" style="display:inline-block;">' . $comments[$j]['body']. '</h5>
                </div>';
                
                if(isset($_SESSION['id']))
                {
                    //limiting access
                    if(intval($comments[$j]['author']['id'])==$_SESSION['id'])
                    {
                        ?>
                        <h6 class="comment_options d-inline-block"> 
                            <a class="d-inline-block" href=
                            <?php echo '/social_site/public/comment/editComment/'.
                            $comments[$j]['id'];?>
                            >Edit</a> 
                            
                            |

                            <p style='cursor:pointer;' class="d-inline-block" onclick=
                            '<?php 
                                echo 'deleteComment(' . $comments[$j]['id']
                                .')';
                            ?>'>Delete</p> 
                        </h6> 
                    |
                        <?php
                    }

                    $arr_up_voters = explode(';', $comments[$j]['up_voters'], -1);

                    if(in_array($_SESSION['id'], $arr_up_voters))
                    {
                    ?>
                        <h6 class="comment_options d-inline-block" id=<?php echo 'upvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'upvote(' . $comments[$j]['id'] . 
                        ',)';?> style='cursor:pointer'> upvoted </h6>
                    |
                    <?php
                    }
                    else {
                        ?>
                        <h6 class="comment_options d-inline-block" id=<?php echo 'upvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'upvote(' . $comments[$j]['id'] . 
                        ')';?> style='cursor:pointer'> upvote </h6>

                    |


                    <?php
                    }

                    $arr_down_voters = explode(';', $comments[$j]['down_voters'], -1);

                    if(in_array($_SESSION['id'], $arr_down_voters))
                    {
                    ?>
                        <h6 class="comment_options d-inline-block" id=<?php echo 'downvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'downvote(' . $comments[$j]['id'] . 
                        ',)';?> style='cursor:pointer'> downvoted </h6>
                    
                    <?php
                    }
                    else {
                        ?>
                        <h6 class="comment_options d-inline-block" id=<?php echo 'downvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'downvote(' . $comments[$j]['id'] . 
                        ')';?> style='cursor:pointer'> downvote </h6>
                    <?php
                    }
                    echo '<br>';
                }
                
            }
        }

        ?>
    </div>
    <hr>
</div>