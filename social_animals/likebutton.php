<?php 

// Getting the post ID
$postId = $post['ID'];

// get post's likes
$getPostLikesRequest = "SELECT COUNT(post_id) as like_number FROM likes WHERE post_id = $postId" ;
$getPostLikes = $mysqli->query($getPostLikesRequest);
$postLikes = $getPostLikes->fetch_assoc();


// verify if post has been liked by user
$hasBeenLikedSQL = "SELECT post_id FROM likes WHERE user_id = $connectedUserId AND post_id = $postId";
$hasBeenLikedInfo = $mysqli->query($hasBeenLikedSQL);
$hasBeenLiked = $hasBeenLikedInfo->fetch_assoc();

// get actual page URL for refresh
$actualPageUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if ($hasBeenLiked){ ?>
<form method="post" action='<?php echo $actualPageUrl ?>'>
    <input type="hidden" name="getPostId" value='<?php echo $postId ?>'>
    <input type="submit" name="unlike" value="♥ <?php echo $postLikes['like_number']; ?>"
    class="font-extrabold cursor-pointer">
</form>

<?php } else { ?>
    <form method="post" action='<?php echo $actualPageUrl ?>'>
    <input type="hidden" name="getPostId" value='<?php echo $postId ?>'>
    <input type="submit" name="like" value="♥ <?php echo $postLikes['like_number']; ?>"
    class="cursor-pointer">
</form>

<?php } ?>
