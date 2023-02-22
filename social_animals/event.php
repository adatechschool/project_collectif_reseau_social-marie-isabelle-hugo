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
    <div class="flex flex-col justify-center">
        <main>
            <?php
            while ($event = $sqlEvents->fetch_assoc()) {
                $eventId = $event['ID'];
                if (isset($_POST[$eventId])) {
                    $sqlAttend = "INSERT into event_attendees (user_id, event_id)
                VALUES ($connectedUserId, $eventId)";
                    $sendAttend = $mysqli->query($sqlAttend);
                }
                ?>
                <article class="flex flex-col items-center bg-orange-100 mt-20 rounded-lg mx-80 pb-24 ">
                    <h1 class="text-2xl">
                        <?php echo $event['name']; ?>
                    </h1>
                    <p>
                        <?php echo $event['date']; ?>
                    </p>
                    <p>
                        <?php echo $event['place']; ?>
                    </p>
                    <p>attendees : </p>
                    <?php
                    $sqlRequestAttendees = "SELECT users.id, users.name as user_name, event_attendees.event_id, event_attendees.user_id from event_attendees
                        JOIN users ON users.id=event_attendees.user_id";
                    $sqlAttendees = $mysqli->query($sqlRequestAttendees);
                    $attended = false;
                    ?>
                    <p>
                        <?php
                        while ($attendee = $sqlAttendees->fetch_assoc()) {

                            if ($attendee['event_id'] === $eventId) {
                                echo $attendee['user_name'] . '  ';
                            }
                            if ($attendee['user_id'] === $connectedUserId && $attendee['event_id'] === $eventId) {
                                $attended = true;
                            }
                        }
                        ?>
                    </p>
                    <?php
                    if ($attended) {
                        ?>
                        <p>Already attending :)</p>
                    <?php
                    } else {
                        ?>
                        <form action="event.php" method="post">
                            <input type="submit" name="<?php echo $eventId ?>" value="attend"
                                class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                        </form>
                    <?php } ?>
                </article>

            <?php }
            ?>

        </main>
    </div>
</body>

</html>