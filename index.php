<?php
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Matric: <input type="text" name="matric"><br>
        Name: <input type="text" name="name"><br>
        Password: <input type="password" name="password"><br>
        Role: 
        <select name="role">
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matric = filter_input(INPUT_POST, "matric", FILTER_SANITIZE_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($matric) || empty($name) || empty($password) || empty($role)) {
            echo "All fields are required!";
        } else {
            // Hash the password
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (matric, name, password, role) 
                    VALUES ('$matric', '$name', '$hash', '$role')";
            mysqli_query($conn, $sql);
            echo "You are now registered!"; 
        }
    }
    mysqli_close($conn);
?>
