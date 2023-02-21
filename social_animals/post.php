<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link href="output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-yellow-50">
    <?php
    include('header.php');
    ?>
    <div class="flex">
        <?php
        include('typecol.php');
        ?>
        <div id="pageContent">
            <main>
                <article>
                <?php
                $connectedUserId = $_SESSION['connected_id'];
                $laQuestionEnSql = "
                        SELECT posts.description, posts.date, posts.photo, users.name, users.id, posts.id, 
                        FROM posts
                        JOIN users ON  users.id=posts.user_id
                        LEFT JOIN likes      ON likes.post_id  = posts.id 
                        WHERE followers.following_user_id='$connectedUserId' 
                        GROUP BY posts.id
                        ORDER BY posts.created DESC  
                        ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (!$lesInformations) {
                    echo ("Échec de la requete : " . $mysqli->error);
                }
                while ($post = $lesInformations->fetch_assoc()) {
                    
                    if(isset($_POST['type']))
                    {
                       foreach($_POST['type'] as $value)
                       {
                          echo $value ;
                       }
                    }
                    
                    ?>
                    <a>
                        <address>By
                            <?php echo $post['user_name']; ?>
                        </address>
                    </a>
                    <div> 
                        <a>
                            <?php echo $post['photo']; ?>
                        </a>
                    </div>
                    <h3>
                        <time datetime="Y-m-d\\TH:i:sP">
                            <?php echo $post['date']; ?>
                        </time>
                    </h3>
                    <div>
                        <p>
                            <?php echo $post['description']; ?>
                        </p>
                    </div>
                <?php
                } ?>        
                </article>
            </main>
        </div>
    </div>
</body>

</html>
