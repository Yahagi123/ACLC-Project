<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/attendance.css">
</head>
<body>
    <div class="sidebar">
        <div class="head">
            <h2>Recent Attendance</h2>
        </div>
        <ul>
            <li><a href="#">Create Student</a></li>
            <li><a href="#">Edit USN</a></li>
            <li><a href="#">Print</a></li>
        </ul>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="attendance.php"><i class="fas fa-list"></i> Attendance</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Student</a></li>
            <ul class="student_drop">
                <li><a href="Senior.php"><i class="fas fa-user-graduate"></i> Senior High</a></li>
                <li><a href="collage.php"><i class="fas fa-user-graduate"></i> College</a></li>
            </ul>
            <li><a href="#"><i class="fas fa-calendar"></i> Calendar</a></li>
            <li><a href="#"><i class="fas fa-clock"></i> Schedule</a></li>
            <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main_container">
        <div class="header">
            <h2>Recent Attendance</h2>
            <ul>
                <li><a href="#">Cre</a></li>
            </ul>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Student Name</th>
                        <th>USN</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Date Logged</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Rows -->
                    <tr>
                        <td>1</td>
                        <td><img src="path-to-image.jpg" alt="Student Image" style="width: 50px; border-radius: 50%;"></td>
                        <td>John Doe</td>
                        <td>123456</td>
                        <td>Computer Science</td>
                        <td>3rd</td>
                        <td>8:00 AM</td>
                        <td>4:00 PM</td>
                        <td>2024-12-01</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
