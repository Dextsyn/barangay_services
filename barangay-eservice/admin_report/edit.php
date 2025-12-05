<?php 
session_start();
require_once '../includes/auth.php';
include '../includes/db.php';

$id = intval($_GET['id'] ?? 0);
$msg = "";

$stmt = $conn->prepare("SELECT incidentType, incidentDescription, status FROM incident_reports WHERE reportID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();
$stmt->close();

if (!$request) {
    die("Report not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $handledBy = $_SESSION['user']['userID'];

    $stmt = $conn->prepare("UPDATE incident_reports 
                            SET status = ?, handled_by = ? 
                            WHERE reportID = ?");
    $stmt->bind_param("sii", $status, $handledBy, $reportID);

    if ($stmt->execute()) {
        $msg = "Report updated successfully.";
        $request['status'] = $status;
    } else {
        $msg = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Report</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <div class="app">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main">
      <?php include '../includes/topbar.php'; ?>

      <div class="form-wrapper">
        <h2>Edit Incident Report</h2>

        <?php if (!empty($msg)) : ?>
          <div class="alert"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="form-row">
            <label><strong>Report Type:</strong></label>
            <p><?= htmlspecialchars($request['incidentType']) ?></p>
          </div>

          <div class="form-row">
            <label><strong>Report Description:</strong></label>
            <p><?= htmlspecialchars($request['incidentDescription']) ?></p>
          </div>

          <div class="form-row">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
              <option value="Pending" <?= $request['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
              <option value="In Progress" <?= $request['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
              <option value="Resolved" <?= $request['status'] === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>
          </div>

          <button type="submit" class="btn btn--primary">Update Report</button>
        </form>
      </div>

      <div class="page-footer">
        <?php include '../includes/footer.php'; ?>
      </div>
    </div>
  </div>
</body>
</html>