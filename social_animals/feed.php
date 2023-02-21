<?php 
include('connect.php');

// Refresh page when button like is cliked
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     header('Location: feed.php');
//     }

// Get followed users' posts
$sqlFollowing = "SELECT followed from followers where follower=$connectedUserId";
$sqlQuery = $mysqli->query($sqlFollowing);
$followersData = $sqlQuery->fetch_assoc();
$userFollowed = $followersData['followed'];
$post = $sqlQuery->fetch_assoc();

$sqlFollowingPosts = "SELECT ID as ID, photo as posts_photo, date as posts_date, description  as posts_description, user_id FROM posts WHERE user_id='$userFollowed' ";
$sqlQuery2 = $mysqli->query($sqlFollowingPosts);


// Send SQL request to like/unlike post
include('like.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-yellow-50">
    <?php
    include('header.php');
    ?>
    <div class="flex">
        <?php
        include('typecol.php');
        ?>
        <div class="flex flex-col w-screen justify-center items-center space-y-8">
            <?php include('posteditor.php'); ?>
            <div class="">
                <form action="feed.php" enctype="multipart/form-data" method="post"
                    class="flex flex-col space-y-2 space-x-8 justify-center items-center border-black border-2 bg-lime-50 mt-4">
                    <label for="user_picture" class="mt-2">Choose a picture</label>
                    <input type="file" name="user_picture" />
                    <p>Add a description</p>
                    <textarea name="description" id="" cols="30" rows="2"></textarea>
                    <input type="submit" value="Post"
                        class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                </form>
            </div>
            <div id="posts" class="space-y-8">

            <!-- Followed users' posts -->
                <?php while ($post = $sqlQuery2->fetch_assoc()) {
                    ?>
                    <article class="flex flex-col items-center border-black border-2 bg-lime-50 space-x-8 ">
                        <p>
                            <?php echo $post['posts_date'] ?>
                        </p>
                        <p>
                            <?php // Get follower's name
                            $followerId = $post['user_id'];
                            $sqlUserName = "SELECT name FROM users WHERE users.ID = $followerId";
                            $sqlQuery3 = $mysqli->query($sqlUserName);
                            $followerFinalName = $sqlQuery3->fetch_assoc();
                            echo $followerFinalName['name'] ?>
                        </p>
                        <div class="bg-black w-96 h-96">
                            <img class="object-cover h-96 w-96" src="<?php echo 'upload/' . $post['posts_photo'] ?>">
                        </div>

                        <p>
                            <?php echo $post['posts_description'] ?>
                        </p>
                        <!-- Include likes button -->
                            <?php include('likebutton.php'); ?>
                        </form>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>




</body>

</html>