<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnements</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    include('header.html');
    include('connect.php');
    ?>
    <div id="wrapper">
        <aside>
            <img src="images/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: récupérer le nom de l'utilisateur
                $getID = "SELECT alias FROM users WHERE users.id LIKE '$userId' ";
                $setID = $mysqli->query($getID);
                $authorID = $setID->fetch_assoc();
                ?>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes que
                    l'utilisatrice
                    <?php echo $authorID['alias'] ?>
                    suit
                </p>
            </section>
        </aside>
        <main class='contacts'>
            <?php
            // Etape 1: récupérer l'id de l'utilisateur
            // $userId = intval($_GET['user_id']);
            // Etape 3: récupérer le nom de l'utilisateur
            $laQuestionEnSql = "
                    SELECT users.* 
                    FROM followers 
                    LEFT JOIN users ON users.id=followers.followed_user_id 
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Etape 4: à vous de joue
            while ($post = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <img src="images/user.jpg" alt="blason" />

                    <a href="wall.php?user_id=<?php echo $post['id']; ?>">
                        <h3>
                            <?php echo $post['alias']; ?>
                        </h3>
                    </a>
                    <p>
                        id :
                        <?php echo $post['id']; ?>
                    </p>
                </article>
            <?php
            } ?>
        </main>
    </div>
</body>

</html>