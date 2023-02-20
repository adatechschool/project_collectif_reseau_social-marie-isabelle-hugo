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

    // echo $passwordToCheck;


    $connectionRequest = "SELECT * FROM users WHERE email LIKE '$passwordToCheck' ";

    // Checking fo an email/password match in DB
    $res = $mysqli->query($connectionRequest);
    $user = $res->fetch_assoc();

    // echo "to check : " . $emailToCheck . $passwordToCheck;
    // echo var_dump($user);
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

<body class="bg-yellow-50">
    <main>
        <article class="flex flex-col space-y-4 h-screen justify-center items-center">
            <h1 class="text-4xl">Welcome to Social Animals</h1>
            <div id='logo-container'>
                <image src="images/logo.png" alt="pets logo" id="logo" width=200px class="animate-bounce"></image>
            </div>
            <h2 class="text-2xl">Connexion</h2>

            <form action="index.php" method="post" class="flex flex-col justify-center items-center space-y-4">
                <dl class="flex flex-col justify-center items-center ">
                    <dt><label for='email'>E-mail</label></dt>
                    <dd><input type='email' name='email'></dd>

                    <dt><label for='motpasse'>Password</label></dt>
                    <dd><input type='password' name='password'></dd>
                </dl>
                <input type='submit' class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
            </form>
            <p>
                Not a member yet?
                <a href='registration.php' class="underline hover:text-blue">Create an
                    account!</a>
            </p>
            <?php if ($connectionForm) {
                if (!$user or $user["password"] != $passwordToCheck) { ?>
                    <p>
                        <?php echo "Wrong ID or password, try again."; ?>
                    </p>
                <?php
                } else { ?>
                    <p>
                        <?php echo "Welcome back, " . $user['alias'] . "!"; ?>
                    </p>
                    <?php
                    $_SESSION['connected_id'] = $user['id'];
                    $isConnected = true;
                }
            } ?>

        </article>
    </main>
</body>

</html>