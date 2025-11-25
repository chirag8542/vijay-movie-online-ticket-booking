<?php
include 'Conn.php';

if (isset($_POST['done'])) {

  $id = $_GET['booking_id'];
  $booking_name = $_POST['booking_name'];
  $booking_date = $_POST['booking_date'];
  $no_of_tickets= $_POST['no_of_tickets'];
  $price= $_POST['price'];

  $queue = "UPDATE Movie SET 
  booking_name='$booking_name',
  booking_date='$booking_date',
  no_of_tickets='$no_of_tickets',
  price='$price'
  WHERE booking_id='$id'";

  $query = mysqli_query($conn, $queue);
  header('location:Display.php');
}
?>

<html>
<head>
  <title>Update Booking</title>

  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="update.css">
</head>

<body>

<div class="container">
    <form method="post">
        <div class="title">Update Ticket Booking</div>

        <div class="input-box">
            <i class="fa-solid fa-user icon"></i>
            <input type="text" name="booking_name" placeholder="Enter Booking Name" required>
        </div>

        <div class="input-box">
            <i class="fa-solid fa-calendar icon"></i>
            <input type="date" name="booking_date" required>
        </div>

        <div class="input-box">
            <i class="fa-solid fa-ticket icon"></i>
            <input type="number" name="no_of_tickets" placeholder="Enter No. of Tickets" required>
        </div>

        <div class="input-box">
            <i class="fa-solid fa-dollar-sign icon"></i>
            <input type="number" name="price" placeholder="Enter Price" required>
        </div>

        <div class="input-box button">
            <input type="submit" name="done" value="Update Booking">
        </div>
    </form>
</div>

</body>
</html>
