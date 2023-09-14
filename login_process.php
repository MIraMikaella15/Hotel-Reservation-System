<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection code here.
    // Replace 'your_db_credentials' with your actual database connection details.
    $conn = new mysqli('localhost', 'root', '', 'hrs');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Protect against SQL injection (you should use prepared statements)
    $email = mysqli_real_escape_string($conn, $email);

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];

        // Verify the password (you should use password_hash() for storing passwords)
        if (password_verify($password, $storedPassword)) {
            // Password is correct, store user information in session
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            
            // Redirect to a protected page or dashboard
            header("Location: dashboard.php");
        } else {
            // Password is incorrect
            header("Location: login.php?error=invalid");
        }
    } else {
        // User with the given email doesn't exist
        header("Location: login.php?error=notfound");
    }

    $conn->close();
}
?>
