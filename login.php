<?php
session_start();
include("database.php");  // Include the database connection

$error = "";  // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = filter_input(INPUT_POST, "matric", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if fields are not empty
    if (empty($matric) || empty($password)) {
        $error = "Both fields are required!";
    } else {
        // Prepare the SQL query to fetch user data
        $sql = "SELECT password, role FROM users WHERE matric = '$matric'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);  // Fetch the user data

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user data in session variables
                $_SESSION['matric'] = $matric;
                $_SESSION['role'] = $user['role'];

                // Redirect to the authenticated page
                header("Location: index.php");  
                exit();
            } else {
                $error = "Invalid username or password, try <a href='login.php' style='text-decoration: underline;'>login</a> again.";
            }
        } else {
            $error = "Invalid username or password, try <a href='login.php' style='text-decoration: underline;'>login</a> again.";
        }
    }
}

mysqli_close($conn);  // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<!-- Display error message if authentication fails -->
<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<!-- Login form -->
<form action="login.php" method="POST">
    <label for="matric">Matric Number:</label>
    <input type="text" name="matric" id="matric" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>

    <input type="submit" value="Login">
</form>

<p> <a href="index.php" style="text-decoration: underline;">Register</a> here if you have not.</p>

</body>
</html>


