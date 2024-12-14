<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/college.css">
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
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="senior-table">
        
            <div class="header-section">
                <h2>Student Profile</h2>
                <div class="header-section">
            <select name="course" id="course">
                        <option value="">Role</option>
                        <option value="CS">Senior High</option>
                        <option value="AIS">College</option>
d                    </select>
            <select name="course" id="course">
                        <option value="">Role</option>
                        <option value="CS">Admin</option>
                        <option value="AIS">Teacher</option>
d                    </select>
            </div>

            </div>
            <div class="search-section">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search...">
                    <button onclick="searchTable()">Search</button>
                </div>
            </div>
            <div class="action-buttons">
                <button onclick="copyTable()">Copy</button>
                <button onclick="exportToPDF()">PDF</button>
                <button onclick="exportToExcel()">Excel</button>
                <button onclick="printTable()">Print</button>
            </div>
            <div class="table-section">
                <table id="studentTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>RFID</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>View Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

        require "./connect.php"; // Ensure this file establishes the $conn connection
        

        // Prepare the SQL statement with the corrected column name
        $stmt = $conn->prepare("SELECT `UID`, `Username`, `Email`,`Role`,  `RFID`, `image` FROM `user`");
        
        
        // Execute the statement
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if there are results
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['UID'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['RFID'] . "</td>";
                echo "<td>" . $row['Course'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td><button onclick=\"openRecordModal('" . $row['student name'] . "', '" . $row['ID_number'] . "', '" . $row['Course'] . "', '" . $row['Year'] . "')\">View Profile</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

<div id="recordModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeRecordModal()">&times;</span>
            <div class="student-profile">
                <h2 id="studentName">Student Name</h2>
                <p id="studentId">ID</p>
                <p id="studentCourse">Course</p>
                <p id="studentYear">Year</p>
            </div>
            <div class="attendance-calendar">
                <h3>Attendance Calendar</h3>
                <div id="calendar" class="calendar"></div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        function openRecordModal(name, id, course, year) {
            document.getElementById('studentName').textContent = `Student Name: ${name}`;
            document.getElementById('studentId').textContent = `ID: ${id}`;
            document.getElementById('studentCourse').textContent = `Course: ${course}`;
            document.getElementById('studentYear').textContent = `Year: ${year}`;
            generateCalendar();
            document.getElementById('recordModal').style.display = 'block';
        }

        function closeRecordModal() {
            document.getElementById('recordModal').style.display = 'none';
        }

        function generateCalendar() {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';
            const daysInMonth = 30;

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.textContent = day;
                dayDiv.className = day % 2 === 0 ? 'present' : 'absent';
                calendar.appendChild(dayDiv);
            }
        }
    </script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');   
        }
    </script>
</body>
</html