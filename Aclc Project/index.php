<?php
$rfid = ''; // Initialize $rfid to avoid "undefined variable" warnings.

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    require "./connect.php";
    $rfid = mysqli_real_escape_string($conn, $_POST['scan']); // Sanitize user input

    if ($rfid !== '') {
        // Fetch data for the scanned USN (student ID)
        $sql2 = "SELECT *, DATE_FORMAT(time_in, '%h:%i %p') AS dates, DATE_FORMAT(time_out, '%h:%i %p') AS datess 
                 FROM student_create WHERE USN = '$rfid'";
        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            foreach ($result2 as $row) {
                if ($row['time_int'] == 1) {
                    // If the student has already clocked in (time_int = 1), clock them out
                    $sqlUpdate2 = "UPDATE student_create SET time_out = NOW(), time_int = 0 WHERE USN = '$rfid'";
                    mysqli_query($conn, $sqlUpdate2);
                } elseif ($row['time_int'] == 0) {
                    // If the student has clocked out (time_int = 0), clock them in
                    $sqlUpdate = "UPDATE student_create SET time_in = NOW(), time_out = NULL, time_int = 1 WHERE USN = '$rfid'";
                    mysqli_query($conn, $sqlUpdate);
                }
            }

            // Insert into the rfid_logs table
            $studentName = mysqli_real_escape_string($conn, $row['student name']);
            $course = mysqli_real_escape_string($conn, $row['Course']);
            $year = mysqli_real_escape_string($conn, $row['Year']);
            $image = isset($row['Image']) ? mysqli_real_escape_string($conn, $row['Image']) : 'path/to/default-image.jpg';
            $timeIn = date('Y-m-d H:i:s'); // Assuming the current time as the time of logging
            $timeOut = $row['time_out'] ? $row['time_out'] : NULL;
            $dateLogged = date('Y-m-d');

            $sqlInsertLog = "INSERT INTO rfid_logs (student_name, USN, course, year, time_in, time_out, date_logged, image) 
                             VALUES ('$studentName', '$rfid', '$course', '$year', '$timeIn', '$timeOut', '$dateLogged', '$image')";
            mysqli_query($conn, $sqlInsertLog);
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
                if ($rfid !== '' && isset($row)) { // Display only one record
                    ?>
                    <p>Name: <?= htmlspecialchars($row['student name']) ?></p>
                    <p>USN: <?= htmlspecialchars($row['USN']) ?></p>
                    <p>Course: <?= htmlspecialchars($row['Course']) ?></p>
                    <p>Year: <?= htmlspecialchars($row['Year']) ?></p>
                    <?php
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
                <td>Time In <br> <?= htmlspecialchars($rowDate['dates']) ?> </td>
                <td>Time Out <br> 
                    <?php 
                    if ($rowDate['datess'] == NULL) {
                        echo '---';  // Show placeholder when time_out is NULL
                    } else {
                        echo htmlspecialchars($rowDate['datess']);
                    }
                    ?>
                </td>
                <td>Date Logged<br><?= date("d/m/Y") ?> </td>
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
                    <td>Date</td> <!-- Added Date column -->
                </tr>
                <?php
                // Fetch only 4 recent logs from rfid_logs table
                $sqlHistory = "SELECT * FROM rfid_logs ORDER BY date_logged DESC LIMIT 4"; // Fetch top 4 records
                $historyResult = mysqli_query($conn, $sqlHistory);
                if (mysqli_num_rows($historyResult) > 0) {
                    while ($historyRow = mysqli_fetch_assoc($historyResult)) {
                        $timeIn = date('Y-m-d H:i:s', strtotime($historyRow['time_in']));
                        $timeOut = ($historyRow['time_out'] == NULL) ? '---' : date('Y-m-d H:i:s', strtotime($historyRow['time_out']));
                        $dateLogged = date('Y-m-d', strtotime($historyRow['date_logged'])); // Assuming date_logged stores the log date
                        ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($historyRow['image']) ?>" alt="Student Image" width="50"></td>
                            <td><?= htmlspecialchars($historyRow['student_name']) ?></td>
                            <td><?= htmlspecialchars($historyRow['USN']) ?></td>
                            <td><?= htmlspecialchars($historyRow['course']) ?></td>
                            <td><?= htmlspecialchars($historyRow['year']) ?></td>
                            <td><?= $timeIn ?></td>
                            <td><?= $timeOut ?></td>
                            <td><?= $dateLogged ?></td> <!-- Displaying the Date -->
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8">No recent logs found.</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>