<?php
    require "./connect.php";
    $sql = "SELECT  `USN`,`Time_In` FROM `student_create` ORDER BY Time_In DESC";
    $result = $conn->query($sql);
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="attendance.css">
</head>
<body>
<script>
    // Refresh page every 5 seconds
    setInterval(function() {
        location.reload();
    }, 5000);
</script>

    <div class="navigation_bar">
        <button><a href="dashboard.php">Back</a></button>
        <ul>
            <li><a href="#">Senior High</a></li>
            <li><a href="#">Collage</a></li>
            <li><a href="Create.php">Create new Uid Card</a></li>
        </ul>
    </div>
    <table>
        <h2>Attendance Status: Please Scan The RFID</h2>
        <tr>
            <th>Image</th>
            <th>Student Name</th>
            <th>USN</th>
            <th>Course</th>
            <th>Year</th>
            <th>Date</th>
            <th>Time in</th>
            <th>Time Out</th>
        </tr>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo"<tr>";
                    echo "<td>". $row["USN"] ."</td>";
                    echo"<tr>";
                }
            }else {
                echo "<tr><td colspan='2'>No RFID logs found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    // Close the database connection
    $conn->close();
    ?>
    
    <!-- <div class="sidebar">
        <header>CS31</header>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="#">Student</a></li>
                    <div class="student_drop">
                        <li><a href="Senior.php">Senior High</a></li>
                        <li><a href="collage.php">Collage</a></li>
                    </div>
                <li><a href="#">Calendar</a></li>
                <li><a href="#">Schedule</a></li>
                <li><a href="#">Teacher</a></li>
                <li style="background:red;"><a href="logout.php">Logout</a></li>
            </ul>
    </div> -->
</body>
</html>