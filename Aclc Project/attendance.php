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
        <header>CS31</header>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="attendance.php"><i class="fas fa-list"></i> Attendance</a></li>
            <li class="dropdown">
                <a href="#"><i class="fas fa-users"></i> Student</a>
                <ul class="student_drop">
                    <li><a href="Senior.php"><i class="fas fa-user-graduate"></i> Senior High</a></li>
                    <li><a href="collage.php"><i class="fas fa-user-graduate"></i> College</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fas fa-calendar"></i> Calendar</a></li>
            <li><a href="#"><i class="fas fa-clock"></i> Schedule</a></li>
            <li><a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main_container">
        <div class="navbar">
            <h2>Current Attendance</h2>
            <div class="nav-links">
                <ul>
                    <li><button onclick="refreshPage()">Refresh</button></li>
                    <li><button class="print-btn" onclick="printTable()">Print</button></li>
                    <li><button><a href="Rfid.php">Rfid Card</a></button></li>
                    <li><button><a href="Create.php">Add Student</a></button></li>
                </ul>
            </div>
            <script>
                function refreshPage() {
                    location.reload();
                }
                function printTable() {
                    var printContent = document.getElementById('attendance-table').outerHTML;
                    var newWindow = window.open();
                    newWindow.document.write('<html><head><title>Print Attendance</title></head><body>');
                    newWindow.document.write(printContent);
                    newWindow.document.write('</body></html>');
                    newWindow.document.close();
                    newWindow.print();
                }
            </script>
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
                    <?php
                    require "./connect.php";
                    
                    // Set default values for pagination
                    $limit = isset($_GET['rows']) ? (int)$_GET['rows'] : 10; // Default to 10 if no rows specified
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Default to 1 if no page specified

                    // Ensure the limit and page are valid
                    if ($limit <= 0) {
                        $limit = 10; // Default value if limit is zero or invalid
                    }

                    if ($page <= 0) {
                        $page = 1; // Default value if page is invalid
                    }

                    // Calculate the offset
                    $offset = ($page - 1) * $limit;

                    // Capture search input
                    $search = isset($_GET['Search']) ? $_GET['Search'] : ''; // Check if there's a search query

                    // SQL query to fetch data with pagination and ordering by ID to ensure first inserted is displayed first
                    $sql = "SELECT * FROM rfid_logs
                            WHERE student_name LIKE '%$search%' OR USN LIKE '%$search%' OR course LIKE '%$search%'
                            ORDER BY id ASC
                            LIMIT $offset, $limit"; // Apply LIMIT with calculated offset and limit

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td><img src='" . $row['image'] . "' alt='Student Image' width='50' height='50'></td>
                                    <td>" . $row['student_name'] . "</td>
                                    <td>" . $row['USN'] . "</td>
                                    <td>" . $row['course'] . "</td>
                                    <td>" . $row['year'] . "</td>
                                    <td>" . $row['time_in'] . "</td>
                                    <td>" . $row['time_out'] . "</td>
                                    <td>" . $row['date_logged'] . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found.</td></tr>";
                    }

                    // Count total records to calculate pagination
                    $sql_count = "SELECT COUNT(*) AS total FROM rfid_logs WHERE student_name LIKE '%$search%' OR USN LIKE '%$search%' OR course LIKE '%$search%'";
                    $result_count = $conn->query($sql_count);
                    $total_rows = $result_count->fetch_assoc()['total'];

                    // Calculate total pages
                    $total_pages = ceil($total_rows / $limit);

                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination">
                <ul>
                    <li class="<?php if ($page <= 1) echo 'disabled'; ?>">
                        <a href="?page=1&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>">First</a>
                    </li>
                    <li class="<?php if ($page <= 1) echo 'disabled'; ?>">
                        <a href="?page=<?php echo $page - 1; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>">Prev</a>
                    </li>

                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="<?php if ($i == $page) echo 'active'; ?>">
                            <a href="?page=<?php echo $i; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="<?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a href="?page=<?php echo $page + 1; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>">Next</a>
                    </li>
                    <li class="<?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a href="?page=<?php echo $total_pages; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>">Last</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>
