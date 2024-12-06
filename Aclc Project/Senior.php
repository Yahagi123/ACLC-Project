    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RFID Attendance Monitoring Dashboard</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="css/senior.css">
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
            <li><a href="#"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="navbar">
            <h2>Senior High Table</h2>
            <div class="nav-links">
                <ul>
                    <li><button onclick="refreshPage()">Refresh</button></li>
                    <li><button>Print</button></li>
                    <li>
                        <form method="GET" action="Senior.php">
                            <label for="search">Search</label>
                            <input type="search" name="Search" id="search" value="<?php echo isset($_GET['Search']) ? $_GET['Search'] : ''; ?>" class="form-control me-2">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <label for="rows">Rows:</label>
                            <select name="rows" id="rows" class="form-control me-2">
                                <option value="10" <?php echo isset($_GET['rows']) && $_GET['rows'] == '10' ? 'selected' : ''; ?>>10</option>
                                <option value="20" <?php echo isset($_GET['rows']) && $_GET['rows'] == '20' ? 'selected' : ''; ?>>20</option>
                                <option value="30" <?php echo isset($_GET['rows']) && $_GET['rows'] == '30' ? 'selected' : ''; ?>>30</option>
                            </select>
                            <label for="courses">Course:</label>
                            <select name="courses" id="course" class="form-control me-2">
                                <option value="">All</option>
                                <option value="STEM" <?php echo isset($_GET['course']) && $_GET['course'] == 'GAS' ? 'selected' : ''; ?>>GAS</option>
                                <option value="ABM" <?php echo isset($_GET['course']) && $_GET['course'] == 'ABM' ? 'selected' : ''; ?>>ABM</option>
                                <option value="HUMSS" <?php echo isset($_GET['course']) && $_GET['course'] == 'ICT' ? 'selected' : ''; ?>>ICT</option>
                            </select>
                        </form>
                    </li>
                </ul>
            </div>
            <script>
                function refreshPage() {
                    location.reload();
                }
            </script>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Image</th>
                        <th>Student Name</th>
                        <th>Profile</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    require "./connect.php";

    try {
        // Get filter inputs
        $search = isset($_GET['Search']) ? $_GET['Search'] : '';
        $rows = isset($_GET['rows']) ? (int) $_GET['rows'] : 10;
        $course = isset($_GET['courses']) ? $_GET['courses'] : '';

        // Build the query with filters
        $sql = "SELECT `Image`, `Id_number`, `student name`,`Course`,`Year` FROM `student_create` WHERE `Year` = 'Senior'";
        if (!empty($search)) {
            $sql .= " AND `student name` LIKE '%$search%'";
        }
        if (!empty($course)) {
            $sql .= " AND `Course` = '$course'";
        }
        $sql .= " LIMIT $rows";
        
        
        $result = mysqli_query($conn, $sql);
        
        if (!$result) {
            throw new Exception("Query Error: " . mysqli_error($conn));
        }
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row["Id_number"];
                $name = $row["student name"];
                $profileImage = $row["Image"];
                $course = $row["Course"];
                $year = $row["Year"];
                echo "<tr>
                        <td>$id</td>
                        <td><img src='" . $profileImage . "' alt='Student Image' class='img-thumbnail'></td>
                        <td>$name</td>
                        <td>
                            <button class='profile-btn' 
                                data-id='$id' 
                                data-name='$name' 
                                data-image='$profileImage' 
                                data-course='$course'
                                data-year='$year'
                                >View Profile</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No students found</td></tr>";
        }
        
    } catch (Exception $e) {
        echo "<tr><td colspan='4'>Error: " . $e->getMessage() . "</td></tr>";
    }
    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for viewing and editing student profile -->
    <div id="myModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Student Profile</h2>
            <img src="" id="modal-image" alt="Profile Image" class="img-thumbnail" style="max-width: 150px;">
            <p><strong>ID Number:</strong> <span id="modal-id"></span></p>
            <p><strong>Name:</strong> <span id="modal-name"></span></p>
            <p><strong>Course:</strong> <span id="modal-course"></span></p>
            <p><strong>Year:</strong> <span id="modal-year"></span></p>
            <div style="margin-top: 15px;">
                <button><a href="update.php">Update</a></button>
            </div>
        </div>
    </div>
    <div id="loading" style="display:none;">Loading...</div>

    <script src="modal.js"></script>
    <script src="update.js"></script>
    </body>
    </html>