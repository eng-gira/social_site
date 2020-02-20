<?php

    $action = '/ekom/public/post/updatePost/' . $this->getData()['post_id'];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/ekom/public/home"> Home </a>
        <a class="navbar-brand" href="/ekom/public/home/about"> About </a>
        
        <div class="container justify-content-md-end">            
            <a class="navbar-brand" href="/ekom/public/auth/dashboard"> <?php echo $_SESSION['username']; ?> </a>
            <a class="navbar-brand" href="/ekom/public/auth/logOut"> Log Out </a>
        </div>
    </nav> <br><br><br>

    <form action=<?php echo $action; ?> method="POST">
        New Title: <input type="text" name="new_title" required/>
        New Body: <input name="new_body" style="height:200px;width:200px" required/>
        <button type="submit"> Submit Updates </button>
    </form><br>
    <a href="/ekom/public/auth/dashboard"> Cancel </a>
