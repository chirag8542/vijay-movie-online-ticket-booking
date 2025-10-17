<html>
<head>
  <link rel="stylesheet" href="display.css">
</head>
<body>
  <div class="container">
    <div class="title">
      <table border='2'>
        <tr>
          <th>Id</th>
          <th>Booking Name</th>
          <th>Booking Date</th>
          <th>No.of Tickets</th>
          <th>Price</th>
          <th>Total Amount
          <th>Update</th>
          <th>Delete</th>
          <th>Bills</th>
        </tr><br>
        <?php
        include 'Conn.php';
        $queue = "SELECT * from Movie";
        $query = mysqli_query($conn, $queue);
        while ($res = mysqli_fetch_array($query)) {
          ?>
          <tr>
            <td>
              <?php echo $res['booking_id']; ?>
            </td>
            <td>
              <?php echo $res['booking_name']; ?>
            </td>
            <td>
              <?php echo $res['booking_date']; ?>
            </td>
            <td>
              <?php echo $res['no_of_tickets']; ?>
            </td>
            <td>
              <?php echo $res['price']; ?>
            </td>
            <td>
              <?php echo $res['no_of_tickets']*$res['price']; ?> 
            </td>
            <td>
              <button>
                <a href="update.php?booking_id=<?php echo $res['booking_id']; ?>"> Update </a>
              </button><br>
            </td>
            <td>
              <button>
                <a href="delete.php?booking_id=<?php echo $res['booking_id']; ?>"> Delete </a>
              </button>
            </td>
            <td>
              <button>
                <a href="bills.php?booking_id=<?php echo $res['booking_id']; ?>"> View Bill </a>
              </button>
            </td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>
  <a href="update.php"> update data </a>
  <a href="delete.php"> delete update </a>
  <center><p>copyright@2025 chirag <br>
           contact no :8745857414
           email:vijaybooking@yahoo.in
       </p></center>
</body>
</html>