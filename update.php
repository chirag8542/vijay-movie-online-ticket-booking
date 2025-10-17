<?php
include 'Conn.php';

if (isset($_POST['done'])) {

  $id = $_GET['booking_id'];
  $booking_name = $_POST['booking_name'];
  $booking_date = $_POST['booking_date'];
  $no_of_tickets= $_POST['no_of_tickets'];
  $price= $_POST['price'];
  $queue = " UPDATE Movie SET 
  booking_name='$booking_name', booking_date='$booking_date',no_of_tickets='$no_of_tickets',price='$price'  where booking_id='$id'";
  $query = mysqli_query($conn, $queue);
  header('location:Display.php');
}
?>
<html>
<head>
  <title> Registration Form </title>
  <link rel="stylesheet" href="insert.css" />
</head>
<body>
  <div class="container">
    <form method="post">
      <div class="title">Update Ticket Booking</div>
      <div class="input-box">
        <input type="text" name="booking_name" placeholder="Enter Booking Name">
        <div class="underline"></div>
      </div>
      <div class="input-box">
        <input type="date" name="booking_date" placeholder="Enter Booking Date">
        <div class="underline"></div>
      </div>
      <div class="input-box">
        <input type="text" name="no_of_tickets" placeholder="Enter No.of Tickets">
        <div class="underline"></div>
      </div>
      <div class="input-box">
        <input type="text" name="price" placeholder="Enter Price">
        <div class="underline"></div>
      </div>
      <div class="input-box button">
        <input type="submit" name="done" value="Update Booking">
      </div>
    </form>
  </div>
  <center><p>copyright@2025 chirag <br>
           contact no :8745857414
           email:vijaybooking@yahoo.in
       </p></center>
</body>

</html>