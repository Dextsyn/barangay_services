<?php require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $residentID = $_POST['residentID'];
    $residentName = $_POST['residentName'];
    $documentType = $_POST['documentType'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("INSERT INTO documents_request (residentID, residentName, documentType, purpose, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $residentID, $residentName, $documentType, $purpose);

    if ($stmt->execute()) {
        $msg = "Request submitted successfully.";
    } else {
        $msg = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Citizen Request</title></head>
<link rel="stylesheet" href="../assets/css/app.css">
<body>
<?php include '../includes/nav.php';
include '../includes/header.php'; ?>
<main class="content">
<h2>Submit Document Request</h2>
<?php if(isset($msg)) echo "<p>$msg</p>"; ?>
<div class="form-wrapper">
    <form method="POST">
        <input type="number" name="residentID" placeholder="Resident ID" required><br>
        <input type="text" name="residentName" placeholder="Resident Name" required><br>
        <select name="documentType" required>
            <option value="Clearance">Barangay Clearance</option>
            <option value="Residency">Certificate of Residency</option>
            <option value="Permit">Business Permit</option>
        </select><br>
        <textarea name="purpose" placeholder="Purpose"></textarea><br>
        <button type="submit">Submit</button>
    </form>
</div>
</main>
</body>
</html>