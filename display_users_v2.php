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

// Delete operation
if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];

    // SQL query to delete user by matric
    $sql_delete = "DELETE FROM users WHERE matric = '$matric'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// SQL query to fetch data
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);

// Check if records exist
if ($result->num_rows > 0) {
    // Display data in a table
    echo "<table border='1'>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["matric"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["role"] . "</td>
                <td>
                    <a href='update_users_info.php?matric=" . urlencode($row["matric"]) . "'>Update</a> | 
                    <a href='?delete=" . urlencode($row["matric"]) . "' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close connection
$conn->close();
?>

