<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<<<<<<< Updated upstream
    <link rel="stylesheet" href="attendance.css">
=======
<<<<<<< HEAD
    <link rel="stylesheet" href="css/attendance.css">
=======
    <link rel="stylesheet" href="attendance.css">
>>>>>>> dd02decfc3014493abd6506852e4df3c0ee7c55b
>>>>>>> Stashed changes
</head>
<body>
    <div class="navbar">
        <div class="left-section">
            <img src="./uploads/logo.png" alt="" width="40px" style="margin-right: 10px;">
            <h2>ACLC Administrator</h2>
            <div class="burger" onclick="toggleSidebar()">
                <img width="25" height="25" src="https://img.icons8.com/ios-filled/50/menu--v1.png" alt="menu" />
            </div>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="#"><img width="30" height="30" src="https://img.icons8.com/ios/50/refresh.png" alt="refresh"/></a></li>
                <li><a href="#"><img width="30" height="30" src="https://img.icons8.com/ios/50/appointment-reminders.png" alt="appointment-reminders"/></a></li>
                <li><a href="#"><img width="30" height="30" src="https://img.icons8.com/windows/32/chat.png" alt="chat"/></a></li>
                <li><a href="#"><img width="30" height="30" src="https://img.icons8.com/windows/32/gender-neutral-user.png" alt="gender-neutral-user"/></a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <header>CS31</header>
        <ul>
            <li><a href="dashboard.php"><img width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/50/home--v1.png" alt="home--v1"/><span>Dashboard</span></a></li>
            <li class="dropdown">
                <a href=""><img width="25" height="25" src="https://img.icons8.com/ios/50/attendance-mark.png" alt="attendance-mark" /><span>Attendance</span></a>
                <ul class="student_drop">
                    <li><a href="attendance.php"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/raise-a-hand-to-answer.png" alt="raise-a-hand-to-answer" /><span>Student Attendance</span></a></li>
                    <li><a href="Teacher_attendance.php"><img width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/50/training.png" alt="training" /><span>Teacher Attendance</span></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="student.php"><img width="24" height="24" src="https://img.icons8.com/parakeet-line/48/student-male.png" alt="student-male" /><span>Student</span></a>
            </li>
            <li class="dropdown">
                <a href="#"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/business-report.png" alt="business-report"/><span>Records</span></a>
                <ul class="student_drop">
                    <li><a href="Senior_record.php">Senior High</a></li>
                    <li><a href="college_record.php">College</a></li>
                    <li><a href="teacher_record.php">Teacher</a></li>
                    <li><a href="Guess_record.php">School</a></li>
                </ul>
            </li>
            <li><a href="Report.php"><img width="24" height="24" src="https://img.icons8.com/ios/50/bar-chart--v1.png" alt="bar-chart--v1"/><span>Reports</span></a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
<<<<<<< Updated upstream
=======
<<<<<<< HEAD
        <div class="attendance-section" id="teacher-attendance">
            <h2>Student Attendance</h2>
            <div class="navigation">
                <ul>
                    <li><a href="Create.php"><img width="22" height="22" src="https://img.icons8.com/windows/32/plus-math.png" alt="plus-math"/>Create Student</a></li>
                    <li><a href="Rfid.php"><img width="22" height="22" src="https://img.icons8.com/windows/32/red-yellow-cards.png" alt="red-yellow-cards"/>Rfid Card</a></li>
                </ul>
            </div>
            <div class="table-controls">
                <select id="teacher-row-count">
                    <option value="10">10 Entries</option>
                    <option value="20">20 Entries</option>
                    <option value="50">50 Entries</option>
                </select>
                <input type="text" id="teacher-search" placeholder="Search teachers...">
            </div>
            <table id="teacher-table">
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Name</th>
                        <th>RFID</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Current Date</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody id="teacher-table-body">
                    <?php
                     require "./connect.php";       
                    // Fetch RFID log data from the database
                    $sql = "SELECT id, student_name, USN, course, year, time_in, time_out, date_logged,attendance_status ,image,RFID FROM rfid_logs LIMIT 10";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Output data for each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['student_name'] . "</td>";
                            echo "<td>" . $row['RFID'] . "</td>";
                            echo "<td>" . $row['course'] . "</td>";
                            echo "<td>" . $row['year'] . "</td>";
                            echo "<td>" . $row['time_in'] . "</td>";
                            echo "<td>" . $row['time_out'] . "</td>";
                            echo "<td>" . $row['date_logged'] . "</td>";
                             echo "<td>" . $row['attendance_status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
=======
>>>>>>> Stashed changes
        <div class="content-selecting">
        <h2>Student Attendance</h2>
        <p>dashboard/attendance/studet_attendance</p>
        <div class="button-navbar">
            <button>Home</button>
            <button>About</button>
            <button>Services</button>
            <button>Contact</button>
        </div>  
<<<<<<< Updated upstream
=======
>>>>>>> dd02decfc3014493abd6506852e4df3c0ee7c55b
>>>>>>> Stashed changes
        </div>
    </div>

    <div id="current-time" class="current-time"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');   
        }
    </script>
</body>
</html