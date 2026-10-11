<?php

include "db.php";

// Get the selected user's ID
$id = $_GET["id"] ?? 0;

// ========================================
// UPDATE USER
// ========================================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["id"] ?? 0;
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Basic validation
    if (!is_numeric($id) || $id <= 0) {
        die("Invalid user ID.");
    }

    if ($username === "" || $email === "") {
        die("Username and email are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }

    // Prepare UPDATE statement
    $stmt = $conn->prepare(
        "UPDATE users
         SET username = ?, email = ?
         WHERE id = ?"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind values
    $stmt->bind_param("ssi", $username, $email, $id);

    // Execute
    if (!$stmt->execute()) {
        die("Update failed: " . $stmt->error);
    }

    $stmt->close();

    // Return to main page
    header("Location: index.php");
    exit();
}

// ========================================
// GET USER INFORMATION
// ========================================

if (!is_numeric($id) || $id <= 0) {
    die("Invalid user ID.");
}

$stmt = $conn->prepare(
    "SELECT * FROM users
     WHERE id = ?"
);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

if (!$user) {
    die("User not found.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Edit User</h1>

        <form method="POST" action="edit.php">

            <!-- USER ID -->
            <input
                type="hidden"
                name="id"
                value="<?php echo htmlspecialchars($user['id']); ?>"
            >

            <!-- USERNAME -->
            <label for="username">
                Username
            </label>

            <input
                type="text"
                id="username"
                name="username"
                value="<?php echo htmlspecialchars($user['username']); ?>"
                required
            >

            <!-- EMAIL -->
            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars($user['email']); ?>"
                required
            >

            <!-- UPDATE BUTTON -->
            <button
                type="submit"
                class="btn add"
            >
                Update User
            </button>

            <!-- CANCEL BUTTON -->
            <a
                href="index.php"
                class="btn cancel"
            >
                Cancel
            </a>

        </form>

    </div>

</div>

</body>
</html>
