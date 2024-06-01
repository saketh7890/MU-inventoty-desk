<?php
session_start();

$servername = 'localhost';
$username = 'root';
$password = ''; // <-- Provide your database password here

// Connecting to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=project_data", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $computer = $_POST['computer'];
    $time_slot = $_POST['time_slot'];

    // Prepare SQL query to check the status and time of the selected computer
    $check_query = "SELECT status, time FROM computer WHERE id=:computer";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':computer', $computer);
    $check_stmt->execute();
    $row = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $status = $row['status'];
        $time = $row['time'];

        // Check if status is 'available' or time is different
        if ($status == 'available' || $time != $time_slot) {
            // Update the status and time if necessary
            $query = "UPDATE computer SET status='not available', time=:time_slot WHERE id=:computer";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':computer', $computer);
            $stmt->bindParam(':time_slot', $time_slot);
            
            try {
                $stmt->execute();
                header("Location: login.php"); // Redirect to login page after success
                exit; // Ensure no further code is executed
            } catch (PDOException $e) {
                $message = "<div class='message3'>Error updating status: " . $e->getMessage() . "</div>";
            }
        } else {
            $message = "<div class='message1'>Status is already 'not available' and time slot is the same.</div>";
        }
    } else {
        $message = "<div class='message3'>Computer not found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allotment</title>
    <link rel="stylesheet" href="le.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>

        </style>
</head>
<body>
    <div class="whole">
        <h1 class="heading">Allotment</h1>

        <!-- Display message at the bottom -->
        <form action="layout.php" method="post">
            <div class="compartments">
                <select name="computer" id="computerList">
                    <option value="" disabled selected>Select a computer</option>
                    <option value="computer1">computer 1</option>
                    <option value="computer2">computer 2</option>
                    <option value="computer3">computer 3</option>
                    <option value="computer4">computer 4</option>
                    <option value="computer5">computer 5</option>
                    <option value="computer6">computer 6</option>
                    <option value="computer7">computer 7</option>
                    <option value="computer8">computer 8</option>
                </select>
            </div>

            <div class="tmeda">
                <div class="time-slots">
                    <div class="slot">
                        <input type="radio" name="time_slot" value="9:00 AM - 11:00 AM" id="slot1">
                        <label for="slot1">9:00 AM - 11:00 AM</label>
                    </div>
                    <div class="slot">
                        <input type="radio" name="time_slot" value="11:00 AM - 1:00 PM" id="slot2">
                        <label for="slot2">11:00 AM - 1:00 PM</label>
                    </div>
                    <div class="slot">
                        <input type="radio" name="time_slot" value="1:00 PM - 3:00 PM" id="slot3">
                        <label for="slot3">1:00 PM - 3:00 PM</label>
                    </div>
                    <div class="slot">
                        <input type="radio" name="time_slot" value="3:00 PM - 5:00 PM" id="slot4">
                        <label for="slot4">3:00 PM - 5:00 PM</label>
                    </div>
                </div>
            </div>
            <button type="submit">Submit</button>
        </form>
        
        <!-- Display the message at the bottom -->
        <?php if (!empty($message)) echo $message; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
