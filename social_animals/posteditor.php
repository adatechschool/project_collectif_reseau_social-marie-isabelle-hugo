<?php
if (isset($_POST['description'])) {
    date_default_timezone_set('Europe/Paris');
    $postDate = date('Y-m-d');
    $description = $_POST['description'];
    $userID = $_SESSION['connected_id'];

    $tmpName = $_FILES['user_picture']['tmp_name'];
    $imageName = $_FILES['user_picture']['name'];

    $getExtension = explode(".", $imageName);
    $extension = strtolower(end($getExtension));


    $uniqueName = uniqid('', true);
    $imageName = $uniqueName . "." . $extension;

    move_uploaded_file($tmpName, './upload/' . $imageName);

    $createPOST = "INSERT INTO posts (id, photo, description, date, user_id) 
                VALUES (NULL, '$imageName', '$description', '$postDate', $userID)";

    $sendingPost = $mysqli->query($createPOST);
}

?>