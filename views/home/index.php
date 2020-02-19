<html>
    <head> <title> Home | Ekom </title> </head>
    <body>
        <nav>
            <!-- DON'T SHOW REG/LOG IN IF LOGGED IN. SHOW LOG OUT INSTEAD -->
            <?php 
            session_start(); //for i'm not in the same file (as in auth_home)
            if(isset($_SESSION['username']))
            {
               ?>
            
                <a href="auth/logOut"> Log Out </a>
            
                <?php
            }
            else
            {
                ?>
            
                <a href="auth/reg"> Register </a>  |  <a href="auth/logIn"> Log In </a>
            
                <?php
            }
            ?>
        </nav>
        <main>
            <h1> Index View </h1>
            <h3> Available Data: </h3>
            <h4> Id: <?php echo $this->getData()['id']; ?> </h4>
            <h4> Name: <?php echo $this->getData()['name']; ?> </h4>
        </main>
    </body>
</html>