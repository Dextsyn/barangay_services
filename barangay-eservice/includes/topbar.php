<?php
// includes/topbar.php
$userName = $_SESSION['user']['fullName'] ?? 'Guest';
?>
<div class="topbar">
  <div style="display:flex;align-items:center;gap:12px">
    <div class="search" role="search">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="#b7b7b7"><path d="M21 20l-5.6-5.6c.9-1.2 1.4-2.6 1.4-4.2 0-4.4-3.6-8-8-8S1 5.8 1 10.2 4.6 18 9 18c1.6 0 3-.5 4.2-1.4L20 21l1-1z"/></svg>
      <input placeholder="Search residents, requests, announcements..." aria-label="Search">
    </div>
  </div>

  <div class="avatar">
    <div class="avatar__img" style="background-image:url('/assets/images/avatar-placeholder.png')"></div>
    <div class="avatar__name"><?= htmlspecialchars($userName) ?></div>
  </div>
</div>
