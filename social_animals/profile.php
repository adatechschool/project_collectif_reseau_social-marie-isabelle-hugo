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
            <div>
                <main>
                    <?php
                    $userId = $_SESSION['connected_id'];
                    $laQuestionEnSql = " 
                                SELECT * FROM users
                                WHERE users.id = '$userId' 
                                ";
                    $lesInformations = $mysqli->query($laQuestionEnSql);
                    if (!$lesInformations) {
                        echo ("Échec de la requete : " . $mysqli->error);
                    }
                    $user = $lesInformations->fetch_assoc();
                    ?>
                    <article id='viewProfile'>
                        <h3>viewProfile</h3>
                        <dl>
                            <dt>Photo</dt>
                            <dd>
                                <?php echo $user['photo']; ?>
                            </dd>
                            <dt>Nom</dt>
                            <dd>
                                <?php echo $user['name']; ?>
                            </dd>
                            <dt>Type d'animal</dt>
                            <dd>
                                <?php echo $user['type_id']; ?>
                            </dd>
                            <dt>Email</dt>
                            <dd>
                                <?php echo $user['email']; ?>
                            </dd>
                        </dl>
                    </article>
                    <article id='myPost'>
                        <p>Create a new post</label><br />
                            <input type="file" name="file" id="file" />
                            <textarea name="create_post" id="create_post" cols="100" rows="6" wrap="hard"></textarea>
                            <input type='submit'>
                        </p>

                        <h3>viewPost</h3>

                    </article>
                </main>
            </div>
        </div>
    </div>




</body>

</html>