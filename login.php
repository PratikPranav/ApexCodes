<!-- <?php
$plain_password = 'ab12';
$new_hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

echo "Newly hashed password: $new_hashed_password\n";
?> -->

<!-- <?php
 
$servername = "localhost";
$username = "root";
$password = "";
$database = "apex";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$new_hashed_password = '$2y$10$6HgnUnEq9DNFxP4Z6Wy6MepgpNJAvS3h3nOFfCg15v9iYHEoV5LZq'; // Newly generated hash
$email = 'pq@gmail.com'; // Email of the user whose password needs to be updated

$sql = "UPDATE users SET password = '$new_hashed_password' WHERE email = '$email'";

if ($conn->query($sql) === TRUE) {
    echo "Password updated successfully";
} else {
    echo "Error updating password: " . $conn->error;
}

$conn->close();
?> -->

<?php
SESSION_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "apex";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Retrieve and sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password fields are empty
    if (empty($email) || empty($password)) {
        echo "Please fill in both email and password fields.";
    } else {
        // Query the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql); // Executes the SQL query

        if ($result->num_rows == 1) { // If we found 1 (unique email) from result
            $row = $result->fetch_assoc(); // Fetch that row (in an associative array form)
            $hashed_password = $row['password']; // Now from that array we need only password.

        //   // Debug output
        //   echo "<p>Hashed password from DB: " . htmlspecialchars($hashed_password) . "</p>";
        //   echo "<p>Password from form: " . htmlspecialchars($password) . "</p>";

            if (password_verify($password, $hashed_password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];

                echo "<h1>Welcome, " . htmlspecialchars($_SESSION['name']) . "</h1>";
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo "Password incorrect";
            }
        } else {
            echo "User not found";
        }
    }
}

$conn->close();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h3>LOGIN</h3>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="submit" value="Login">
    </form>
    <a href="register.php">Register</a>
</body>
</html> 
