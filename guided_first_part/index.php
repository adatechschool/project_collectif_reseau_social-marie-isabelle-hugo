<?php session_start();
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork"); 

// Déconnexion de l'utilisatrices
$_SESSION['connected_id'] = NULL; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ReSoC - Connexion</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php include ('header.php'); ?>
    
</body>
</html>

