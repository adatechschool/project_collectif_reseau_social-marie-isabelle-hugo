<?php
include('connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: news.php?user_id=' . $_SESSION['connected_id']);
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php
    include('header.php');
    ?>

    <div id="wrapper">
        <aside>
            <img src="images/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages de
                    tous les utilisatrices du site.</p>
            </section>
        </aside>
        <main>

            <?php
            if ($mysqli->connect_errno) {
                echo "<article>";
                echo ("Échec de la connexion : " . $mysqli->connect_error);
                echo ("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                echo "</article>";
                exit();
            }

            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name, 
                    users.id as id_num, 
                    posts.id as id_post,
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 5
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);

            // Vérification
            if (!$lesInformations) {
                echo "<article>";
                echo ("Échec de la requete : " . $mysqli->error);
                echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                exit();
            }

            while ($post = $lesInformations->fetch_assoc()) {


                ?>
                <article>
                    <h3>
                        <time>
                            <?php echo $post['created'] ?>
                        </time>
                    </h3>
                    <address>Par
                        <a href="wall.php?user_id=<?php echo $post['id_num'] ?>"><?php echo $post['author_name'] ?></a>
                    </address>
                    <div>
                        <p>
                            <?php echo $post['content'] ?>
                        </p>
                    </div>
                    <footer>
                        <?php
                        include("likes.php");
                        if (!$liked) { ?>
                            <form method="post" action='news.php?user_id=<?php echo $_SESSION['connected_id']; ?>'>
                                <input type="submit" name=<?php echo $postId ?> value="♥ <?php
                                    echo $post['like_number']; ?>">
                            </form>
                        <?php
                        } else { ?>
                            <small>♥
                                <?php echo $post['like_number']; ?>
                            </small>
                        <?php } ?>
                        <?php if ($post['taglist']) {
                            $tagArray = explode(',', $post['taglist']);
                            $i = 0;
                            while ($i < count($tagArray)) {
                                ?>
                                <a href="">#
                                    <?php echo $tagArray[$i]; ?>
                                </a>
                                <?php $i++;
                            }

                        } ?>

                    </footer>
                </article>
            <?php } ?>
        </main>
    </div>
</body>

</html>