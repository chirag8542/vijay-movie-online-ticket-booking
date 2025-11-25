<?php
include 'Conn.php';

if (isset($_POST['done'])) {

  $booking_name = $_POST['booking_name'];
  $booking_date = $_POST['booking_date'];
  $no_of_tickets = $_POST['no_of_tickets'];
  $price = $_POST['price'];

  if (empty($booking_date) || empty($booking_name) || empty($no_of_tickets) || empty($price)) {
    echo "Please fill all the fields";
  } else if (!preg_match("/^[a-zA-Z ]*$/", $booking_name)) {
    echo "Only letters and white space allowed in booking name";
  } else if (!is_numeric($no_of_tickets) || $no_of_tickets < 1 || $no_of_tickets > 10) {
    echo "Number of tickets must be between 1 and 10";
  } else if (!is_numeric($price) || $price < 0) {
    echo "Price must be a positive number";
  } else {
    $queue = "INSERT INTO `Movie` (`booking_name`, `booking_date`, `no_of_tickets`, `price`) 
              VALUES ('$booking_name', '$booking_date', '$no_of_tickets', '$price')";
    mysqli_query($conn, $queue);
  }
}
?>

<html>
<head>
  <title>Movie Ticket Booking</title>
  <link rel="stylesheet" href="insert.css">
</head>

<body>
<div class="slider">


    <div class="slide"><img src="1.jpeg"></div>
  
</div>

  <div class="container">
    <form method="post">
      <div class="title">
        Vijay Booking Movie Tickets <br>
        
      </div>
  <div class="input-box">
  <i class="fa fa-user"></i>
  <input type="text" name="booking_name" placeholder="Enter Booking Name">
</div>

<div class="input-box">
  <i class="fa fa-calendar"></i>
  <input type="date" name="booking_date">
</div>

<div class="input-box">
  <i class="fa fa-ticket"></i>
  <input type="text" name="no_of_tickets" placeholder="Enter No of Tickets">
</div>

<div class="input-box">
  <i class="fa fa-indian-rupee-sign"></i>
  <input type="text" name="price" value="150">
</div>

      

      <div class="input-box button">
        <input type="submit" name="done" value="Book Now">
      </div>
    </form>
  </div>

  <center>
    <a href="display.php" style="color:white; font-size:18px;">Show Booking</a>
  </center>

  <footer>
    <p>
      © 2025 Chirag <br>
      Contact: 8745857414 <br>
      Email: vijaybooking@yahoo.in
    </p>
  </footer>

</body>
</html>
