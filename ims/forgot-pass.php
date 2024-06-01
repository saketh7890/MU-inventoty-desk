<?php
session_start();
if($_POST) {
    include('database/connection.php');
    $username = $_POST['email']; // Assuming this is the email
    $dob = $_POST['dob'];
    $f_place = $_POST['place']; // Assuming the input name is 'place'

    //Prepare the SQL query with placeholders to prevent SQL injection
    $query = 'SELECT * FROM users WHERE email=:username AND dob=:dob AND f_place=:f_place';
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':f_place', $f_place);

    // Execute the query
    $stmt->execute();

    // Check if any rows were returned
    if($stmt->rowCount() > 0){
        header('Location:pass-reset.php');
        // User found, redirect to pass-reset.php
    } else {
        // User not found, handle error
        $error_message = 'Invalid email, date of birth, or favorite place.';
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
  <title>Reset Password</title>
  <link rel="stylesheet" href="s.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>
<body>
  <div class="outercont">
    <div class="maintext">
      <h3>Reset Password</h3>
      <form action="forgot-pass.php" method="post">
        <div class="inputfield">
          <i class="fa-regular fa-user"></i>
          <input type="email" id="email" placeholder="Email" name="email" required>
        </div>
        <br>
        <div class="inputfield">
          <i class="fa-regular fa-user"></i>
          <input type="date" id="dob" placeholder="DOB" name="dob" required>
        </div>
        <br>
        <div class="inputfield">
          <i class="fa-regular fa-user"></i>
          <input type="text" id="place" placeholder="Favourite Place" name="place" required>
        </div>
        <br>
        <div>
          <button type="submit" id="sign">Submit</button>
        </div> 
      </form>
    </div>
  </div>
  <script src="newscript.js"></script>
</body>
</html>
