<?php
session_start();
require('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT userID, username, fullName, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    // Plain text comparison (Option 1)
    if ($result && $password === $result['password']) {
        // Store SESSION securely
        $_SESSION['user'] = [
            'userID'   => $result['userID'],
            'username' => $result['username'],
            'fullName' => $result['fullName']
        ];

        header("Location: admin/dashboard.php");
        exit();
    } else {
        $msg = "Invalid username or password.";
    }

    $stmt->close();
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Login</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <?php
    include 'includes/nav.php'; 
    include 'includes/header.php';
    ?>
    <main class="content">
  <div class="form-wrapper">
    <h2>Admin Login</h2>
    <?php if (isset($msg)) echo "<div class='alert error'>" . htmlspecialchars($msg) . "</div>"; ?>
    <form method="POST">
      <div class="form-row">
        <input name="username" placeholder="Username" required>
      </div>
      <div class="form-row">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn--primary">Login</button>
    </form>
  </div>
</main>
</body>
</html>