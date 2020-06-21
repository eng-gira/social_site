<?php
    $post = $this->getData()['post'];
    $comments=$this->getData()['comments'];
?>

<div class='post'>
    <?php
    echo "<h5>". $post['title'] . "</h5>";
    echo "<h6>". $post['body'] . "</h6>";
    echo "<hr>";
    $delete_link = "/social_site/public/post/delete_post/" . $post['id'];
    
    $post_id = $post['id'];
    
    $all_comments_for_this = 'all_comments_for_' . $post_id;

    $upvote_post_js_func= 'upvote_post(' . $post_id.')';
    $downvote_post_js_func = 'downvote_post(' . $post_id .')';

    $up_voters=explode(';', $post['up_voters'], -1);
    $down_voters=explode(';', $post['down_voters'], -1);


    $upvoted= in_array($_SESSION['id'], $up_voters);
    $downvoted = in_array($_SESSION['id'], $down_voters);
    ?>
    <a href=<?php echo "/social_site/public/post/edit/" . $post['id']; ?>> Edit </a> | 
    <button onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
    
    <p id=<?php echo 'upvote_post_'.$post_id;?> style='cursor:pointer;width:50px' 
        onclick='<?php echo $upvote_post_js_func; ?>'><?php echo $upvoted?'upvoted':'upvote'; ?> </p>
    <p id=<?php echo 'downvote_post_'.$post_id;?> style='cursor:pointer;width:50px' 
        onclick='<?php echo $downvote_post_js_func; ?>'><?php echo $downvoted?'downvoted':'downvote'; ?></p>
    
    <?php
    echo "<hr>";
    ?>
    
    <input type="text" id=<?php echo "comment_body_post_".$post_id;?> name="comment_body"/>
    <button type="submit" onclick="comment(<?php echo $post_id; ?>)">Comment</button>
    
    <hr>
    <!-- SHOW COMMENTS -->
    <div id='<?php echo $all_comments_for_this; ?>'>
        <?php
        if(is_array($comments))
        {
            for($j=0;$j<count($comments); $j++)
            {
                echo '<h5>' . $comments[$j]['author'] . '</h5>';
                echo '<h6>' . $comments[$j]['body'] . '</h6>';
                //check owner then add edit and delete options
                
                if(intval($comments[$j]['author'])==$_SESSION['id'])
                {
                    ?>
                    <h6> 
                        <a href=
                        <?php echo '/social_site/public/comment/edit/'.
                        $comments[$j]['id'];?>
                        >Edit</a> or 
                        <p style='cursor:pointer;' onclick=
                        '<?php 
                            echo 'deleteComment(' . $post_id . 
                            ', ' . $comments[$j]['id']
                            .')';
                        ?>'>Delete</p> 
                    </h6> 
                    <br>
                    <?php
                // }
                // else {
                    $arr_up_voters = explode(';', $comments[$j]['up_voters'], -1);

                    if(in_array($_SESSION['id'], $arr_up_voters))
                    {
                    ?>
                        <h6 id=<?php echo 'upvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'upvote(' . $comments[$j]['id'] . 
                        ',)';?> style='cursor:pointer'> upvoted </h6>
                    
                    <?php
                    }
                    else {
                        ?>
                        <h6 id=<?php echo 'upvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'upvote(' . $comments[$j]['id'] . 
                        ')';?> style='cursor:pointer'> upvote </h6>
                    <?php
                    }

                    $arr_down_voters = explode(';', $comments[$j]['down_voters'], -1);

                    if(in_array($_SESSION['id'], $arr_down_voters))
                    {
                    ?>
                        <h6 id=<?php echo 'downvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'downvote(' . $comments[$j]['id'] . 
                        ',)';?> style='cursor:pointer'> downvoted </h6>
                    
                    <?php
                    }
                    else {
                        ?>
                        <h6 id=<?php echo 'downvote_'. $comments[$j]['id']; ?> 
                        onclick=<?php echo 'downvote(' . $comments[$j]['id'] . 
                        ')';?> style='cursor:pointer'> downvote </h6>
                    <?php
                    }
                }
                echo '<br>';
            }
        }

        ?>
    </div>
    <hr>
</div>