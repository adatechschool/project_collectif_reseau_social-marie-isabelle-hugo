<?php 
$postId = $post['ID'];

// get post's likes
$getPostLikesRequest = "COUNT post_id FROM likes WHERE post_id = $postID";
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
    $hasNotBeenLikedSQL = "
            INSERT INTO likes (post_id, user_id)
        VALUES ($postId, $connectedUser)
            ";
    $hasNotBeenLikedInfo = $mysqli->query($hasNotBeenLikedSQL);
    $liked = true;
}

?>

