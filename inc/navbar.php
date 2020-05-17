<div class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- DON'T SHOW REG/LOG IN IF LOGGED IN. SHOW LOG OUT INSTEAD -->
    
    <a class="navbar-brand" href="/social_site/public/"> Home </a>
    <a class="navbar-brand" href="/social_site/public/pages/about"> About </a>
    <a class="navbar-brand" href="/social_site/public/auth/profile"> Profile </a>
    <?php 
    if(isset($_SESSION['username']))
    {
        ?>
        
        <div class="container justify-content-md-end">
            <a class="navbar-brand" href="/social_site/public/post/new"><?php echo 'New Post'; ?></a>            
            <a class="navbar-brand" href="/social_site/public/auth/profile"><?php echo $_SESSION['username'];?></a>            
            <a class="navbar-brand" href="/social_site/public/auth/logOut"> Log Out </a>
        </div>

        <?php
    }
    else
    {
        ?>    
        <div class="container justify-content-md-end">
            <a class="navbar-brand" href="/social_site/public/auth/reg"> Register </a>
            <a class="navbar-brand" href="/social_site/public/auth/logIn"> Log In </a>
        </div>
        <?php
    }
    ?>
</div>
<br>
<br>
<br>

