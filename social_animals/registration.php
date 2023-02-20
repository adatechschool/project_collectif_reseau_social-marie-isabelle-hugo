<?php
    include('connect.php');

    // If email field isn't empty
        if (!empty($_POST['email'])) {
            $new_alias = $_POST['user_name'];
            $new_type = $_POST['type'];
            $new_pic = $_FILES['user_picture'];
            $new_email = $_POST['email'];
            $new_passwd = $_POST['password'];

            // getting the image's properties via the $_FILES variable
            $tmpName = $_FILES['user_picture']['tmp_name'];
            $imageName = $_FILES['user_picture']['name'];
            $size = $_FILES['user_picture']['size'];
            $error = $_FILES['user_picture']['error'];  

            // getting the image's extension
            $getExtension = explode(".", $imageName);
            $extension = strtolower(end($getExtension));

            // generating a unique name for each profile picture
            $uniqueName = uniqid('', true);
            $imageName = $uniqueName . "." . $extension;

            // move image to folder
            move_uploaded_file($tmpName, './upload/'.$imageName);
                    
         //    security against SQL injections
            $new_email = $mysqli->real_escape_string($new_email);
            $new_alias = $mysqli->real_escape_string($new_alias);
            $new_type = $mysqli->real_escape_string($new_type);
            $new_passwd = $mysqli->real_escape_string($new_passwd);
            
            // sha256 hash for password safety
            $new_passwd = hash('sha256', $new_passwd);

            // getting the type ID
            $typeIDRequest = "SELECT ID as type_id, label as type_label FROM type WHERE label = '$new_type' ";
            $getType = $mysqli->query($typeIDRequest);
            $type_idArray = $getType->fetch_assoc();
            $type_id = $type_idArray["type_id"];

            // // SQL request to create user in DB
            $createUserRequest = "INSERT INTO users (id, name, email, password, type_id, photo) 
                VALUES (NULL, '$new_alias', '$new_email', '$new_passwd', '$type_id', '$imageName')" ;

            $userRequestResponse = $mysqli->query($createUserRequest);
            
        }

        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Animals, your pet's social network!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>


<main>
            <article>
                <h2>Create your account</h2>
               


                <!-- Registration fields  -->
                <form enctype="multipart/form-data" action="registration.php" method="post">

                    <dl>
                        <dt><label for='user_name'>Pseudo</label></dt>
                        <dd><input type='text' name='user_name'></dd>
     
                        <dt><label for="type">Animal type</label></dt>
                        <dd><select name="type" id="type">
                                <option value="cat">Cat</option>
                                <option value="dog">Dog</option>
                                <option value="hamster">Hamster</option>
                                <option value="chinchilla">Chinchilla</option>                                
                                <option value="other-mammal">Other mammal</option>
                                <option value="bird">Bird</option>
                                <option value="snake">Snake</option>
                                <option value="other-reptile">Other reptile</option>
                            </select></dd>

                         
                        <dt><label for="user_picture">Choose a picture</label></dt>
                        <dd><input type="hidden" name="MAX_FILE_SIZE" value="250000" />
                                <input type="file" name="user_picture"/></dd>

                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email'></dd>

                        <dt><label for='password'>Password</label></dt>
                        <dd><input type='password' name='password'></dd>
                    </dl>
                    <input type='submit'>
                </form>
            </article>

            <!--  Confirmation of registration -->
            <?php if (!$userRequestResponse) {
                        echo "Error : " . $mysqli->error;
                    } else {
                        echo "You're now a member of Social Animals, " . $new_alias . " !"; ?> 
                        <a href='index.php'>You can now log in.</a>";
                    <?php } ?>

        </main>
    
</body>
</html>