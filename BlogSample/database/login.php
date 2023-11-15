<?php
require 'config.php';
if (isset($_POST["submit"])) {
    $username_email = mysqli_real_escape_string ($conn, $_POST["username_email"]);
    $password = mysqli_real_escape_string ($conn, $_POST["password"]);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'");
    
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: /php-practice/BlogSample/blog.html");
            exit;
        } else {
            echo "<script> alert('Wrong Password'); </script>";
        }
    } else {
        echo "<script> alert('User Not Registered'); </script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="/php-practice/BlogSample/log.css">
</head>
<body>
    <main>
        <div class="container">
            <h2>Login</h2>
            <form action="" method="post" autocomplete="off">
                <div>
                    <label for="username_email">Username or Email:</label>
                </div>
                <div>
                    <input type="text" name="username_email" id="username_email" required value="">
                </div>
                <div>
                    <label for="password">Password:</label>
                </div>
                <div>
                    <input type="password" name="password" id="password" required value="">
                </div>
                <button type="submit" name="submit">Login</button>
            </form>
            <span>Don't have an account? <a href="register.php">Register</a></span>
        </div>
    </main>
</body>
</html>