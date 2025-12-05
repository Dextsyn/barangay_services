<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay e‑Service</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body>
    <?php
        include 'includes/nav.php';
        include 'includes/header.php';
    ?>

    <main class="content">
        <h1>Welcome to Barangay e‑Service</h1>

        <div class="section">
            <h2>Citizen Services</h2>
            <p>Submit and check your requests or incident reports.</p>
            <h2>Document Requests</h2>
            <div class="button-group">
                <a href="residents/request_form.php" class="btn btn--primary">Submit Document Request</a><br>
                <a href="residents/check_request.php" class="btn btn--primary">Check Document Request Status</a><br>
            </div>
            <h2>Incident Reports</h2>
            <div class="button-group">
                <a href="residents_report/report.php" class="btn btn--primary">Submit Incident Report</a><br>
                <a href="residents_report/check_report.php" class="btn btn--primary">Check Incident Report Status</a>
            </div>
        </div>

        <div class="section">
            <h2>Admin Access</h2>
            <?php if (isset($_SESSION['user'])): ?>
                <p>Logged in as <strong><?= htmlspecialchars($_SESSION['user']['fullName']) ?></strong></p>
                <a href="admin/dashboard.php">Go to Dashboard</a><br>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <p>Admins must log in to manage requests and reports.</p>
                <a href="login.php" class="btn btn--primary">Admin Login</a>
            <?php endif; ?>
        </div>

        <footer class="page-footer">
            <?php include 'includes/footer.php'; ?>
        </footer>
    </main>

</body>
</html>