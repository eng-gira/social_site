<?php
    $link = '/ekom/public/comment/updateComment/' . $this->getData()['comment_id'];
    echo $link . '<br>';
?>

<form action =<?php echo $link; ?> method="POST">
    <input type="text" name="new_comment_body"/>
    <button type="submit"> Submit Update </button>
</form>

<a href="/ekom/public/auth/dashboard"> Cancel </a>