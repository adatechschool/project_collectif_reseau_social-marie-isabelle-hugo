<?php 

// Getting the post ID
$postId = $post['ID'];

// get post's likes
$getPostLikesRequest = "SELECT COUNT(post_id) as like_number FROM likes WHERE post_id = $postId" ;
$getPostLikes = $mysqli->query($getPostLikesRequest);
$postLikes = $getPostLikes->fetch_assoc();

// Total number of likes, total number of other members's likes
$otherLikes = intval($postLikes['like_number']) - 1;
$totalLikes = $postLikes['like_number'];


// verify if post has been liked by user
$hasBeenLikedSQL = "SELECT post_id FROM likes WHERE user_id = $connectedUserId AND post_id = $postId";
$hasBeenLikedInfo = $mysqli->query($hasBeenLikedSQL);
$hasBeenLiked = $hasBeenLikedInfo->fetch_assoc();

// get actual page URL for refresh
$actualPageUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if ($hasBeenLiked){ ?>
    <div id="likes" class="flex flex-wrap space-between items-center space-x-20 pt-5">
        <div id="members-liking" class="italic text-xs">You <?php 
            if($otherLikes > 1) {
                echo 'and ' . $otherLikes ?> other animals like this photo
            <?php } elseif ($otherLikes == 1) {
                echo 'and ' . $otherLikes ?> other animal like this photo
            <?php } else { ?>
                like this photo
            <?php  } ?>
        </div>
        <form method="post" action='<?php echo $actualPageUrl ?>'>
            <input type="hidden" name="getPostId" value='<?php echo $postId ?>'>
            <input type="submit" name="unlike" value="♥ <?php echo $postLikes['like_number']; ?>"
            class="font-extrabold cursor-pointer hover:text-orange-600">
        </form>
    </div>

<?php } else { ?>
    <div id="likes" class="flex flex-wrap space-between items-center space-x-20 pt-5">
        <div id="members-liking" class="italic text-xs">
            <?php if($totalLikes > 1) {
                echo $totalLikes ?> animals like this photo
            <?php } else {
                echo $totalLikes ?> animal likes this photo
            <?php  } ?>
        </div>
        <form method="post" action='<?php echo $actualPageUrl ?>'>
            <input type="hidden" name="getPostId" value='<?php echo $postId ?>'>
            <input type="submit" name="like" value="♥ <?php echo $postLikes['like_number']; ?>"
            class="cursor-pointer hover:text-orange-600">
        </form>
    </div>
<?php } ?>
