<div class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- DON'T SHOW REG/LOG IN IF LOGGED IN. SHOW LOG OUT INSTEAD -->
    
    <a class="navbar-brand" href="/social_site/public/"> Home </a>
    <a class="navbar-brand" href="/social_site/public/pages/about"> About </a>
    <a class="navbar-brand" href="/social_site/public/auth/profile"> Profile </a>
    <form action="/social_site/public/post/search" method="POST" class="navbar-brand form-inline my-2 my-lg-0">
            <input name="search" class="form-control mr-sm-2" type="text" placeholder="Search Posts" aria-label="Search"/>
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>

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

