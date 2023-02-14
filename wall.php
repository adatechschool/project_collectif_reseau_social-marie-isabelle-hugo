<?php
include('connect.php');
$userId = intval($_GET['user_id']);
$connectedUser = intval($_SESSION['connected_id']);

// Si le mur est celui de l'utilisatrice
if (intval($userId) === intval($connectedUser)) {

    $postIncoming = isset($_POST['new_post']);
    date_default_timezone_set('Europe/Paris');
    $postDate = date('Y-m-d H:i:s');

    if ($postIncoming) {
        $newPost = $_POST['new_post'];
        $lInstructionSql = "INSERT INTO posts (id, user_id, content, created) 
                    VALUES (NULL, '$userId', '$newPost', '$postDate');";

        $ok = $mysqli->query($lInstructionSql);

        if (!$ok) {
            echo "Le post n'a pas été enregistré, veuillez recommencez." . $mysqli->error;
        }
    }


    // Si le mur est celui d'une autre utilisatrice, possibilité de la suivre/ne plus la suivre

} else {



    // Si l'utilistratice est déjà suivie, possibilité de ne plus suivre

    if (isset($_POST['unsubscribe'])) {
        $deleteRequest = "DELETE FROM followers WHERE following_user_id = '$connectedUser' AND followed_user_id = '$userId' ";

        $ok = $mysqli->query($deleteRequest);

        if (!$ok) {
            ?>
            <p> Erreur, veuillez recommencez.
                <?php echo $mysqli->error; ?>
            </p>
        <?php
        }
    }
    // Si utilisatrice non suivie, possibilité de suivre

    if (isset($_POST['subscribe'])) {

        $insertRequest = "INSERT INTO followers (id, followed_user_id, following_user_id) 
                VALUES (NULL, $userId, $connectedUser);";

        $ok = $mysqli->query($insertRequest);
        if (!$ok) {
            ?>
            <p> Erreur, veuillez recommencez.
                <?php echo $mysqli->error; ?>
            </p>
        <?php
        }
    }
    $isFollowedRequest = "SELECT * FROM followers WHERE following_user_id= '$connectedUser' AND followed_user_id = '$userId' ";
    $isFollowedInfos = $mysqli->query($isFollowedRequest);
    $isFollowed = $isFollowedInfos->fetch_assoc();
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    include('header.php');

    ?>

    <div id="wrapper">
        <!-- Menu de côté -->
        <aside>
            <?php
            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            ?>
            <img src="images/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice :
                    <?php echo $user['alias']; ?>
                </p>
            </section>
        </aside>

        <!-- Content de la page -->
        <main>
            <!-- Si le mur est celui de l'utilisatrice : possibilité de poster un statut -->
            <?php
            if (intval($userId) === intval($_SESSION['connected_id'])) {
                ?>
                <form method="post" action="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">
                    <p>Que souhaitez-vous partager ?</label><br />
                        <textarea name="new_post" id="new_post" cols="100" rows="6" wrap="hard"></textarea>
                        <input type='submit'>
                    </p>
                </form>


            <?php
                // Si le mur est celui d'une autre utilisatrice, possibilité de la suivre/ne plus la suivre
            } else {
                if ($isFollowed) {
                    ?>
                    <p> Vous suivez cette utilisatrice </p>
                    <form method="post" action="wall.php?user_id=<?php echo $userId ?>">
                        <input type='submit' name='unsubscribe' value='Ne plus suivre cette utilisatrice'>
                    </form>

                <?php

                    // Si utilisatrice non suivie, bouton "suivre"
                } else {
                    ?>
                    <form method="post" action="wall.php?user_id=<?php echo $userId ?>">
                        <input type='submit' name='subscribe' value='Suivre cette utilisatrice'>
                    </form>
                <?php
                }
            }


            /**
             * Etape 3: récupérer tous les messages de l'utilisatrice
             */
            $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, users.id as id_num,
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            while ($post = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <h3>
                        <time datetime='2020-02-01 11:12:13'>
                            <?php echo $post['created']; ?>
                        </time>
                    </h3>
                    <address>Par
                        <a href="wall.php?user_id=<?php echo $post['id_num'] ?>"><?php echo $post['author_name']; ?></a>
                    </address>
                    <div>
                        <p>
                            <?php echo $post['content']; ?>
                        </p>
                    </div>
                    <footer>
                        <small>♥
                            <?php echo $post['like_number']; ?>
                        </small>
                        <a href="">
                            <?php echo $post['taglist'] ?>
                        </a>
                    </footer>
                </article>
            <?php } ?>
        </main>
    </div>
</body>

</html>