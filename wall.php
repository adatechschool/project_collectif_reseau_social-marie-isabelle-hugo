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
    include('connect.php');
    ?>
    <div id="wrapper">
        <?php
        $userId = intval($_GET['user_id']);
        ?>

        <aside>
            <?php
            /**
             * Etape 3: récupérer le nom de l'utilisateur
             */
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
        <?php
        $enCoursDeTraitement = isset($_POST['text']);
        if ($enCoursDeTraitement) {
            $newContent = $_POST['text'];

            $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                . "VALUES (NULL, "
                . "'" . $new_email . "', "
                . "'" . $new_passwd . "', "
                . "'" . $new_alias . "'"
                . ");";


        }
        ?>
        <main>

            <form method="post" action="wall.php?user_id=<?php echo $_SESSION['connected_id'] ?>">
                <p>Que souhaitez-vous partager ?</label><br />
                    <textarea name="new_post" id="new_post" cols="100" rows="6" wrap="hard"></textarea>
                    <input type='submit'>
                </p>
            </form>

            <?php $enCoursDeTraitement = isset($_POST['new_post']);

            // récupérer la date
            date_default_timezone_set('Europe/Paris');
            $postDate = date('Y-m-d H:i:s');

            if ($enCoursDeTraitement) {
                $newPost = $_POST['new_post'];

                $lInstructionSql = "INSERT INTO posts (id, user_id, content, created) 
                        VALUES (NULL, '$userId', '$newPost', '$postDate');";

                // Etape 6: exécution de la requete
                $ok = $mysqli->query($lInstructionSql);
                if (!$ok) {
                    echo "Le post n'a pas été enregistré, veuillez recommencez." . $mysqli->error;
                }
            }


            ?>

            <?php
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