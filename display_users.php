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
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["matric"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["role"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close connection
$conn->close();
?>
