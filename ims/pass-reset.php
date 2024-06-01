<?php
session_start();
if($_POST) {
    include('database/connection.php');
    
    // Retrieve form data
    $username = $_POST['username'];
    $newPassword = $_POST['Password']; // Assuming the input name is 'Password'

    // Prepare the SQL query to update the password
    $query = 'UPDATE users SET password = :newPassword WHERE email = :username';
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':newPassword', $newPassword);
    $stmt->bindParam(':username', $username);

    // Execute the query
    if ($stmt->execute()) {
        // Password updated successfully
        // Redirect to login page
        header("Location: login.php");
        exit(); // Ensure script stops execution after redirection
    } else {
        echo "Error updating password.";
    }

    // Close statement
    $stmt->closeCursor();
    // No need to close connection for PDO
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="s.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
    <div class="outercont">
        <div class="maintext">
            <h3 id="HTh">Password Reset</h3>
            <form action="pass-reset.php" method="post">
                <div class="inputfield">
                    <i class="fa-regular fa-user"></i>
                    <input type="email" id="username" placeholder="Username" name="username" required>
                </div>
                <div class="inputfield">
                    <i class="fa-regular fa-user"></i>
                    <input type="password" id="Password" placeholder="New Password" name="Password" required>
                </div>
                <br>
                <div>
                    <button type="submit" id="sign">Reset</button>
                    <br>  
                </div>  
            </form>
        </div>
    </div>
    <script src="newscript.js"></script>
</body>
</html>
