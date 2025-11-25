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
  <title>Movie Bill</title>
  <link rel="stylesheet" href="bills.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>

<body>
<center>
<div class="ticket-container" id="billArea">

  <div class="header"></div>

  <div class="movie-info">
    <img src="logo.png" class="movie-logo">
    <h2 class="movie-name">🎬 Vijay Movie Booking</h2>
    <p class="rating">⭐ 4.8 | Action | 2 hr 30 min</p>
  </div>

  <div class="tear-line"></div>

  <div class="bill-body">

    <div class="bill-row"><i class="fa fa-user"></i> 
      Booking Name: <span><?php echo $res['booking_name']; ?></span>
    </div>

    <div class="bill-row"><i class="fa fa-calendar"></i>
      Booking Date: <span><?php echo $res['booking_date']; ?></span>
    </div>

    <div class="bill-row"><i class="fa fa-chair"></i>
      Seat Type: <span>Premium</span>
    </div>

    <div class="bill-row"><i class="fa fa-ticket"></i>
      Tickets: <span><?php echo $res['no_of_tickets']; ?></span>
    </div>

    <div class="bill-row"><i class="fa fa-rupee-sign"></i>
      Price per Ticket: <span><?php echo $res['price']; ?></span>
    </div>

    <div class="bill-row total"><i class="fa fa-money-bill-wave"></i>
      Total Amount: <span><?php echo $res['no_of_tickets'] * $res['price']; ?></span>
    </div>

    <div class="qr-section">
      <p>Scan to Verify Booking</p>
      <img src="qr.png" class="qr">
    </div>

  </div>

</div>

<div class="btn-group">
  <button onclick="downloadPDF()">📥 Download PDF</button>
  <button onclick="window.print()">🖨 Print Ticket</button>
  <a href="Display.php">⏪ Back to List</a>
</div>

<script>
function downloadPDF() {
    const element = document.getElementById("billArea");
    html2pdf().from(element).save("Movie_Ticket.pdf");
}
</script>
</center>
</body>
</html>

<?php
} else {
    echo "Invalid Booking ID!";
}
?>
