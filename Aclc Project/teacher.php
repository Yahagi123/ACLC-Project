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
        <li><a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
        <li style="background:red;"><a href="logout.php">Logout</a></li>
    </ul>
</div>
<div class="main-content">
    <div class="navbar">
        <h2>Teacher Table</h2>
        <div class="nav-links">
            <ul>
                <li><button><a href="SignUp.php">Create User</a></button></li>
                <li><button onclick="refreshPage()">Refresh</button></li>
                <li><button>Print</button></li>
                <li>
                    <form method="GET" action="Teacher.php">
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
                            <option value="STEM" <?php echo isset($_GET['role']) && $_GET['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="ABM" <?php echo isset($_GET['role']) && $_GET['role'] == 'Teacher' ? 'selected' : ''; ?>>Teacher</option>
                            <option value="HUMSS" <?php echo isset($_GET['role']) && $_GET['role'] == 'Faculty' ? 'selected' : ''; ?>>Faculty</option>
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
    <h2>User List</h2>
    <table>
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Image</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "./connect.php";
            $sql ="SELECT `UID`, `Username`, `Email`, `Password`, `Role` FROM `user`";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                // Loop through the results and display them in the table
                while ($row = $result->fetch_assoc()) {
                    $id = $row["UID"];
                    $name = $row["Username"];
                    $email = $row["Email"];
                    $role = $row["Role"];

                    // Display each user in a row
                    echo "<tr>
                            <td>$id</td>
                            <td>$name</td>
                            <td>$email</td>
                            <td>$role</td>
                  <td>
                    <a href='update_status.php?action=activate&id=" . $row['UID'] . "' class='btn btn-sm btn-success'>Activate</a>
                    <a href='update_status.php?action=deactivate&id=" . $row['UID'] . "' class='btn btn-sm btn-warning'>Deactivate</a>
                    <a href='update_status.php?action=delete&id=" . $row['UID'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>