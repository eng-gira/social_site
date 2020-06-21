<?php include('C:\xampp\htdocs\social_site\inc\navbar.php');?>

<html>
    <head> <title> Home | Social Site </title> </head>
    <body>
        
        <div class="container">

            <?php 
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