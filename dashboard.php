<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard!</h2>
    <!-- Display user information here -->
    <p>Email: <?php echo $_SESSION["user_email"]; ?></p>
    <!-- Add other content for the dashboard -->
    <a href="logout.php">Logout</a>
</body>
</html>
