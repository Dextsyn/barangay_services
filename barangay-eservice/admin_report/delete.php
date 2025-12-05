<?php 
session_start();
require_once '../includes/auth.php';
include '../includes/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM incident_reports WHERE reportID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: list_reports.php?msg=Report+deleted+successfully");
    } else {
        header("Location: list_reports.php?msg=Error:+".$stmt->error);
    }

    $stmt->close();
} else {
    header("Location: list_reports.php?msg=Invalid+report+ID");
}
$conn->close();
?>
