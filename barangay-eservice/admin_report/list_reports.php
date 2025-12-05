<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: ../login.php"); exit(); }
require '../includes/db.php';

$stmt = $conn->prepare("
  SELECT ir.reportID, r.fullName, ir.incidentType, ir.incidentDescription, ir.status
  FROM incident_reports ir
  JOIN residents r ON ir.residentID = r.residentID
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Incident Reports</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <div class="app">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main">
      <?php include '../includes/topbar.php'; ?>

      <div class="header-card">
        <h2>Incident Reports</h2>
      </div>

      <div class="table-wrapper">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Report ID</th>
              <th>Resident Name</th>
              <th>Incident Type</th>
              <th>Description</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['reportID'] ?></td>
              <td><?= htmlspecialchars($row['fullName']) ?></td>
              <td><?= htmlspecialchars($row['incidentType']) ?></td>
              <td><?= htmlspecialchars($row['incidentDescription']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td>
                <a href="edit.php?id=<?= $row['reportID'] ?>">Edit</a>
                <a href="delete.php?id=<?= $row['reportID'] ?>" onclick="return confirm('Delete this report?');">Delete</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="page-footer">
        <?php include '../includes/footer.php'; ?>
      </div>
    </div>
  </div>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>
