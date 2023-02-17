<?php
session_start();
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
$connectedUser = $_SESSION['connected_id'];
?>