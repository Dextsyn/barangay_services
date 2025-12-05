<?php
session_start();
require_once '../includes/auth.php'; 
include '../includes/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM documents_request WHERE requestID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: list_request.php?msg=Request+deleted+successfully");
    } else {
        header("Location: list_request.php?msg=Error:+".$stmt->error);
    }

    $stmt->close();
} else {
    header("Location: list_request.php?msg=Invalid+request+ID");
}

$conn->close();
?>