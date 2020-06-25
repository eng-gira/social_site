<?php include('C:\xampp\htdocs\social_site\inc\navbar.php'); ?>
 
 <h4> New Post </h4><br><br>
 <form action="/social_site/public/post/insert" method="POST">
     Post Title: <input type="text" name="post_title" required/> <br><br>
     Post Body: <input name="post_body" style="height:200px;width:200px" min="100" required/> <br><br>
     <button type="submit"> Submit Post </button>
 
 </form><br><hr><br>

