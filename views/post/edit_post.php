<?php include('C:\xampp\htdocs\social_site\inc\navbar.php');

    $action = '/social_site/public/post/update/' . $this->getData()['post_id'];
    ?>

    <form action=<?php echo $action; ?> method="POST">
        New Title: <input type="text" name="new_title" required/>
        New Body: <input name="new_body" style="height:200px;width:200px" required/>
        <button type="submit"> Submit Updates </button>
    </form><br>
    <a href="/social_site/public/auth/dashboard"> Cancel </a>
