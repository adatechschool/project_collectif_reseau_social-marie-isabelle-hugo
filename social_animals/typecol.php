<?php
$typeRequest = "SELECT label as type_label, id as type_id FROM type";
$quer = $mysqli->query($typeRequest);

// get actual page URL for refresh
$actualPageUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Creating an array of checked type boxes
$checkedTypes = [];

// Getting the value of the checked boxes
if (isset($_POST['types'])) {
    $checkedTypes = $_POST['types'];
}

// Reset choices to get all posts
if (isset($_POST['resetChoices'])) {
    $checkedTypes = [];
}
?>



<div class="bg-orange-100 h-screen w-48">
    <aside class="mt-12 mx-8 space-y-4">
        <form method="post" action='<?php echo $actualPageUrl ?>'>
            <ul>
                <?php
                while ($type = $quer->fetch_assoc()) {
                    ?>
                    <div class="flex items-center mb-8">
                        <input type="checkbox" name="types[]" value="<?php echo $type['type_id'] ?>"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox" class="ml-2 dark:text-gray-300">
                            <?php echo $type['type_label'] ?>
                        </label>
                    </div>
                <?php } ?>
            </ul>
            <input type="submit" name="getPostsByType" value="Show selection"
                class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
        </form>
        <form method="post" action='<?php echo $actualPageUrl ?>'>
            <input type="submit" name="resetChoices" value="Reset choices"
                class="bg-orange-300 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
        </form>
    </aside>
</div>