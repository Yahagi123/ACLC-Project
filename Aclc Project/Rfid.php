<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="css/rfid.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="custom-navbar">
    <button><a href="attendance.php">Back</a></button>
    <div class="nav-links">
        <form method="get" class="d-flex align-items-center">
            <label for="Search" class="me-2">Search</label>
            <input type="search" name="Search" id="Search" value="<?php echo isset($_GET['Search']) ? $_GET['Search'] : ''; ?>" class="form-control me-2">
            <select name="rows" id="rows" class="form-control me-2">
                <option value="ten" <?php echo isset($_GET['rows']) && $_GET['rows'] == 'ten' ? 'selected' : ''; ?>>10</option>
                <option value="twenty" <?php echo isset($_GET['rows']) && $_GET['rows'] == 'twenty' ? 'selected' : ''; ?>>20</option>
                <option value="thirty" <?php echo isset($_GET['rows']) && $_GET['rows'] == 'thirty' ? 'selected' : ''; ?>>30</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</div>

    <!-- Feedback Messages -->
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success text-center">Status updated successfully.</div>';
    } elseif (isset($_GET['error'])) {
        echo '<div class="alert alert-danger text-center">An error occurred: ' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>

    <!-- Table Section -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Student List</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>RFID</th>
                    <th>USN</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php
    require "./connect.php";

    $limit = isset($_GET['rows']) ? (int)$_GET['rows'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if ($limit <= 0) {
        $limit = 10;
    }

    $offset = ($page - 1) * $limit;
    $search = isset($_GET['Search']) ? $_GET['Search'] : '';

    $sql = "SELECT `ID_number`, `student name` AS student_name, `RFID`, `USN`, `status`
            FROM `student_create`
            WHERE `student name` LIKE '%$search%' OR `USN` LIKE '%$search%' OR `RFID` LIKE '%$search%'
            LIMIT $offset, $limit";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID_number']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['RFID']}</td>
                    <td>{$row['USN']}</td>
                    <td>" . ucfirst($row['status']) . "</td>
                    <td>
                        <a href='update_status.php?action=activate&id={$row['ID_number']}' class='btn btn-sm btn-success'>Activate</a>
                        <a href='update_status.php?action=deactivate&id={$row['ID_number']}' class='btn btn-sm btn-warning'>Deactivate</a>
                    <a href='update_status.php?action=delete&id=" . $row['ID_number'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>

                    </td>
                </tr>";
        }
    } else {
        echo '<tr><td colspan="6" class="text-center">No records found.</td></tr>';
    }

    $sql_count = "SELECT COUNT(*) AS total FROM `student_create` WHERE `student name` LIKE '%$search%' OR `USN` LIKE '%$search%' OR `RFID` LIKE '%$search%'";
    $result_count = $conn->query($sql_count);
    $total_rows = $result_count->fetch_assoc()['total'];
    $total_pages = ($total_rows > 0) ? ceil($total_rows / $limit) : 1;

    $conn->close();
    ?>

    <!-- Pagination Links -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=1&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>" aria-label="First">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo $total_pages; ?>&rows=<?php echo $limit; ?>&Search=<?php echo urlencode($search); ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>


<!-- Bootstrap JS (Optional, for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
