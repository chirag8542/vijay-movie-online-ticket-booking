<?php
include 'Conn.php';

if (isset($_GET['booking_id'])) {
    $id = $_GET['booking_id'];
    $queue = "SELECT * FROM Movie WHERE booking_id='$id'";
    $query = mysqli_query($conn, $queue);
    $res = mysqli_fetch_array($query);
?>
<html>
<head>
  <title>View Bill</title>
  <link rel="stylesheet" href="bills.css">
</head>
<body>
  <div class="container">
    <div class="title">Bill Details</div>
    <p><b>Booking Name:</b> <?php echo $res['booking_name']; ?></p>
    <p><b>Booking Date:</b> <?php echo $res['booking_date']; ?></p>
    <p><b>No. of Tickets:</b> <?php echo $res['no_of_tickets']; ?></p>
    <p><b>Price per Ticket:</b> <?php echo $res['price']; ?></p>
    <p><b>Total Amount:</b> <?php echo $res['no_of_tickets'] * $res['price']; ?></p>
    <br>
    <a href="Display.php">← Back to Booking List</a>
  </div>
</body>
</html>
<?php
} else {
    echo "Invalid Booking ID!";
}
?>
