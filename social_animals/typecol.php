<?php
include('connect.php');
$typeRequest = "SELECT label as type_label, id as type_id FROM type";
$quer = $mysqli->query($typeRequest);
?>
<div class="bg-orange-100 h-screen w-48">
    <aside class="mt-12 mx-8">
        <ul>
            <?php
            while ($type = $quer->fetch_assoc()) {
                ?>
                <div class="flex items-center mb-8">
                    <input id="<?php echo $type['type_id'] ?>" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 dark:text-gray-300">
                        <?php echo $type['type_label'] ?>
                    </label>
                </div>
            <?php }
            ?>

        </ul>
    </aside>
</div>