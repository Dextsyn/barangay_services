<?php
session_start();
require_once '../includes/auth.php'; 
require_once '../includes/db.php';

$id = intval($_GET['id'] ?? 0);
$msg = "";

$stmt = $conn->prepare("SELECT residentName, documentType, purpose, status, released_date FROM documents_request WHERE requestID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$request = $result->fetch_assoc();
$stmt->close();

if (!$request) {
    die("Request not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $released_date = $_POST['released_date'];
    $approvedBy = $_SESSION['user']['userID'];

    $stmt = $conn->prepare("UPDATE documents_request SET status = ?, approved_by = ?, released_date = ? WHERE requestID = ?");
    $stmt->bind_param("sisi", $status, $approved_by, $released_date, $requestID);

    if ($stmt->execute()) {
        $msg = "Request updated successfully.";
        $request['status'] = $status;
        $request['released_date'] = $released_date;
    } else {
        $msg = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Request</title>
  <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
  <div class="app">
    <?php include '../includes/sidebar.php'; ?>
    <div class="main">
      <?php include '../includes/topbar.php'; ?>

      <div class="header-card">
        <h2>Edit Document Request</h2>
      </div>

      <?php if (!empty($msg)) : ?>
        <div class="alert"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <div class="form-wrapper">
        <form method="POST">
          <div class="form-row">
            <label><strong>Resident Name:</strong></label>
            <p><?= htmlspecialchars($request['residentName']) ?></p>
          </div>

          <div class="form-row">
            <label><strong>Document Type:</strong></label>
            <p><?= htmlspecialchars($request['documentType']) ?></p>
          </div>

          <div class="form-row">
            <label><strong>Purpose:</strong></label>
            <p><?= htmlspecialchars($request['purpose']) ?></p>
          </div>

          <div class="form-row">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
              <option value="Pending"  <?= $request['status'] === 'Pending'  ? 'selected' : '' ?>>Pending</option>
              <option value="Approved" <?= $request['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
              <option value="Released" <?= $request['status'] === 'Released' ? 'selected' : '' ?>>Released</option>
            </select>
          </div>

          <div class="form-row">
            <label for="released_date">Released Date:</label>
            <input type="date" name="released_date" id="released_date"
                   value="<?= htmlspecialchars($request['released_date']) ?>">
          </div>

          <button type="submit" class="btn btn--primary">Update Request</button>
        </form>
        <p><a href="list_request.php">← Back to list</a></p>
      </div>

      <div class="page-footer">
        <?php include '../includes/footer.php'; ?>
      </div>
    </div>
  </div>
</body>
</html>

