<?php
$rfid = ''; // Initialize $rfid to avoid "undefined variable" warnings.

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    require "./connect.php";
    $rfid = mysqli_real_escape_string($conn, $_POST['scan']); // Sanitize user input

    if ($rfid !== '') {
        // Fetch data for the scanned USN (student ID)
        $sql2 = "SELECT *, DATE_FORMAT(time_in, '%h:%i %p') AS dates, DATE_FORMAT(time_out, '%h:%i %p') AS datess 
                 FROM `student_create` WHERE USN = '$rfid'";
        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            foreach ($result2 as $row) {
                // Check if the student has already clocked in
                if ($row['time_int'] == 1) {
                    // If clocked in (time_int = 1), update time_out
                    $sqlUpdate2 = "UPDATE student_create SET time_out = NOW(), time_int = 0 WHERE USN = '$rfid'";
                    mysqli_query($conn, $sqlUpdate2);
                } elseif ($row['time_int'] == 0) {
                    // If clocked out (time_int = 0), update time_in
                    $sqlUpdate = "UPDATE student_create SET time_in = NOW(), time_int = 1 WHERE USN = '$rfid'";
                    mysqli_query($conn, $sqlUpdate);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cb73975b1a.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="header">
        <span>Attendance System</span>
        <ul>
            <li><a href="scan.php"><i class="fa-solid fa-eye"></i>Scan</a></li>
            <li><a href="#"><i class="fa-solid fa-circle-exclamation"></i>About</a></li>
            <li><a href="SignIn.php"><i class="fa-solid fa-user"></i>Sign In</a></li>
        </ul>
    </div>
    
    <!-- Clock -->
    <div class="clock_container">
        <span id="hours">00</span> :
        <span id="minutes">00</span> :
        <span id="seconds">00</span>    
        <span id="ampm">AM</span>
    </div>
    <script src="script.js"></script>
    
    <div class="container">
        <div class="student_info">
            <span>
                <td>
                    <img src="<?= isset($row['Image']) ? htmlspecialchars($row['Image']) : 'path/to/default-image.jpg' ?>" alt="Student Image" width="50">
                </td>
            </span>
            <div class="student">
                <?php 
                if ($rfid !== '' && isset($result2) && mysqli_num_rows($result2) > 0) {
                    foreach ($result2 as $row2) {
                        ?>
                        <p>Name: <?= htmlspecialchars($row2['student name']) ?></p>
                        <p>USN: <?= htmlspecialchars($row2['USN']) ?></p>
                        <p>Course: <?= htmlspecialchars($row2['Course']) ?></p>
                        <p>Year: <?= htmlspecialchars($row2['Year']) ?></p>
                        <?php
                    }
                } else {
                    ?>
                    <p>Name:</p>
                    <p>USN:</p>
                    <p>Course:</p>
                    <p>Year:</p>
                    <?php
                }
                ?>
            </div>
            
            <table>
                <?php 
                if ($rfid !== '' && isset($result2) && mysqli_num_rows($result2) > 0) {
                    foreach ($result2 as $rowDate) {
                        ?> 
                        <tr>
                            <td>Time In <br> <?= htmlspecialchars($rowDate['dates']) ?></td>
                            <td>Time Out <br> <?= htmlspecialchars($rowDate['datess']) ?></td>
                            <td>Date Logged<br><?= date("Y-m-d") ?> </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?> 
                    <tr>
                        <td>Time In</td>
                        <td>Time Out</td>
                        <td>Date Logged</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        
        <!-- RFID -->
        <form action="index.php" method="post" class="scanner">
            <input type="text" name="scan" id="scan" placeholder="Scan Your ID Here">
        </form>
        
        <div class="history">
            <table>
                <th>Recent</th>
                <tr>
                    <td>Image</td>
                    <td>Student Name</td>
                    <td>Student Id</td>
                    <td>Course</td>
                    <td>Year</td>
                    <td>Time In</td>
                    <td>Time Out</td>
                    <td>Date Logged</td>
                </tr>
                <?php
                if ($rfid !== '' && isset($result2) && mysqli_num_rows($result2) > 0) {
                    foreach ($result2 as $row) {
                        // Check if the image exists, if not, use a placeholder
                        $imagePath = isset($row['Image']) && file_exists($row['Image']) ? $row['Image'] : 'path/to/default-image.jpg';
                        ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($imagePath) ?>" alt="Student Image" width="50"></td>
                            <td><?= htmlspecialchars($row['student name']) ?></td>
                            <td><?= htmlspecialchars($row['USN']) ?></td>
                            <td><?= htmlspecialchars($row['Course']) ?></td>
                            <td><?= htmlspecialchars($row['Year']) ?></td>
                            <td><?= htmlspecialchars($row['dates']) ?></td>
                            <td><?= htmlspecialchars($row['datess']) ?></td>
                            <td><?= date("Y-m-d") ?></td>
                        </tr>
                        <?php
                    }
                }
