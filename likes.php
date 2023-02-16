<?php
$postId = $post['id_post'];
$hasBeenLikedSQL = "
SELECT post_id FROM likes
WHERE user_id = $connectedUser AND post_id = $postId
";
$hasBeenLikedInfo = $mysqli->query($hasBeenLikedSQL);
$info = $hasBeenLikedInfo->fetch_assoc();

if ($info) {
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