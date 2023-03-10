<?php
include('connect.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: feed.php?user_id=' . $_SESSION['connected_id']);
}

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Flux</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div id="wrapper">
        <?php

        $userId = intval($_GET['user_id']);
        ?>
        <?php

        $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
        ?>

        <aside>
            <?php

            $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            ?>
            <img src="images/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message des utilisatrices
                    auxquel est abonnée l'utilisatrice
                    <?php echo $user['alias'] ?>
                </p>

            </section>
        </aside>
        <main>
            <?php

            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    users.id as id_num,  
                    posts.id as id_post,
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM followers 
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE followers.following_user_id='$userId' 
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
                    <a href="wall.php?user_id=<?php echo $post['id_num'] ?>">
                        <address>Par
                            <?php echo $post['author_name']; ?>
                        </address>
                    </a>
                    <div>
                        <p>
                            <?php echo $post['content']; ?>
                        </p>
                    </div>
                    <footer>
                        <?php
                        include("likes.php");
                        if (!$liked) { ?>
                            <form method="post" action='feed.php?user_id=<?php echo $connectedUser; ?>'>
                                <input type="submit" name=<?php echo $postId ?> value="♥ <?php
                                    echo $post['like_number']; ?>">
                            </form>
                        <?php
                        } else { ?>
                            <small>♥
                                <?php echo $post['like_number']; ?>
                            </small>
                        <?php } ?>
                        <?php
                        if (isset($post['taglist'])) {
                        $tagArray = explode(',', $post['taglist']);
                        $i = 0;
                        while ($i < count($tagArray)) {
                            $tag = $tagArray[$i];
                            $tagRequest = "SELECT tags.id as id_tag from tags WHERE tags.label = '$tag'";
                            $infoTag = $mysqli->query($tagRequest);
                            $infoTag = $infoTag->fetch_assoc();
                            $tagId = $infoTag['id_tag'];
                            $_SESSION['id_tag'] = $tagId;
                            ?>
                            <a href="tags.php?tag_id=<?php echo $_SESSION['id_tag'] ?>">#
                                <?php echo $tag; ?>
                            </a>
                            <?php $i++;
                        } } ?>
                    </footer>
                </article>
            <?php
            } ?>
        </main>
    </div>
</body>

</html>