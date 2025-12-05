<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Count document requests
$docStmt = $conn->query("SELECT COUNT(*) AS total_docs FROM documents_request");
$docCount = $docStmt->fetch_assoc()['total_docs'];

// Count incident reports
$repStmt = $conn->query("SELECT COUNT(*) AS total_reports FROM incident_reports");
$repCount = $repStmt->fetch_assoc()['total_reports'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <div class="app">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main">
      <?php include '../includes/topbar.php'; ?>

      <div class="header-card">
        <div class="greet">
          <h1 class="greet__title">Welcome, <?= htmlspecialchars($_SESSION['user']['fullName']) ?></h1>
          <p class="greet__sub">Here’s a quick overview of activity.</p>
        </div>
      </div>

      <div class="cards">
        <div class="card">
          <h3>Document Requests</h3>
          <p class="muted"><?= $docCount ?> total</p>
        </div>
        <div class="card">
          <h3>Incident Reports</h3>
          <p class="muted"><?= $repCount ?> total</p>
        </div>
      </div>

      <div class="page-footer">
        <?php include '../includes/footer.php'; ?>
      </div>
    </div>
  </div>
</body>
</html>