<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "apex";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed due to:" . mysqli_connect_error());
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);//default sets the strongest crypt for hashing

        $checkemail = "select id from users where email = '$email'";
        $result = $conn->query($checkemail);

        if ($result->num_rows > 0) {
            echo "email already exists";
        } else {
            $sql = "INSERT INTO users(name,email,password)VALUES('$name','$email','$hashed_password')";

            if ($conn->query($sql) === true) {
                echo "Data inserted successfully";
            } else {
                echo "error in inserting data" . mysqli_error($conn);
            }
        }
    }
}
?>
<! DOCTYPE HTML>
    <html>

    <head>
        <title>Apex Planet</title>
    </head>

    <body>
        <div>
            <h2>Registeration</h2>
            <form action="register.php" method="post">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">

                    <input type="submit" id="submit" name="submit">
                </div>
            </form>
            <a href="login.php">Login</a>
        </div>
    </body>

    </html>