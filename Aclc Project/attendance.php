<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="attendance.css">
</head>
<body>
    <div class="navbar">
        <div class="left-section">
            <h2>Attendance System Admin</h2>
            <div class="burger" onclick="toggleSidebar()">
                <img width="25" height="25" src="https://img.icons8.com/ios-filled/50/menu--v1.png" alt="menu" />
            </div>
        </div>
        <div class="nav-links">
            <ul>
                <li><a href="#">Refresh</a></li>
                <li><a href="#">Notification</a></li>
                <li><a href="#">Message</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <header>CS31</header>
        <ul>
            <li><a href="dashboard.php"><img width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/50/home--v1.png" alt="home--v1"/><span>Dashboard</span></a></li>
            <li class="dropdown">
                <a href="#"><img width="25" height="25" src="https://img.icons8.com/ios/50/attendance-mark.png" alt="attendance-mark" /><span>Attendance</span></a>
                <ul class="student_drop">
                    <li><a href="attendance.php"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/raise-a-hand-to-answer.png" alt="raise-a-hand-to-answer" /><span>Student Attendance</span></a></li>
                    <li><a href="collage.php"><img width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/50/training.png" alt="training" /><span>Teacher Attendance</span></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#"><img width="24" height="24" src="https://img.icons8.com/parakeet-line/48/student-male.png" alt="student-male" /><span>Student</span></a>
            </li>
            <li class="dropdown">
                <a href="#"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/business-report.png" alt="business-report"/><span>Records</span></a>
                <ul class="student_drop">
                    <li><a href="Senior.php">Senior High</a></li>
                    <li><a href="collage.php">College</a></li>
                    <li><a href="#">Teacher</a></li>
                    <li><a href="#">Guess</a></li>
                </ul>
            </li>
            <li><a href="Calendar.php"><img width="24" height="24" src="https://img.icons8.com/ios/50/bar-chart--v1.png" alt="bar-chart--v1"/><span>Reports</span></a></li>
            <li><a href="teacher.php"><img width="24" height="24" src="https://img.icons8.com/windows/32/training.png" alt="training"/><span>Teacher</span></a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="content-selecting">
        <h2>Student Attendance</h2>
        <p>dashboard/attendance/studet_attendance</p>
        <div class="button-navbar">
            <button>Home</button>
            <button>About</button>
            <button>Services</button>
            <button>Contact</button>
        </div>  
        </div>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');   
        }
    </script>
</body>
</html>
