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
                // Check if the student has already clocked in (time_int = 1)
                if ($row['time_int'] == 1) {
                    // If the student has already clocked in, clock them out
                    $sqlUpdate2 = "UPDATE student_create SET time_out = NOW(), time_int = 0 WHERE USN = '$rfid'";
                    mysqli_query($conn, $sqlUpdate2);
                    $attendanceStatus = 'Clocked Out';
                } else {
                    // If the student has clocked out (time_int = 0), check for late attendance
                    $currentTime = new DateTime();
                    $cutoffTime = new DateTime('09:00 AM'); // Define cutoff time (9:00 AM)
                    if ($currentTime > $cutoffTime) {
                        $attendanceStatus = 'Late';
                    } else {
                        $attendanceStatus = 'Present';
                    }
                    
                    // Clock them in and update the status
                    $sqlUpdate = "UPDATE student_create SET time_in = NOW(), time_out = NULL, time_int = 1 WHERE USN = '$rfid'";
                    mysqli_query($conn, $sqlUpdate);
                }
            }

            // Insert into the rfid_logs table
            $lastName = mysqli_real_escape_string($conn, $row['Last Name']);
            $firstName = mysqli_real_escape_string($conn, $row['First Name']);
            $middleName = mysqli_real_escape_string($conn, $row['Middle Name']);
            $studentName = "$lastName, $firstName $middleName";
            $course = mysqli_real_escape_string($conn, $row['Course']);
            $year = mysqli_real_escape_string($conn, $row['Year']);
            $image = isset($row['Image']) ? mysqli_real_escape_string($conn, $row['Image']) : 'path/to/default-image.jpg';
            $timeIn = date('Y-m-d H:i:s'); // Assuming the current time as the time of logging
            $timeOut = $row['time_out'] ? $row['time_out'] : NULL;
            $dateLogged = date('Y-m-d');

            // Add attendance status (Late or Absent if not clocked in)
            if (empty($attendanceStatus)) {
                $attendanceStatus = 'Absent';
            }

            $sqlInsertLog = "INSERT INTO rfid_logs (student_name, USN, course, year, time_in, time_out, date_logged, image) 
                             VALUES ('$studentName', '$rfid', '$course', '$year', '$timeIn', '$timeOut', '$dateLogged', '$image')";
            mysqli_query($conn, $sqlInsertLog);
        }   
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cb73975b1a.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .full-screen-container {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-gray-100 h-full">
    <?php
    require "./connect.php";

    // Initialize $rfid variable
    $rfid = '';
    $row = null;

    if (isset($_POST['scan'])) {
        $rfid = $_POST['scan'];
        $query = "SELECT * FROM student_create WHERE USN = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $rfid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }
    ?>

    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="./uploads/logo.png" alt="" width="40px">
                        <h1 class="text-2xl font-bold text-blue-600 ml-5">Attendance System</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="SignIn.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center">
                        <i class="fa-solid fa-user mr-2"></i>Sign In</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="full-screen-container max-w-full mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 h-full">
            <!-- Digital Clock -->
            <div class="bg-white shadow-lg rounded-lg p-4 text-center md:col-span-3">
                <div class="text-4xl font-bold text-blue-600">
                    <span id="hours">00</span> :
                    <span id="minutes">00</span> :
                    <span id="seconds">00</span>    
                    <span id="ampm" class="text-2xl">AM</span>
                </div>
            </div>

            <!-- Student Information -->
            <div class="bg-white shadow-lg rounded-lg p-4 md:col-span-2 h-full">
                <div class="flex items-center h-full space-x-6">
                    <img src="<?= isset($row['Image']) ? htmlspecialchars($row['Image']) : 'path/to/default-image.jpg' ?>" 
                         alt="Student Image" 
                         class="w-48 h-48 rounded-full object-cover shadow-xl">
                    
                    <div class="student-details flex-grow">
                        <?php if (!empty($rfid) && isset($row)) { ?>
                            <h2 class="text-2xl font-bold text-gray-800 mb-3">
                                <?= htmlspecialchars($row['Last Name']) ?>, <?= htmlspecialchars($row['First Name']) ?> <?= htmlspecialchars($row['Middle Name']) ?>
                            </h2>
                            <div class="space-y-2">
                                <p class="text-lg text-gray-600"><strong>USN:</strong> <?= htmlspecialchars($row['USN']) ?></p>
                                <p class="text-lg text-gray-600"><strong>Course:</strong> <?= htmlspecialchars($row['Course']) ?></p>
                                <p class="text-lg text-gray-600"><strong>Section:</strong> <?= htmlspecialchars($row['Section']) ?></p>
                                <p class="text-lg text-gray-600"><strong>Year:</strong> <?= htmlspecialchars($row['Year']) ?></p>
                            </div>
                        <?php } else { ?>
                            <h2 class="text-2xl font-semibold text-gray-400">No Student Selected</h2>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- RFID Scanner -->
            <div class="bg-white shadow-lg rounded-lg p-4 h-full flex items-center">
                <form action="index.php" method="post" class="flex w-full" id="rfidForm">
                    <input 
                        type="text" 
                        name="scan" 
                        id="scan" 
                        placeholder="Scan Your ID Here" 
                        class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        oninput="autoSubmit()" 
                        autofocus 
                    >
                </form>
            </div>

            <!-- Today's Attendance -->
            <div class="bg-white shadow-lg rounded-lg p-4 md:col-span-3">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Today's Attendance</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 text-left">Time In</th>
                    <th class="py-2 px-4 text-left">Time Out</th>
                    <th class="py-2 px-4 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($rfid) && isset($result2) && mysqli_num_rows($result2) > 0) {
                    foreach ($result2 as $rowDate) { ?> 
                        <tr>
                            <td class="py-2 px-4"><?= htmlspecialchars($rowDate['dates']) ?></td>
                            <td class="py-2 px-4">
                                <?= $rowDate['datess'] == NULL ? '<span class="text-gray-400">---</span>' : htmlspecialchars($rowDate['datess']) ?>
                            </td>
                            <td class="py-2 px-4"><?= date("d/m/Y") ?></td>
                        </tr>
                    <?php }
                } else { ?> 
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">No attendance records</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Recent Logs - Full Width -->
<div class="bg-white shadow-lg rounded-lg p-4 md:col-span-3">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Recent Activity</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4">Image</th>
                    <th class="py-2 px-4">Name</th>
                    <th class="py-2 px-4">Student ID</th>
                    <th class="py-2 px-4">Course</th>
                    <th class="py-2 px-4">Year</th>
                    <th class="py-2 px-4">Time In</th>
                    <th class="py-2 px-4">Time Out</th>
                    <th class="py-2 px-4">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sqlHistory = "SELECT student_name, USN, course, year, 
                                      DATE_FORMAT(CONVERT_TZ(time_in, '+00:00', '+08:00'), '%h:%i %p') AS formatted_time_in, 
                                      DATE_FORMAT(CONVERT_TZ(time_out, '+00:00', '+08:00'), '%h:%i %p') AS formatted_time_out, 
                                      DATE_FORMAT(CONVERT_TZ(date_logged, '+00:00', '+08:00'), '%d/%m/%Y') AS formatted_date_logged, 
                                      image 
                               FROM rfid_logs 
                               ORDER BY time_in DESC 
                               LIMIT 4";
                $historyResult = mysqli_query($conn, $sqlHistory);

                if (mysqli_num_rows($historyResult) > 0) {
                    while ($historyRow = mysqli_fetch_assoc($historyResult)) {
                        $timeIn = $historyRow['formatted_time_in'] ?: '<span class="text-gray-400">---</span>';
                        $timeOut = $historyRow['formatted_time_out'] ?: '<span class="text-gray-400">---</span>';
                        $dateLogged = $historyRow['formatted_date_logged'];
                        ?>
                        <tr class="border-b">
                            <td class="py-2 px-4">
                                <img src="<?= htmlspecialchars($historyRow['image']) ?>" 
                                     alt="Student Image" 
                                     class="w-12 h-12 rounded-full object-cover">
                            </td>
                            <td class="py-2 px-4"><?= htmlspecialchars($historyRow['student_name']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($historyRow['USN']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($historyRow['course']) ?></td>
                            <td class="py-2 px-4"><?= htmlspecialchars($historyRow['year']) ?></td>
                            <td class="py-2 px-4"><?= $timeIn ?></td>
                            <td class="py-2 px-4"><?= $timeOut ?></td>
                            <td class="py-2 px-4"><?= $dateLogged ?></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="8" class="py-4 text-center text-gray-500">No recent logs found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>



    <script>
        // Digital Clock Script
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;
            hours = hours.toString().padStart(2, '0');

            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;
            document.getElementById('ampm').textContent = ampm;
        }

        // Update clock every second
        setInterval(updateClock, 1000);
        updateClock(); // Initial call
    </script>
</body>
</html>