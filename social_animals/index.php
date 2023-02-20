<?php
    include('connect.php');

$isConnected = false;
$connectionForm = isset($_POST['email']);
if ($connectionForm) {
    $emailToCheck = $_POST['email'];
    $passwordToCheck = $_POST['password'];

    $emailToCheckr = $mysqli->real_escape_string($emailToCheck);
    $passwordToCheck = $mysqli->real_escape_string($passwordToCheck);

    // sha256 hash for password safety
    $passwordToCheck = hash('sha256', $passwordToCheck);


    $connectionRequest = "SELECT * FROM users WHERE email LIKE '$passwordToCheck' ";
    
    // Checking fo an email/password match in DB
    $res = $mysqli->query($connectionRequest);
    $user = $res->fetch_assoc();
    if (!$user or $user["password"] != $passwordToCheck) {
        echo "Wrong ID or password, try again.";

    } else {
        //  VERIFIER LA BALISE ALIAS DANS LA REQUETE SQL !!!! 
        echo "Welcome back, " . $user['alias'] . "!";
        $_SESSION['connected_id'] = $user['id'];
        $isConnected = true;

        // Go to wall
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isConnected) {
            header('Location: wall.php?user_id=' . $_SESSION['connected_id']);
        }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Animals, your pet's social network!</title>
</head>
<body>

    <div id='logo-container'>
    <image src="images/logo.jpg" alt="pets logo" id="logo" width=20px></image>
    </div>

    <main>
            <article>
                <h2>Connection</h2>
               
                <form action="index.php" method="post">
                    <dl>
                        <dt><label for='email'>E-mail</label></dt>
                        <dd><input type='email' name='email'></dd>

                        <dt><label for='motpasse'>Password</label></dt>
                        <dd><input type='password' name='password'></dd>
                    </dl>
                    <input type='submit'>
                </form>
                <p>
                    Not a member yet?
                    <a href='registration.php'>Create an account!</a>
                </p>

            </article>
        </main>

    



    

    
</body>
</html>