<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="e.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
  <div class="main">
    <h1>Faculty Page</h1>
    <div class="logout">
        <button class="Logout" onclick="logout()">Logout</button>
    </div>
    <div class="lab">
        <div class="image">
            <h1>Faculty Labs</h1>
            <button class="btn-lay" onclick="layout()">Layout</button>
        </div>
    </div>
    <br>
   
    
<script src="newscript.js"></script>
<script>
    function logout() {
        window.location.href = "login.php"; // Redirect to the login page
    }
    
    function layout() {
        window.location.href = "layout.php"; // Redirect to the layout page
    }
</script>
</body>
</html>
