<!-- utilisatrice non connectée -->
<?php if (!isset($_SESSION['connected_id'])){ ?>
<header>
    <a><img src="images/resoc.jpg" alt="Logo de notre réseau social" /></a>
    <nav id="menu">
        <a href="login.php">Connexion</a>
        <a href="registration.php">Inscription</a>
    </nav>
</header>

<!-- si utilisatrice connectée -->
<?php } else { ?>

<header>
    <a href='admin.php'><img src="images/resoc.jpg" alt="Logo de notre réseau social" /></a>
    <nav id="menu">
        <a href="news.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Actualités</a>
        <a href="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mur</a>
        <a href="feed.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Flux</a>
        <?php if (isset($_SESSION['id_tag'])){ ?>
            <a href="tags.php?tag_id=<?php echo $_SESSION['id_tag'] ?>">Mots-clés</a>
        <?php } ?>

    </nav>
    <nav id="user">
        <a href="#">▾ Profil</a>
        <ul>
            <li><a href="settings.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Paramètres</a></li>
            <li><a href="followers.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes suiveurs</a></li>
            <li><a href="subscriptions.php?user_id=<?php echo $_SESSION['connected_id'] ?>">Mes abonnements</a></li>
            <li><a href="index.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<?php } ?>