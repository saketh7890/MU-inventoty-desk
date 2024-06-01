<?php
session_start();
if ($_POST) {
    include('database/connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query with placeholders to prevent SQL injection
    $query = 'SELECT * FROM users WHERE email=:username AND password=:password';
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Execute the query
    $stmt->execute();

    // Check if any rows were returned
    if ($stmt->rowCount() > 0) {
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $status = $user['status'];

        // Check the user's status and redirect accordingly
        if ($status == 'student') {
            header('Location: Homepage.php');
        } elseif ($status == 'faculty') {
            header('Location: faculty.php');
        }

        // Stop further execution
        die;
    } else {
        // User not found, handle error
        $error_message = 'Please make sure that username and password are correct.';
        echo $error_message;
    }

    // Stop further execution
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="s.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
    <div class="outercont">
        <div class="maintext">
            <h3 id="HTh">Welcome! Please Sign In.</h3>
            <form action="login.php" method="post">
                <div class="inputfield">
                    <i class="fa-regular fa-user"></i>
                    <input type="email" id="username" placeholder="Username" name="username">
                </div>
                <br>
                <div class="inputfield">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" id="pass" placeholder="Password" name="password">
                </div>
                <div>
                    <p id="para">.</p>
                </div>
                <div>
                    <button id="sign" onclick="func()">Sign In</button>
                    <br>
                </div>
                <a href="forgot-pass.php">Forgot Password</a>
            </form>
        </div>
    </div>
    <script src="newscript.js"></script>
</body>
</html>
