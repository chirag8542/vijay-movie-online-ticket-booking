<?php
// Movie Table Component
include 'Conn.php';

$queue = "SELECT * FROM Movie ORDER BY booking_id DESC";
$query = mysqli_query($conn, $queue);
?>

<div class="table-wrapper">
  <table class="movie-table">
    <thead>
      <tr>
        <th>Id</th>
        <th>Booking Name</th>
        <th>Booking Date</th>
        <th>No. of Tickets</th>
        <th>Price</th>
        <th>Total Amount</th>
        <th>Update</th>
        <th>Delete</th>
        <th>Bills</th>
      </tr>
    </thead>
    <tbody>
      <?php while($res = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= htmlspecialchars($res['booking_id']); ?></td>
          <td><?= htmlspecialchars($res['booking_name']); ?></td>
          <td><?= htmlspecialchars($res['booking_date']); ?></td>
          <td><?= htmlspecialchars($res['no_of_tickets']); ?></td>
          <td><?= htmlspecialchars($res['price']); ?></td>
          <td><?= htmlspecialchars($res['no_of_tickets'] * $res['price']); ?></td>

          <td><a class="btn update" href="update.php?booking_id=<?= $res['booking_id']; ?>">Update</a></td>
          <td><a class="btn delete" href="delete.php?booking_id=<?= $res['booking_id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a></td>
          <td><a class="btn bill" href="bills.php?booking_id=<?= $res['booking_id']; ?>">View Bill</a></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
