<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
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
                <li><a href="#">Notification</a></li>
                <li><a href="#">Message</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <header>CS31</header>
        <ul>
            <li><a href="dashboard.php"><img width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/50/home--v1.png" alt="home--v1"/>Home</a></li>
            <li class="dropdown">
                <a href="#"><img width="25" height="25" src="https://img.icons8.com/ios/50/attendance-mark.png" alt="attendance-mark" /> Attendance</a>
                <ul class="student_drop">
                    <li><a href="attendance.php"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/raise-a-hand-to-answer.png" alt="raise-a-hand-to-answer" /> Student Attendance</a></li>
                    <li><a href="collage.php"><img width="24" height="24" src="https://img.icons8.com/fluency-systems-regular/50/training.png" alt="training" /> Teacher Attendance</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#"><img width="24" height="24" src="https://img.icons8.com/parakeet-line/48/student-male.png" alt="student-male" /> Student</a>
            </li>
            <li class="dropdown">
                <a href="#"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/business-report.png" alt="business-report"/> Record</a>
                <ul class="student_drop">
                    <li><a href="Senior.php">Senior High</a></li>
                    <li><a href="collage.php">College</a></li>
                    <li><a href="#">Teacher</a></li>
                    <li><a href="#">Guess</a></li>
                </ul>
            </li>
            <li><a href="Calendar.php"><img width="24" height="24" src="https://img.icons8.com/ios/50/bar-chart--v1.png" alt="bar-chart--v1"/>Reports</a></li>
            <li><a href="teacher.php"><img width="24" height="24" src="https://img.icons8.com/windows/32/training.png" alt="training"/>Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
    <div class="box_container">
        <div class="boxs">
            <h3>School Facilities</h3>
            <h2>4</h2>
        </div>
        <div class="boxs">
            <h3>Today Present</h3>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h3>Today Absent</h3>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h3>Total Student</h3>
            <h2>---</h2>
        </div>
    </div>
    <div class="graph_container">

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
