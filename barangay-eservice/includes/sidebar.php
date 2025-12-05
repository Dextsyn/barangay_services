<?php
// includes/sidebar.php
?>
<div class="sidebar" role="navigation">
  <div class="brand">
    <div class="brand__logo">B</div>
    <div>
      <div class="brand__title">Barangay</div>
      <div style="font-size:.85rem;color:var(--muted)">e-Services</div>
    </div>
  </div>

  <nav class="nav" aria-label="Main navigation">
    <a class="nav__item nav__item--active" href="../admin/dashboard.php">
      <!-- home SVG -->
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3l9 8-1.4 1.2L19 11v8h-5v-5H10v5H5v-8L4.4 12.2 3 11l9-8z"/></svg>
      Overview
    </a>

    <a class="nav__item" href="../admin/list_request.php">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
      Document Requests
    </a>

    <a class="nav__item" href="../admin_report/list_reports.php">
      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h18v2H3V3zm2 6h14v12H5V9zm3-4h8v2H8V5z"/></svg>
      Incident Reports
    </a>
  </nav>
</div>
