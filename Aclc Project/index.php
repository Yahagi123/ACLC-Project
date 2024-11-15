<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID ATTTENDANCE MONITORING SYSTEM</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <script>
        setInterval(function() {
        location.reload();
    }, 5000);
    </script>
    <div class="header">
        <span>Attendance System</span>
        <ul>
            <li><a href="#">Blog</a></li>
            <li><a href="#">About</a></li>
            <li><a href="SignIn.php">Sign In</a></li>
        </ul>
    </div>
    <!-- RFID -->
     <div class="container">
     <form id="rfidForm" action="index.php" method="post">
        <input type="text" id="cardID" name="cardID" placeholder="Scan Card" autofocus>
    </form>
     </div>
</body>
</html>