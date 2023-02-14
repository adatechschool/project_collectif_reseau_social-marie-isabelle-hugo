<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnés </title>
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
                $userId = intval($_GET['user_id']);
                $laQuestionEnSql2 = "SELECT alias FROM users WHERE users.id = $userId";
                $lesInformations2 = $mysqli->query($laQuestionEnSql2);
                $name = $lesInformations2->fetch_assoc();
                ?>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez la liste des personnes qui
                    suivent les messages de l'utilisatrice
                    <?php echo $name['alias'] ?>
                </p>
            </section>
        </aside>
        <main class='contacts'>
            <?php
            // Etape 1: récupérer l'id de l'utilisateur
            
            // Etape 3: récupérer le nom de l'utilisateur
            $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.following_user_id
                    WHERE followers.followed_user_id='$userId'
                    GROUP BY users.id
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Etape 4: à vous de jouer
            //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
            ?>
            <?php
            while ($post = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <img src="images/user.jpg" alt="blason" />
                    <h3>
                        <?php echo $post['alias']; ?>
                    </h3>
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