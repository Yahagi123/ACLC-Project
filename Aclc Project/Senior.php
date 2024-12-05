<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #f4f4f4;
            --text-color: #333;
            --accent-color: #FF6F61;
        }

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: var(--secondary-color);
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--primary-color);
            position: fixed;
            top: 0;
            left: 0;
            padding: 2rem 1rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar header {
            font-size: 1.5rem;
            color: white;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 1rem 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            padding: 0.8rem;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .sidebar ul li a:hover {
            background: var(--accent-color);
        }

        .sidebar ul li a i {
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        .student_drop {
            margin-left: 1rem;
            padding-left: 0.5rem;
            border-left: 2px solid rgba(255, 255, 255, 0.5);
        }

        .student_drop li a {
            font-size: 0.9rem;
        }

        .logout {
            background: var(--accent-color) !important;
            padding: 0.8rem;
            border-radius: 5px;
            text-align: center;
        }

        .logout a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .logout:hover {
            background: #e45b50;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <header>CS31</header>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="attendance.php"><i class="fas fa-list"></i>Attendance</a></li>
            <li>
                <a href="#"><i class="fas fa-users"></i>Student</a>
                <ul class="student_drop">
                    <li><a href="Senior.php"><i class="fas fa-user-graduate"></i>Senior High</a></li>
                    <li><a href="collage.php"><i class="fas fa-user-graduate"></i>College</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fas fa-calendar-alt"></i>Calendar</a></li>
            <li><a href="#"><i class="fas fa-clock"></i>Schedule</a></li>
            <li><a href="#"><i class="fas fa-chalkboard-teacher"></i>Teacher</a></li>
            <li class="logout"><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
</body>
</html>
