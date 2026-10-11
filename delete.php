<?php

include "db.php";

// Get selected user ID
$id = $_GET["id"] ?? 0;

// Validate ID
if (!is_numeric($id) || $id <= 0) {
    die("Invalid user ID.");
}

// Prepare DELETE statement
$stmt = $conn->prepare(
    "DELETE FROM users WHERE id = ?"
);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind ID
$stmt->bind_param("i", $id);

// Execute
if (!$stmt->execute()) {
    die("Delete failed: " . $stmt->error);
}

// Close statement
$stmt->close();
$conn->close();

// Return to main page
header("Location: index.php");
exit();

?>