<?php
// Database connection
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "lab_5b";    

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data to update
if (isset($_GET['matric'])) {
    $matric = $_GET['matric']; // Get matric from URL (GET request)
    $sql = "SELECT matric, name, role FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No such user found!";
        exit();
    }
} else {
    echo "Matric number is missing!";
    exit();
}

// Update operation after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the matric field is set in POST data
    if (isset($_POST['matric']) && !empty($_POST['matric'])) {
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $role = $_POST['role'];

        // SQL query to update user
        $sql_update = "UPDATE users SET name = '$name', role = '$role' WHERE matric = '$matric'";

        if ($conn->query($sql_update) === TRUE) {
            echo "Record updated successfully";
            header("Location: display_users_v2.php"); // Redirect to the main page after update
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Matric number is missing!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>

<h2>Update User Information</h2>

<form action="update_users_info.php" method="POST">
    <!-- Hidden field to send matric number -->
    <input type="hidden" name="matric" value="<?php echo $user['matric']; ?>">

    <label for="matric">Matric:</label>
    <input type="text" name="matric" id="matric" value="<?php echo $user['matric']; ?>" readonly><br><br> <!-- readonly to prevent changing matric number -->

    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" required><br><br>
    
    <label for="role">Role:</label>
    <input type="text" name="role" id="role" value="<?php echo $user['role']; ?>" required><br><br>

    <input type="submit" value="Update">
    <a href="display_users_v2.php">Cancel</a> <!-- Link to cancel and go back to the main page -->
</form>

</body>
</html>


