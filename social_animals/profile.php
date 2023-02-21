<?php include ('connect.php');

    // Differenciating the connected user from the wall's owner
    $wallOwnerId = intval($_GET['user_id']);
    $connectedUserId = $_SESSION['connected_id'];

    $myWall = false;
    $otherUsersWall = false;


    // If the user is on their wall, get all their info
    if ($connectedUserId == $wallOwnerId) {
        $userInfosRequest = "SELECT * FROM users WHERE users.id = '$connectedUserId'  ";
        $getUserInfos = $mysqli->query($userInfosRequest);
        if (!$getUserInfos) {
            echo ("Échec de la requete : " . $mysqli->error);
            }
        $user = $getUserInfos->fetch_assoc(); 

        // If the user is browsing another user's wall, get this user's info
        } else {
        $userInfosRequest = "SELECT * FROM users WHERE users.id = '$wallOwnerId'  ";
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
    $userId = intval($user['ID']);
    $userPostsRequest = "SELECT * FROM posts WHERE posts.user_id = '$userId' ";
    $getUserPosts = $mysqli->query($userPostsRequest);
    if (!$getUserPosts) {
        echo ("Échec de la requete : " . $mysqli->error);
        }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social animals</title>
    <link href="output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-yellow-50">
    <?php
    include('header.php');
    ?>
    <div class="flex flex-col">
        <?php
        // --------------- Créer colonne de côté ----------------------
        ?>
        <div id="pageContent">
            <div>
                <main class="flex flex-col">


                <!-- User's informations -->
                    <div id="userDetails" class="flex justify-center items-center space-x-4">
                        <!-- <div id="pictureContainer" class="w-30 h-30 rounded-full"> -->
                            <img class="object-cover object-center w-40 h-40 rounded-full" src="upload/<?php echo $user['photo'] ?>" alt="Profile picture">
                            <div> <?php echo $user['name']; ?> </div>
                            <div><?php echo $userType["label"];?></div>
                            <div><?php echo $user["email"];?></div>
                    </div>



                <!-- New post form if user is on their wall -->
                <?php if ($myWall == true){

                    // ------------- insertion du formulaire new post -----------------

                } ?>
                

                <!-- User's older posts -->
                <!---------------- CSS A FAIRE  ------------>
                <article id='users-posts'>
                
                <?php while ($post = $getUserPosts->fetch_assoc()) {
                ?>
                <article>
                    <h3>
                        <time datetime='2020-02-01'>
                            <?php echo $post['date']; ?>
                        </time>
                    </h3>
                    <div>
                    <div id='image-container' class="w-64 h-64">
                        <img src="upload/<?php echo $post['photo']; ?>" alt="post image" class="object-cover w-64 h-64 rounded-xl">
                    </div>  
                    <div> <?php echo $post['description']; ?>
                    </div> 
                    
                    <?php include('like.php'); ?>


                </article>
                <?php } ?>


                </main>
            </div>
        </div>
    </div>




</body>

</html>