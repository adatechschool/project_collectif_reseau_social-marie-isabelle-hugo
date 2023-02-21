<?php
include('connect.php');

?>
<form action="posteditor.php" enctype="multipart/form-data" method="post">
    <label for="user_picture">Choose a picture</label>
    <input type="file" name="user_picture" />
    <p>Your comment</p>
    <textarea name="" id="" cols="30" rows="10"></textarea>
    <input type="submit">
</form>


?>