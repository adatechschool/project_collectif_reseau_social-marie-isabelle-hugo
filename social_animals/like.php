<?php 
$postId = $post['ID'];


// get post's likes
$getPostLikesRequest = "SELECT COUNT(post_id) as likenumber FROM likes WHERE post_id = $postId" ;
$getPostLikes = $mysqli->query($getPostLikesRequest);
$postLikes = $getPostLikes->fetch_assoc();


// verify if post has been liked by user
$hasBeenLikedSQL = "SELECT post_id FROM likes WHERE user_id = $connectedUserId AND post_id = $postId";
$hasBeenLikedInfo = $mysqli->query($hasBeenLikedSQL);
$hasBeenLiked = $hasBeenLikedInfo->fetch_assoc();

if ($hasBeenLiked) {
    $liked = true;
} else {
    $liked = false;
}

$beenClicked = isset($_POST[$postId]);
if ($beenClicked) {
    $hasNotBeenLikedSQL = "INSERT INTO likes (user_id, post_id) VALUES ($connectedUser, $postId) ";
    $hasNotBeenLikedInfo = $mysqli->query($hasNotBeenLikedSQL);
    $liked = true;
}

// get actual page URL for refresh
$actualPageUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


?>


<!-- HTML -->

<div>
    <?php var_dump($postLikes); 
        echo $postLikes['likenumber'];
        echo $actualPageUrl;?>
</div>

<form method="post" action='<?php echo $actualPageUrl ?>'>
    <input type="submit" name=<?php echo $postId ?> value="♥ <?php echo $post['like_number']; ?>">
</form>
