<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sidebar.css">
</head>
<body>
    <div class="header">
        <span></span>
    </div>
<script src="https://kit.fontawesome.com/cb73975b1a.js" crossorigin="anonymous"></script>
    <div class="sidebar">
        <header>CS31
            <span></span>
        </header>
            <ul>
                <li><a href="dashboard.php"><i class="fa-regular fa-house"></i>Home</a></li>
                <li><a href="attendance.php"><i class="fa-regular fa-rectangle-list"></i>Attendance</a></li>
                <li><a href="#"><i class="fa-regular fa-square"></i>Student</a></li>
                    <div class="student_drop">
                        <li><a href="Senior.php"><i class="fa-solid fa-user-graduate"></i>Senior High</a></li>
                        <li><a href="collage.php"><i class="fa-solid fa-user-graduate"></i>Collage</a></li>
                    </div>
                <li><a href="#"><i class="fa-solid fa-calendar-days"></i>Calendar</a></li>
                <li><a href="#"><i class="fa-solid fa-calendar-days"></i>Schedule</a></li>
                <li><a href="#"><i class="fa-solid fa-chalkboard-user"></i>Teacher</a></li>
                <li style="background:red;"><a href="logout.php">Logout</a></li>
            </ul>
    </div>
    <div class="box_container">
        <div class="boxs">
            <h2>Total Of School Facilities</h2>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h2>Total of Senior High</h2>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h2>Total of Collage</h2>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h2>Total of Teacher </h2>
            <h2>---</h2>
        </div>

    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Alice</td><td>25</td></tr>
                <tr><td>2</td><td>Bob</td><td>30</td></tr>
                <tr><td>3</td><td>Charlie</td><td>35</td></tr>
                <tr><td>4</td><td>Diana</td><td>28</td></tr>
                <tr><td>5</td><td>Eve</td><td>40</td></tr>
            </tbody>
        </table>
    </div>

</body>
</html>