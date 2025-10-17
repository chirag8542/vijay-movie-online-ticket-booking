<?php
include 'Conn.php';

if (isset($_POST['done'])) {

  $booking_name = $_POST['booking_name'];
  $booking_date = $_POST['booking_date'];
  $no_of_tickets = $_POST['no_of_tickets'];
  $price = $_POST['price'];
  //$total_amount = $_POST['total_amount'];
  if (empty($booking_date) || empty($booking_name) || empty($no_of_tickets) || empty($price)) {
    echo "Please fill all the fields";
  } else if (!preg_match("/^[a-zA-Z ]*$/", $booking_name)) {
    echo "Only letters and white space allowed in booking name";
  } else if (!is_numeric($no_of_tickets) || $no_of_tickets < 1 || $no_of_tickets > 10) {
    echo "Number of tickets must be between 1 and 10";
  } else if (!is_numeric($price) || $price < 0) {
    echo "Price must be a positive number";
  } else {
  $queue = " INSERT INTO `Movie`
  (`booking_name`, `booking_date`, `no_of_tickets`, `price`) 
  VALUES 
  ('$booking_name', '$booking_date', '$no_of_tickets', '$price')";
  $query = mysqli_query($conn, $queue);
}
}
?>

<html>
<head>
  <title> Registration Form </title>
  <link rel="stylesheet" href="insert.css">
  
</head>

<body>
  
  <div class="container">
    <form method="post">
      <div class="title"> vijay Booking Movie Tickets<br>
        <img src="1.jpeg" width="100" height="90"> vansh 2 </img>
      </div>
      <div class="column">
        <div class="input-box">
          <input type="text" name="booking_name" placeholder="Enter Booking Name">
          <div class="underline"></div>
        </div>
        <div class="input-box">
          <input type="date" name="booking_date" placeholder="Enter Booking Date">
          <div class="underline"></div>
        </div>
      </div>
      <div class="column">
        <div class="input-box">
          <input type="text" name="no_of_tickets" placeholder="Enter No of Tickets">
          <div class="underline"></div>
        </div>
        <div class="input-box">
          <input type="text" name="price" value = 150 placeholder="Enter Price">
          <div class="underline"></div>
        </div>
      <div class="input-box button">
        <input type="submit" name="done" value="Book Now">
      </div>
    </form>
  </div>
  <center> <a href="display.php" >show booking </a> <center>
  <center><p>copyright@2025 chirag <br>
           contact no :8745857414
           email:vijaybooking@yahoo.in
       </p></center>
</body>

</html>