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
            <div id="posts" class="space-y-8">
                <?php
                $userID = $_SESSION['connected_id'];
                $sqlFollowing = "SELECT followed from followers where follower=$userID";
                $sqlQuery = $mysqli->query($sqlFollowing);
                $followersData = $sqlQuery->fetch_assoc();
                $userFollowed = $followersData['followed'];

                $sqlFollowingPosts = "SELECT ID as posts_id, photo as posts_photo, date as posts_date, description  as posts_description, user_id FROM posts WHERE user_id='$userFollowed'";
                $sqlQuery2 = $mysqli->query($sqlFollowingPosts);

                while ($post = $sqlQuery2->fetch_assoc()) {
                    ?>
                    <article class="flex flex-col items-center border-black border-2 bg-lime-50 space-x-8 ">
                        <p>
                            <?php echo $post['posts_date'] ?>
                        </p>
                        <p>
                            <?php
                            $followerId = $post['user_id'];
                            $sqlUserName = "SELECT name FROM users WHERE users.ID = $followerId";
                            $sqlQuery3 = $mysqli->query($sqlUserName);
                            $followerFinalName = $sqlQuery3->fetch_assoc();
                            echo $followerFinalName['name'] ?>
                        </p>
                        <div class="bg-black w-96 h-96">
                            <img class="object-cover h-96 w-96"
                                src="<?php echo 'upload/' . $post['posts_photo'] ?>">
                        </div>

                        <p>
                            <?php echo $post['posts_description'] ?>
                        </p>
                            <?php inlude('like.php') ?>
                        </form>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>




</body>

</html>