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
    echo $extension;

    $uniqueName = uniqid('', true);
    $imageName = $uniqueName . "." . $extension;
    echo $imageName;

    move_uploaded_file($tmpName, './upload/' . $imageName);

    $createPOST = "INSERT INTO posts (id, photo, description, date, user_id) 
                VALUES (NULL, '$imageName', '$description', '$postDate', $userID)";

    $sendingPost = $mysqli->query($createPOST);
}

?>
<div class="">
    <form action="posteditor.php" enctype="multipart/form-data" method="post"
        class="flex flex-col space-y-2 space-x-8 justify-center items-center border-black border-2 bg-lime-50 mt-4">
        <label for="user_picture" class="mt-2">Choose a picture</label>
        <input type="file" name="user_picture" />
        <p>Add a description</p>
        <textarea name="description" id="" cols="30" rows="2"></textarea>
        <input type="submit" value="Post"
            class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">

    </form>
</div>