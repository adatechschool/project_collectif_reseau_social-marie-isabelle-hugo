<?php
include('connect.php');
$sqlRequest = "SELECT * from events";
$sqlEvents = $mysqli->query($sqlRequest);



?>
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
    <div class="flex flex-col space-y-8">
        <?php
        while ($event = $sqlEvents->fetch_assoc()) {
            if (isset($_POST[$event['ID']])) {
                $eventId = $event['ID'];
                $sqlAttend = "INSERT into event_attendees (user_id, event_id)
                VALUES($connectedUserId, $eventId)";
                $sendAttend = $mysqli->query($sqlAttend);
            }
            ?>
            <article class="flex flex-col items-center bg-orange-100 mt-20 rounded-lg mx-80 pb-24 ">
                <p>
                    <?php echo $event['name']; ?>
                </p>
                <p>
                    <?php echo $event['date']; ?>
                </p>
                <p>
                    <?php echo $event['place']; ?>
                </p>
                <form action="" method="post">
                    <input type="submit" name="<?php echo $event['ID'] ?>" value="attend"
                        class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                </form>
            </article>

        <?php }
        ?>


    </div>
</body>

</html>