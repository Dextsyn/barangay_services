<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: ../login.php"); exit(); }
require '../includes/db.php';

$stmt = $conn->prepare("SELECT requestID, residentName, documentType, purpose, status FROM documents_request");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document Requests</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <div class="app">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main">
      <?php include '../includes/topbar.php'; ?>

      <div class="header-card">
        <h2>Document Requests</h2>
      </div>

      <div class="table-wrapper">
        <table class="styled-table">
          <thead>
            <tr>
              <th>ID</th><th>Name</th><th>Type</th><th>Purpose</th><th>Status</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
              <td><?= $row['requestID'] ?></td>
              <td><?= htmlspecialchars($row['residentName']) ?></td>
              <td><?= htmlspecialchars($row['documentType']) ?></td>
              <td><?= htmlspecialchars($row['purpose']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td>
                <a href="edit.php?id=<?= $row['requestID'] ?>">Edit</a>
                <a href="delete.php?id=<?= $row['requestID'] ?>" onclick="return confirm('Delete this request?');">Delete</a>
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
