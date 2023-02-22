<?php include('connect.php');
$myWall = true;
$otherUsersWall = false;

// Differenciating the connected user from the wall's owner
if (isset($_GET['user_id'])) {
    $wallOwnerId = intval($_GET['user_id']);
    $otherUsersWall = true;
    $myWall = false;
}

// If the user is on their wall, get all their info
if (!isset($_GET['user_id'])) {
    $userInfosRequest = "SELECT * FROM users WHERE users.id = $connectedUserId ";
    $getUserInfos = $mysqli->query($userInfosRequest);
    if (!$getUserInfos) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
    $user = $getUserInfos->fetch_assoc();

    // If the user is browsing another user's wall, get this user's info
} else {
    $userInfosRequest = "SELECT * FROM users WHERE users.id = $wallOwnerId ";
    $getUserInfos = $mysqli->query($userInfosRequest);
    if (!$getUserInfos) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
    $user = $getUserInfos->fetch_assoc();
}

// Get the user's type (cat, dog...)
$type = intval($user['type_id']);
$userTypeRequest = "SELECT * FROM type WHERE type.ID = $type ";
$getUserType = $mysqli->query($userTypeRequest);
if (!$getUserType) {
    echo ("Échec de la requete : " . $mysqli->error);
}
$userType = $getUserType->fetch_assoc();

// Get the user's posts
if (isset($_GET['user_id'])) {
    $userId = intval($user['ID']);
    $userPostsRequest = "SELECT * FROM posts WHERE posts.user_id = $userId ";
    $getUserPosts = $mysqli->query($userPostsRequest);
    if (!$getUserPosts) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
} else {
    $userId = $connectedUserId;
    $userPostsRequest = "SELECT * FROM posts WHERE posts.user_id = $userId ";
    $getUserPosts = $mysqli->query($userPostsRequest);
    if (!$getUserPosts) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
}

//Handle followers and follow - unfollow
$alreadyFollowed = false;
$userFollowingRequest = "SELECT followers.followed, users.id as user_followed, users.name as user_name FROM followers 
JOIN users ON users.id=followers.followed 
WHERE follower = $userId";
$getFollowing = $mysqli->query($userFollowingRequest);

$userFollowedRequest = "SELECT followers.follower, users.id as user_follower, users.name as user_name FROM followers 
JOIN users ON users.id=followers.follower
WHERE followed = $userId";
$getFollowed = $mysqli->query($userFollowedRequest);

$checkFollowSql = "SELECT * from followers WHERE followed=$userId";
$checkFolloQuery = $mysqli->query($checkFollowSql);

while ($isFollowed = $checkFolloQuery->fetch_assoc()) {
    if ($isFollowed['followed'] == $userId && $isFollowed['follower'] == $connectedUserId) {
        $alreadyFollowed = true;
    }
}

if (isset($_POST['follow'])) {
    $sqlInsert = "INSERT into followers (follower, followed)
    VALUES ($connectedUserId, $userId)";
    $insertFollowerTab = $mysqli->query($sqlInsert);
    $alreadyFollowed = true;
}

if (isset($_POST['unfollow'])) {
    $sqlInsert = "DELETE FROM followers WHERE followers.follower=$connectedUserId and followers.followed=$userId";
    $insertFollowerTab = $mysqli->query($sqlInsert);
    $alreadyFollowed = true;
}

