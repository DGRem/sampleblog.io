<?php
require 'config.php';

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (!$duplicate) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($duplicate) > 0) {
        echo "<script> alert('Username or Email Has Already Taken'); </script>";
    } else {
        if ($password == $confirmpassword) {
            $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Registration Successful'); </script>";
                header('Location: login.php');
                exit();
            } else {
                echo "<script> alert('Registration Failed'); </script>";
            }
        } else {
            echo "<script> alert('Password Does Not Match'); </script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="/php-practice/BlogSample/log.css">
</head>
<body>
    <main>
        <div class="container">
            <h2>Register</h2>
            <form action="" method="post" autocomplete="off">
                <div>
                    <label for="username">Username:</label>
                </div>
                <div>
                    <input type="text" name="username" id="username" required value="">
                </div>
                <div>
                    <label for="email">Email:</label>
                </div>
                <div>
                    <input type="email" name="email" id="email" required value="">
                </div>
                <div>
                    <label for="password">Password:</label>
                </div>
                <div>
                    <input type="password" name="password" id="password" required value="">
                </div>
                <div>
                    <label for="confirmpassword">Confirm Password:</label>
                </div>
                <div>
                    <input type="password" name="confirmpassword" id="confirmpassword" required value="">
                </div>
                <button type="submit" name="submit">Sign Up</button>
            </form>
            <span>Already have an account? <a href="login.php">Log In</a></span>
        </div>
    </main>
</body>
</html>