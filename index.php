<?php
include "db.php";

$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini User Manager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Mini User Manager</h1>

    <p class="subtitle">
        Simple User Management System using PHP and MySQL
    </p>

    <!-- ADD USER FORM -->
    <div class="card">
        <h2>Add New User</h2>

        <form action="add.php" method="POST">

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required
            >

            <input
                type="email"
                name="email"
                placeholder="Enter email"
                required
            >

            <button type="submit" class="btn add">
                Add User
            </button>

        </form>
    </div>

    <!-- USER LIST -->
    <div class="card">
        <h2>User List</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if ($result->num_rows > 0): ?>

                    <?php while ($row = $result->fetch_assoc()): ?>

                        <tr>
                            <td>
                                <?php echo $row['id']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['username']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['email']); ?>
                            </td>

                            <td>

                                <!-- EDIT -->
                                <a
                                    href="edit.php?id=<?php echo $row['id']; ?>"
                                    class="btn edit"
                                >
                                    Edit
                                </a>

                                <!-- DELETE -->
                                <a
                                    href="delete.php?id=<?php echo $row['id']; ?>"
                                    class="btn delete"
                                    onclick="return confirm('Are you sure you want to delete this user?');"
                                >
                                    Delete
                                </a>

                            </td>
                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="4">
                            No users found.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>

</body>
</html>
