<?php require '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentID = intval($_POST['residentID']);
    $stmt = $conn->prepare("SELECT reportID, incidentType, incidentDescription, status 
                        FROM incident_reports WHERE residentID = ?");
    $stmt->bind_param("i", $residentID);
    $stmt->execute();
    $result = $stmt->get_result();
}  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Incident Report Status</title>
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
    <?php include '../includes/nav.php'; include '../includes/header.php'; ?>
    <main class="content">
  <div class="form-wrapper">
    <h2>Check Your Incident Reports</h2>
    <form method="POST">
      <div class="form-row">
        <input type="number" name="residentID" placeholder="Enter Resident ID" required>
      </div>
      <button type="submit">Check</button>
    </form>

    <?php if (isset($result)) {
      while ($row = $result->fetch_assoc()) { ?>
        <div class="report-card">
          <p><strong>Report #<?= $row['reportID'] ?></strong></p>
          <p>Type: <?= htmlspecialchars($row['incidentType']) ?></p>
          <p>Description: <?= htmlspecialchars($row['incidentDescription']) ?></p>
          <p>Status: <span class="status"><?= htmlspecialchars($row['status']) ?></span></p>
        </div>
    <?php } } ?>
  </div>
</main>
</body>
</html>
