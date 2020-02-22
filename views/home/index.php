<html>
    <head> <title> Home | Ekom </title> </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!-- DON'T SHOW REG/LOG IN IF LOGGED IN. SHOW LOG OUT INSTEAD -->
            <?php 
           // session_start(); //for i'm not in the same file (as in dashboard)
            if(isset($_SESSION['username']))
            {
               ?>
                <a class="navbar-brand" href="home"> Home </a>
                <a class="navbar-brand" href="home/about"> About </a>
                <a class="navbar-brand" href="auth/dashboard"> Dashboard </a>
                
                <div class="container justify-content-md-end">            
                    <a class="navbar-brand" href="auth/logOut"> Log Out </a>
                </div>

                <?php
            }
            else
            {
                ?>
                <a class="navbar-brand" href="home"> Home </a>
                <a class="navbar-brand" href="home/about"> About </a>
                <a class="navbar-brand" href="auth/dashboard"> Dashboard </a>
                
                <div class="container justify-content-md-end">
                    <a class="navbar-brand" href="auth/reg"> Register </a>
                    <a class="navbar-brand" href="auth/logIn"> Log In </a>
                </div>
                <?php
            }
            ?>
        </nav>
        <main>
        <!--    <h1> Index View </h1>
            <h3> Available Data: </h3>
            <h4> Id: <?php //echo $this->getData()['id']; ?> </h4>
            <h4> Name: <?php //echo $this->getData()['name']; ?> </h4>-->
        </main>
    </body>
</html>