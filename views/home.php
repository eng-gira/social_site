<?php include('C:\xampp\htdocs\social_site\inc\navbar.php');?>

<html>
    <head> <title> Home | Social Site </title> </head>
    <body>
        
        <div class="container">

            <?php 
                if(isset($_SESSION['message']))
                {
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
                }
                
                $all_posts = $this->getData()['all_posts'];
                if(is_array($all_posts)){
                    foreach($all_posts as $post)
                    {
                        $show_link = '/social_site/public/post/show/'.$post['post_id'];
                        ?>
                        <a href="<?php echo $show_link;?>" class="post_title"><?php echo $post['post_title'];?></a>
                        <?php echo '<h6> By <i>'.$post['post_author'] . '</i></h6>';?>
                        <!-- <div class="post_body"><?php echo $post['post_body'];?></div> -->
                        
                        <?php 
                            if(count(explode(';', $post['post_up_voters'], -1))>0)
                            {
                                //link to open a pop-up
                            }
                            if(count(explode(';', $post['post_up_voters'], -1))>0)
                            {
                                //link to open a pop-up
                            }
                        ?>
                        
                        <br><hr><br>
                    <?php
                    }
                }
            ?>


        </div>
    </body>
</html>