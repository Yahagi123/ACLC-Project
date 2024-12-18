<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <li><a href="Guess_record.php">Guess</a></li>
                </ul>
            </li>
            <li><a href="Report.php"><img width="24" height="24" src="https://img.icons8.com/ios/50/bar-chart--v1.png" alt="bar-chart--v1"/><span>Reports</span></a></li>
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
            <canvas id="pieChart" width="400" height="200"></canvas>
        </div>
        <div class="most_review">
            <canvas id="diagonalChart" width="400" height="200"></canvas>
        </div>
    </div>
    <div class="content-table">
        <div class="table_container"></div>
    </div>
    <div class="content-calendar">
        <div class="calendar-container"></div>
    </div>

    <script>
        // Pie chart configuration
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    label: 'Attendance Overview',
                    data: [50, 30, 20], // Replace with dynamic data if needed
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(255, 205, 86, 0.6)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Diagonal line chart configuration
        // Diagonal bar chart configuration
// Horizontal bar chart configuration
const ctxDiagonal = document.getElementById('diagonalChart').getContext('2d');
const diagonalChart = new Chart(ctxDiagonal, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [{
            label: 'Monthly Attendance',
            data: [10, 20, 30, 40, 50], // Replace with dynamic data if needed
            backgroundColor: [
                'rgba(54, 162, 235, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 205, 86, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y', // Makes the bar chart horizontal
        plugins: {
            legend: {
                position: 'top',
            },
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Attendance Count'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Months'
                }
            }
        }
    }
});


    </script>
</body>
</html>
