<?php
include 'Conn.php';
$id = $_GET['booking_id'];
$queue = "DELETE FROM Movie WHERE `Movie`.`booking_id` = $id";
$query = mysqli_query($conn, $queue);
header('location:Display.php');
?>

<html>
<head>
<title> deleting record </title>
</head>
</html>