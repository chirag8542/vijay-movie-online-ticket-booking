<?php
include 'Conn.php';

if (isset($_POST['done'])) {
  $booking_name = $_POST['booking_name'];
  $booking_date = $_POST['booking_date'];
  $no_of_tickets = $_POST['no_of_tickets'];
  $price = $_POST['price'];

  if (empty($booking_date) || empty($booking_name) || empty($no_of_tickets) || empty($price)) {
    echo "<div class='error-message'>Please fill all the fields</div>";
  } else if (!preg_match("/^[a-zA-Z ]*$/", $booking_name)) {
    echo "<div class='error-message'>Only letters and white space allowed in booking name</div>";
  } else if (!is_numeric($no_of_tickets) || $no_of_tickets < 1 || $no_of_tickets > 10) {
    echo "<div class='error-message'>Number of tickets must be between 1 and 10</div>";
  } else if (!is_numeric($price) || $price < 0) {
    echo "<div class='error-message'>Price must be a positive number</div>";
  } else {
    $queue = "INSERT INTO `Movie` (`booking_name`, `booking_date`, `no_of_tickets`, `price`) 
              VALUES ('$booking_name', '$booking_date', '$no_of_tickets', '$price')";
    if(mysqli_query($conn, $queue)) {
      echo "<div class='success-message'>Booking successful! Thank you for your reservation.</div>";
    } else {
      echo "<div class='error-message'>Sorry, there was an error processing your booking. Please try again.</div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vijay Movie Ticket Booking</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="insert.css">
</head>
<body>
  <div class="header">
    <div class="logo">
      <i class="fas fa-film"></i>
      Vijay Movie Tickets
    </div>
    <div class="tagline">Book your movie experience with ease</div>
  </div>

  <div class="movie-slider">
    <img src="1.jpeg" alt="Now Showing">
    <div class="container">
      <div class="form-title">Book Your Tickets</div>
      
      <form method="post">
        <div class="input-group">
          <label for="booking_name">Full Name</label>
          <div class="input-box">
            <i class="fas fa-user"></i>
            <input type="text" id="booking_name" name="booking_name" placeholder="Enter your full name" required>
          </div>
        </div>
  
        <div class="input-group">
          <label for="booking_date">Booking Date</label>
          <div class="input-box">
            <i class="fas fa-calendar-alt"></i>
            <input type="date" id="booking_date" name="booking_date" required>
          </div>
        </div>
  
        <div class="input-group">
          <label for="no_of_tickets">Number of Tickets</label>
          <div class="input-box">
            <i class="fas fa-ticket-alt"></i>
            <input type="number" id="no_of_tickets" name="no_of_tickets" min="1" max="10" placeholder="1 to 10 tickets" required>
          </div>
          <div class="ticket-price">
            <span>Minimum: 1 ticket</span>
            <span>Maximum: 10 tickets</span>
          </div>
        </div>
  
        <div class="input-group">
          <label for="price">Price per Ticket</label>
          <div class="input-box">
            <i class="fas fa-rupee-sign"></i>
            <input type="text" id="price" name="price" value="150" readonly>
          </div>
          <div class="ticket-price">
            <span>Fixed price per ticket</span>
            <span>Total: <span id="total-price">150</span> ₹</span>
          </div>
        </div>
  
        <div class="input-group button">
          <input type="submit" name="done" value="Book Now">
        </div>
      </form>
  
      <div class="show-booking">
        <a href="display.php">
          <i class="fas fa-list"></i> View All Bookings
        </a>
      </div>
    </div>
  </div>


  <footer>
    <p>
      © 2025 Chirag <br>
      <i class="fas fa-phone"></i> Contact: 8745857414 <br>
      <i class="fas fa-envelope"></i> Email: vijaybooking@yahoo.in
    </p>
  </footer>

  <script>
    // Calculate total price based on number of tickets
    document.getElementById('no_of_tickets').addEventListener('input', function() {
      const ticketCount = this.value;
      const pricePerTicket = 150;
      const totalPrice = ticketCount * pricePerTicket;
      document.getElementById('total-price').textContent = totalPrice;
    });

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('booking_date').setAttribute('min', today);
  </script>
</body>
</html>