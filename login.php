<?php
include('connect.php');
$isConnected = false;
$enCoursDeTraitement = isset($_POST['email']);
if ($enCoursDeTraitement) {
    $emailAVerifier = $_POST['email'];
    $passwdAVerifier = $_POST['motpasse'];

    $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
    $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
    // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
    $passwdAVerifier = md5($passwdAVerifier);
    // NB: md5 est pédagogique mais n'est pas recommandée pour une vraie sécurité
    //Etape 5 : construction de la requete
    $lInstructionSql = "SELECT * FROM users WHERE email LIKE '$emailAVerifier' ";
    // Etape 6: Vérification de l'utilisateur
    $res = $mysqli->query($lInstructionSql);
    $user = $res->fetch_assoc();
    if (!$user or $user["password"] != $passwdAVerifier) {
        echo "La connexion a échoué. ";

    } else {
        echo "Votre connexion est un succès : " . $user['alias'] . ".";
        $_SESSION['connected_id'] = $user['id'];
        $isConnected = true;
    }
}

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Connexion</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php
    include('header.php');

    ?>

    <div id="wrapper">
        <aside>
            <h2>Présentation</h2>
            <p>Bienvenue sur notre réseau social.</p>
        </aside>
        <main>
            <article>
                <h2>Connexion</h2>
                <p>
                    <?php if ($isConnected) {
                        echo "Tues connecté : " . $user['alias'];
                    } ?>
                </p>

                <form action="login.php" method="post">
                    <dl>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email'></dd>
                        <dt><label for='motpasse'>Mot de passe</label></dt>
                        <dd><input type='password' name='motpasse'></dd>
                    </dl>
                    <input type='submit'>
                </form>
                <p>
                    Pas de compte?
                    <a href='registration.php'>Inscrivez-vous.</a>
                </p>

            </article>
        </main>
    </div>

</body>

</html>