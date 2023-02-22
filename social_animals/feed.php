<?php
include('connect.php');

// Get followed users' posts
$sqlFollowing = "SELECT followed from followers where follower=$connectedUserId";
$sqlQuery = $mysqli->query($sqlFollowing);
$followersData = $sqlQuery->fetch_assoc();
if (isset($followersData)){
    $userFollowed = $followersData['followed'];
    $post = $sqlQuery->fetch_assoc();

    $sqlFollowingPosts = "SELECT posts.ID as ID, posts.photo as posts_photo, posts.date as posts_date, 
    posts.description as posts_description, posts.user_id as user_id, users.type_id as user_type 
    FROM posts JOIN users on users.id=posts.user_id WHERE user_id='$userFollowed' ";
    $sqlQuery2 = $mysqli->query($sqlFollowingPosts);
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
    <div class="flex">
        <?php
        include('typecol.php');
        ?>
        <div class="flex flex-col w-screen justify-center items-center space-y-8">
            <?php include('posteditor.php'); ?>
            <div class="">
                <form action="feed.php" enctype="multipart/form-data" method="post"
                class="flex flex-col items-center bg-orange-100 mt-20 rounded-lg mx-80 py-4 px-8 ">
                    <label for="user_picture" class="bg-orange-200 rounded-full py-2 px-4 mb-4">Share your cutest picture!</label>
                    <input type="file" name="user_picture"/>
                    <textarea name="description" id="" cols="30" rows="2" class="mt-4 rounded-lg">Add a cool description</textarea>
                    <input type="submit" value="Post"
                        class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mt-4">
                </form>
            </div>
            <div id="posts" class="space-y-8">

                <!-- Followed users' posts -->
                
                <?php 
                // If no animal type is selected
                if (isset($followersData)){
                  if(count($checkedTypes) == 0){ 
                    while ($post = $sqlQuery2->fetch_assoc()) { ?>
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
                    <?php              
                    } 

                    // If types are selected
                }else {
                    foreach ($checkedTypes as $userType){
                        if ($post['user_type'] != $userType) {
                            echo "You don't follow this type";
                        } 
                        if ($post['user_type'] == $userType) { 
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

                 <?php } 
                }
            }       
        } 

            ?>
            </div>
        </div>
    </div>




</body>

</html>