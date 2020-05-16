<html>
    <head> <title> Home | Social Site </title> </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- DON'T SHOW REG/LOG IN IF LOGGED IN. SHOW LOG OUT INSTEAD -->
            
            <a class="navbar-brand" href="home"> Home </a>
            <a class="navbar-brand" href="home/about"> About </a>
            <a class="navbar-brand" href="auth/profile"> Profile </a>
            <?php 
           // session_start(); //for i'm not in the same file (as in dashboard)
            if(isset($_SESSION['username']))
            {
               ?>
                
                <div class="container justify-content-md-end">            
                    <a class="navbar-brand" href="auth/logOut"> Log Out </a>
                </div>

                <?php
            }
            else
            {
                ?>    
                <div class="container justify-content-md-end">
                    <a class="navbar-brand" href="auth/reg"> Register </a>
                    <a class="navbar-brand" href="auth/logIn"> Log In </a>
                </div>
                <?php
            }
            ?>
        </nav>
        <div>
        <!--    <h1> Index View </h1>
            <h3> Available Data: </h3>
            <h4> Id: <?php //echo $this->getData()['id']; ?> </h4>
            <h4> Name: <?php //echo $this->getData()['name']; ?> </h4>-->

            <?php 
                $all_posts = $this->getData()['all_posts'];
                foreach($all_posts as $post)
                {
                    echo 'title: ' . $post['post_title'] . '<br>';
                    echo 'body: ' . $post['post_body'] . '<br>';
                    echo 'author: ' . $post['post_author'] . '<br>';
                    echo 'post_up_voters: ' . $post['post_up_voters'] . '<br>';
                    echo 'post_down_voters: ' . $post['post_down_voters'] . '<br>';

                    echo '<br><hr><br>';
                }
            ?>


        </div>
    </body>
</html>