// Send SQL request to like/unlike post
include('like.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Animals</title>
    <link href="output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-yellow-50">
    <?php
    include('header.php');
    ?>

    <div id="pageContent">
        <div>
            <main class="flex flex-col">

                <!-- User's informations -->
                <div id="userDetails" class="flex justify-center items-center space-x-16 py-10">
                    <!-- <div id="pictureContainer" class="w-30 h-30 rounded-full"> -->
                    <img class="object-cover object-center w-40 h-40 rounded-full"
                        src="upload/<?php echo $user['photo'] ?>" alt="Profile picture">
                    <div>
                        <div class="text-4xl">
                            <?php echo $user['name']; ?>
                        </div>
                        <div class="text-2xl pt-2">
                            <?php echo $userType["label"]; ?>
                        </div>
                        <div class="text-2xl pb-2">
                            <?php echo $user["email"]; ?>
                        </div>
                        <!-- Bouton Follow/UnFollow -->
                        <?php
                        if ($otherUsersWall) {
                            if ($alreadyFollowed) { ?>
                                <div>
                                    <form action="profile.php?user_id=<?php echo $userId ?>" method="post">
                                        <input type="submit" value="unfollow" name="unfollow"
                                            class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                    </form>
                                </div>
                            <?php } else { ?>
                                <div class="flex justify-center items-center space-x-16 py-10">
                                    <form action="profile.php?user_id=<?php echo $userId ?>" method="post">
                                        <input type="submit" value="follow" name="follow"
                                            class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                    </form>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="">
                    <div class="flex justify-center items-center space-x-16 ">
                        <div class="flex flex-col text-xl">
                            <p>Following</p>
                            <p>
                                <?php
                                while ($follo = $getFollowing->fetch_assoc()) {
                                    echo $follo['user_name'] . ' ';
                                } ?>
                            </p>
                        </div>
                        <div class="flex flex-col text-xl">
                            <p> Followed by</p>
                            <p>
                                <?php
                                while ($follo = $getFollowed->fetch_assoc()) {
                                    ?>

                                    <?php echo $follo['user_name']; ?>


                                <?php } ?>
                            </p>
                        </div>
                    </div>
                </div>


                <!-- New post form if user is on their wall -->
                <?php if ($myWall == true) { ?>
                    <div class="flex flex-row w-screen justify-center items-center space-y-8">
                        <?php include('posteditor.php') ?>
                        <div class="">
                            <form action="profile.php" enctype="multipart/form-data" method="post"
                                class="flex flex-col items-center bg-orange-100 mt-20 rounded-lg mx-80 py-4 px-8 ">
                                <label for="user_picture" class="bg-orange-200 rounded-full py-2 px-4 mb-4">Share your
                                    cutest picture!</label>
                                <input type="file" name="user_picture" />
                                <textarea name="description" id="" cols="30" rows="2" class="mt-4 rounded-lg"
                                    placeholder="Add a cool description"></textarea>
                                <input type="submit" value="Post"
                                    class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mt-4">
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <!-- User's older posts -->
                <!---------------- CSS A FAIRE  ------------>

                <?php while ($post = $getUserPosts->fetch_assoc()) {
                    ?>
                    <article class="flex flex-col items-center bg-orange-100 mt-20 rounded-lg mx-96 pb-24">
                        <a class="pt-10 text-3xl">
                            <address>
                                <?php
                                $postUser = $post['user_id'];
                                $newSql = "SELECT users.name as user_name FROM users WHERE users.ID = $postUser";
                                $lesInformations2 = $mysqli->query($newSql);
                                $postUserName = $lesInformations2->fetch_assoc();
                                ?>
                                <?php echo $postUserName['user_name']; ?>
                        </a>
                        </address>
                        </a>
                        <div class="pt-6 mx-12">
                            <a class="bg-black w-96 h-96 ">
                                <img class="object-cover h-96 w-96 " src="upload/<?php echo $post['photo']; ?>">
                            </a>
                        </div>
                        <h3 class="pt-6 text-xl">
                            <time datetime='2020-02-01'>
                                <?php echo $post['date']; ?>
                            </time>
                        </h3>
                        <div class="pt-6 text-xl">
                            <p>
                                <?php echo $post['description']; ?>
                            </p>
                            <!-- Include likes button -->
                            <?php include('likebutton.php'); ?>
                        </div>

                    </article>
                <?php } ?>


            </main>
        </div>
    </div>
    </div>
</body>

</html>