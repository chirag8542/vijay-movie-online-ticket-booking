<?php
// Header Component
?>
<div class="header-bar">
    <h2 class="header-title">🎬 Movie Booking Records</h2>
    <div class="header-buttons">
        <?php if(isset($showBackButton) && $showBackButton): ?>
            <a class="back-btn" href="insert.php">⬅ Back</a>
        <?php endif; ?>
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
</div   >
