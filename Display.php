<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Booking Records</title>
  <link rel="stylesheet" href="display.css">
</head>

<body>
  <div class="container">
    <?php
    $showBackButton = true; // enable back button
    include 'components/header.php';
    include 'components/movie-table.php';
    include 'components/footer.php';
    ?>
  </div>
</body>
</html>
