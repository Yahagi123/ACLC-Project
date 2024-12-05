<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring - College</title>
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
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: var(--secondary-color);
            color: var(--text-color);
        }

        .header {
            background: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1rem;
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
            margin-bottom: 2rem;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 1rem 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .sidebar ul li a:hover {
            background: var(--accent-color);
        }

        .sidebar ul li a i {
            margin-right: 0.5rem;
        }

        .main_container {
            margin-left: 270px;
            padding: 2rem;
        }

        .content-container {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 1.2rem;
        }

        .student-list {
            margin-top: 1rem;
        }

        .student-list table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        .student-list th, .student-list td {
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }

        .student-list th {
            background: var(--primary-color);
            color: white;
            text-transform: uppercase;
        }

        .student-list tr:nth-child(even) {
            background: #f9f9f9;
        }

        .student-list tr:hover {
            background: var(--accent-color);
            color: white;
        }

        .add-student {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }

        .add-student button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .add-student button:hover {
            background: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <header>CS31</header>
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
            <h2>College Students</h2>
        </div>
        <div class="content-container">
            <div class="add-student">
                <button>Add New Student</button>
            </div>
            <div class="student-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>USN</th>
                            <th>Course</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><img src="path-to-image.jpg" alt="Student Image" style="width: 50px; border-radius: 50%;"></td>
                            <td>Jane Doe</td>
                            <td>123456</td>
                            <td>BSIT</td>
                            <td>3rd</td>
                            <td><button style="background: var(--primary-color); color: white; border: none; border-radius: 5px; padding: 0.3rem 0.5rem; cursor: pointer;">Edit</button></td>
                        </tr>
                        <!-- Additional rows go here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
