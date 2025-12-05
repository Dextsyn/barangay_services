<?php 
require '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentID = intval($_POST['residentID']);
    $stmt = $conn->prepare("SELECT requestID, documentType, purpose, status 
                            FROM documents_request WHERE residentID = ?");
    $stmt->bind_param("i", $residentID);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Check Request</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <?php include '../includes/nav.php'; include '../includes/header.php'; ?>
  <main class="content">
    <div class="form-wrapper">
      <h2>Check Your Requests</h2>
      <form method="POST">
        <div class="form-row">
          <input type="number" name="residentID" placeholder="Enter Resident ID" required>
        </div>
        <button type="submit" class="btn btn--primary">Check</button>
      </form>

      <?php if (isset($result)) {
        while ($row = $result->fetch_assoc()) { ?>
          <div class="report-card">
            <p><strong>Request #<?= $row['requestID'] ?></strong></p>
            <p>Type: <?= htmlspecialchars($row['documentType']) ?></p>
            <p>Purpose: <?= htmlspecialchars($row['purpose']) ?></p>
            <p>Status: <span class="status"><?= htmlspecialchars($row['status']) ?></span></p>
          </div>
      <?php } } ?>
    </div>
  </main>
</body>
</html>