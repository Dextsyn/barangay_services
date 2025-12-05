<?php
require '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $residentID   = $_POST['residentID'];
    $residentName = $_POST['residentName'];
    $incidentType = $_POST['incidentType'];
    $description  = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO incident_reports 
    (residentID, residentName, incidentType, incidentDescription, status, handled_by) 
    VALUES (?, ?, ?, ?, 'Pending', NULL)");
    $stmt->bind_param("isss", $residentID, $residentName, $incidentType, $description);;

    if ($stmt->execute()) {
        $msg = "Incident report submitted successfully.";
    } else {
        $msg = "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head><title>Report an Incident</title></head>
<link rel="stylesheet" href="../assets/css/app.css">
<body>
    <?php include '../includes/nav.php';
    include '../includes/header.php'; ?>
<main class="content">
  <div class="form-wrapper">
    <h2>Submit Incident Report</h2>
    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>
    <form method="POST">
      <div class="form-row">
        <label for="residentID">Resident ID:</label>
        <input type="text" name="residentID" id="residentID" required>
      </div>

      <div class="form-row">
        <label for="residentName">Resident Name:</label>
        <input type="text" name="residentName" id="residentName" required>
      </div>

      <div class="form-row">
        <label for="incidentType">Incident Type:</label>
        <select name="incidentType" id="incidentType" required>
          <option value="Noise Complaint">Noise Complaint</option>
          <option value="Vandalism">Vandalism</option>
          <option value="Dispute">Dispute</option>
        </select>
      </div>

      <div class="form-row">
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
      </div>

      <button type="submit" class="btn btn--primary">Submit Report</button>
    </form>
  </div>
</main>
</body>
</html>