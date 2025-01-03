<?php
require "./connect.php";

// Query to count the number of college students
$query = "SELECT COUNT(*) AS college_count FROM student_create WHERE Year = 'College' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$college_count = $row['college_count']; 

// Query to count the number of Senior High students
$query = "SELECT COUNT(*) AS senior_count FROM student_create WHERE Year = 'Senior' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$senior_count = $row['senior_count'];

// Query to get the total number of students
$query = "SELECT COUNT(*) AS All_count FROM student_create ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$All_student = $row['All_count'];

// Calculate percentages
$senior_percentage = ($All_student > 0) ? ($senior_count / $All_student) * 100 : 0;
$college_percentage = ($All_student > 0) ? ($college_count / $All_student) * 100 : 0;

?>


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
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

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
            <li style="background:red;"><img width="24" height="24" src="https://img.icons8.com/ios-glyphs/30/shutdown--v1.png" alt="shutdown--v1"/><a href="logout.php"><span>Logout</span></a></li>
        </ul>
    </div>

    <div class="content">
        <div class="box_container">
            <div class="boxs">
                <h3>School Facilities</h3>
                <h2>4</h2>
            </div>
            <div class="boxs">
            <h3>Enrolled College</h3>
            <h2><?php echo $college_count; ?></h2>
            </div>
            <div class="boxs">
            <h3>Enrolled Senior</h3>
            <h2><?php echo $senior_count; ?></h2>
            </div>
            <div class="boxs">
                <h3>Total Student</h3>
                <h2><?php echo $All_student; ?></h2>
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

<!-- Table Section -->
<div class="table_container" style="display: flex; align-items: flex-start; gap: 20px;">

    <!-- Profile Box -->
    <div class="profile-box" style="border: 1px solid #ccc; padding: 15px; width: 300px; text-align: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
        <?php
            require './connect.php';

            $sql = "SELECT Username, Email, Role FROM user WHERE UID = 6"; 
            $result = $conn->query($sql);

            // Check if the query returned a result
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
            } else {
                $user = [
                    'Username' => 'N/A',
                    'Email' => 'N/A',
                    'Role' => 'N/A'
                ];
            }
        ?>
        <img id="profile-image" src="../uploads/675c17bfcd9f06.45491065.png" alt="Profile Image" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 10px;">
        <h3><?= htmlspecialchars($user['Username']); ?></h3>
        <p>Email: <?= htmlspecialchars($user['Email']); ?></p>
        <p>Role: <?= htmlspecialchars($user['Role']); ?></p>
    </div>

    <!-- Schedule Table -->
    <table border="1" style="width:100%; border-collapse: collapse; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
        <thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Subject</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Monday</td>
                <td>8:00 AM - 10:00 AM</td>
                <td>Mathematics</td>
                <td>Room 101</td>
            </tr>
            <tr>
                <td>Monday</td>
                <td>10:30 AM - 12:00 PM</td>
                <td>English</td>
                <td>Room 102</td>
            </tr>
            <tr>
                <td>Tuesday</td>
                <td>1:00 PM - 3:00 PM</td>
                <td>Science</td>
                <td>Room 103</td>
            </tr>
            <tr>
                <td>Wednesday</td>
                <td>8:00 AM - 10:00 AM</td>
                <td>History</td>
                <td>Room 104</td>
            </tr>
            <tr>
                <td>Thursday</td>
                <td>9:00 AM - 11:00 AM</td>
                <td>Physical Education</td>
                <td>Gym</td>
            </tr>
        </tbody>
    </table>
</div>
</div>

    <div class="content-calendar">
        <div class="calendar-container">
        <div id="calendar">
            <script src="calendar.js"></script>
        </div>

        </div>
    </div>
    <script>
    // Pass PHP variables to JavaScript for pie chart
    const seniorHighPercentage = <?php echo $senior_percentage; ?>;
    const collegePercentage = <?php echo $college_percentage; ?>;

    // Pie chart configuration
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: [
                `Senior High - ${seniorHighPercentage.toFixed(2)}%`,  // Display percentage in the label
                `College - ${collegePercentage.toFixed(2)}%`         // Display percentage in the label
            ],
            datasets: [{
                label: 'Attendance Overview',
                data: [seniorHighPercentage, collegePercentage],  // Use the dynamic percentage values
                backgroundColor: [
                    'rgb(4, 46, 110)',
                    'rgb(101, 5, 25)',
                ],
                borderColor: [
                    'rgb(255, 255, 255)',
                    'rgb(250, 250, 250)',
                ],
                borderWidth: 4
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
</script>
    <script>
        //Hamburger Bar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');   
        }
        // Function to filter records based on input and date
function filterRecords() {
    // Select the record container (you might need to adjust this selector)
    const recordContainer = document.querySelector('.container-record');

    if(recordContainer.style.display == 'flex'){
        recordContainer.style.display = 'none'
    }
    else{
        recordContainer.style.display = 'flex'
    }
}
<?php
require "./connect.php";
// Assuming you're already connected to the database
$query = "SELECT Course, COUNT(*) AS student_count FROM student_create GROUP BY Course ORDER BY student_count DESC LIMIT 4";
$result = mysqli_query($conn, $query);

$courses = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row['Course'];
    $counts[] = $row['student_count'];
}
?>

// Getting the data from PHP
const courses = <?php echo json_encode($courses); ?>;
const counts = <?php echo json_encode($counts); ?>;

// Diagonal bar chart configuration
const ctxDiagonal = document.getElementById('diagonalChart').getContext('2d');
const diagonalChart = new Chart(ctxDiagonal, {
    type: 'bar',
    data: {
        labels: courses, // Use dynamic course names
        datasets: [{
            label: 'Most Enrolled Course',
            data: counts, // Use dynamic student counts
            backgroundColor: [
                'rgba(54, 162, 235, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 205, 86, 0.6)',
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 205, 86, 1)',
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
                    text: 'Number of Students'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Courses'
                }
            }
        }
    }
});



    </script>
</body>
</html>
