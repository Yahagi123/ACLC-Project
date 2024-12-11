<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="sidebar.css">
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
            <li><a href="dashboard.php"><img width="24" height="24" src="https://img.icons8.com/material-sharp/24/dashboard-layout.png" alt="dashboard-layout" /> Home</a></li>
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
                <a href="#"><img width="24" height="24" src="https://img.icons8.com/material-outlined/24/attendance-mark.png" alt="attendance-mark" /> Record</a>
                <ul class="student_drop">
                    <li><a href="Senior.php"><i class="fas fa-user-graduate"></i> Senior High</a></li>
                    <li><a href="collage.php"><i class="fas fa-user-graduate"></i> College</a></li>
                    <li><a href="#">Teacher</a></li>
                    <li><a href="#">Guess</a></li>
                </ul>
            </li>
            <li><a href="Calendar.php"><i class="fas fa-calendar"></i> Analytics</a></li>
            <li><a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Welcome to the Attendance System Admin Panel</h1>
        <p>Manage your attendance system efficiently.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
    </script>
</body>
</html>
