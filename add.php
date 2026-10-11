<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Basic validation
    if ($username === "" || $email === "") {
        die("Username and email are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }

    // Prepare SQL statement
    $stmt = $conn->prepare(
        "INSERT INTO users (username, email) VALUES (?, ?)"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind values
    $stmt->bind_param("ss", $username, $email);

    // Execute
    if (!$stmt->execute()) {
        die("Insert failed: " . $stmt->error);
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();

// Return to main page
header("Location: index.php");
exit();

?>
