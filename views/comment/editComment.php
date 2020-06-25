<?php
    include('C:\xampp\htdocs\social_site\inc\navbar.php');

    $link = '/social_site/public/comment/updateComment/' . $this->getData()['comment_id'];
    // echo $link . '<br>';
?>

<h3> Update Comment </h3>
<br>

<b> Original Comment: </b><?php echo $this->getData()['original_comment_body'];?>

<br>

<form action =<?php echo $link; ?> method="POST">
    <input type="text" name="new_comment_body" required>
    <button type="submit"> Submit Update </button>
</form>

<a href="/social_site/public/auth/profile"> Cancel </a>