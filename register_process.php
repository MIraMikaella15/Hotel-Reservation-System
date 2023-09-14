<?php
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

    // Check if the email is already registered
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email is already in use
        header("Location: register.php?error=emailinuse");
    } else {
        // Hash the password (you should use password_hash() for storing passwords)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $insertSql = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";
        if ($conn->query($insertSql) === TRUE) {
            // Registration successful, redirect to the login page
            header("Location: login.php?success=registered");
        } else {
            // Registration failed
            header("Location: register.php?error=registrationfailed");
        }
    }

    $conn->close();
}
?>
