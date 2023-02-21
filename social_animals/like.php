<?php 
if (isset($_POST['getPostId'])){

    // variable set
    $postId = $_POST['getPostId'];

    if(isset($_POST["like"])){
            $insertLikeRequest = "INSERT INTO likes (user_id, post_id) VALUES ($connectedUserId, $postId) ";
            $ok = $mysqli->query($insertLikeRequest);
            if (!$ok) {
                echo "Error :" . $mysqli->error;
                }
        };

    if (isset($_POST["unlike"])){
            $removeLikeRequest = "DELETE FROM likes WHERE user_id = $connectedUserId AND post_id = $postId";
            var_dump($removeLikeRequest);
            $ok = $mysqli->query($removeLikeRequest);
            if (!$ok) {
                echo "Error :" . $mysqli->error;
            }
        };

    ?>

<?php } ?>
