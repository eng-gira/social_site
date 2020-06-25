<?php include('C:\xampp\htdocs\social_site\inc\navbar.php');

    $all_data = $this->getData();

    $posts= $all_data['posts'];
    $authors=$all_data['authors'];
    $count_search_results = $all_data['count_search_res'];


?>

<h3 style='font-weight:light'> Search Results: <?php echo '<b>'.$count_search_results.'</b>'; ?> </h3>
<br>

<?php
    if(count($posts)>0)
    {
        foreach($posts as $post)
        {
            ?>
            <div class='post'>
                <?php
                echo "<div class='post_title'>". $post['title'] . "</div>";
                echo "<h6> By: <i>" . $authors[$post['id']]['username'] . "</i></h6>";
                echo "<div class='post_body'>". $post['body'] . "</div>";
                echo "<hr>";
                $delete_link = "/social_site/public/post/delete/" . $post['id'];
                
                $current_post_id = $post['id'];
                
                $all_comments_for_this = 'all_comments_for_' . $current_post_id;
                
                if(isset($_SESSION['id']))
                {

                
                    $upvote_post_js_func= 'upvote_post(' . $current_post_id.')';
                    $downvote_post_js_func = 'downvote_post(' . $current_post_id .')';
        
                    $up_voters=explode(';', $post['up_voters'], -1);
                    $down_voters=explode(';', $post['down_voters'], -1);
        
        
                    $upvoted= in_array($_SESSION['id'], $up_voters);
                    $downvoted = in_array($_SESSION['id'], $down_voters);
                    ?>
                    <a class="edit_post_link" href=<?php echo "/social_site/public/post/edit/" . $post['id']; ?>> Edit </a> | 
                    <button style="margin-left:10px; height:28px;" class="del_post_btn" onclick='confirmPostDeletion("<?php echo $delete_link; ?>")')>Delete</button>
                    
                    |
                    
                    <p class="vote_on_post" id=<?php echo 'upvote_post_'.$current_post_id;?> style='cursor:pointer;width:50px;display:inline-block;' 
                        onclick='<?php echo $upvote_post_js_func; ?>'><?php echo $upvoted?'upvoted':'upvote'; ?> </p>
                    
                    |
                    
                    <p class="vote_on_post" id=<?php echo 'downvote_post_'.$current_post_id;?> style='cursor:pointer;width:50px;display:inline-block;margin-left:10px' 
                        onclick='<?php echo $downvote_post_js_func; ?>'><?php echo $downvoted?'downvoted':'downvote'; ?></p>
                    <br>
                
                    <input type="text" style="height:25px;" id=<?php echo "comment_body_post_".$current_post_id;?> name="comment_body"/>
                    <button type="submit" style="height:28px;" onclick="comment(<?php echo $current_post_id; ?>)">Comment</button>
                <?php 
                }
                ?>
                <hr>
            </div>
            <?php
        }    
    }
    
?>