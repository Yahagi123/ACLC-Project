<?php
require './connect.php'; // Include database connection

// Check if the required parameters (id and status) are provided
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];  // Get student ID from the request
    $status = $_POST['status'];  // Get the new status ('active' or 'inactive')

    // Debugging: Log received parameters
    error_log("Received ID: $id, New Status: $status");

    // Prepare the SQL statement to update the status
    $sql = "UPDATE student_create SET status = ? WHERE ID_number = ?";
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bind_param("si", $status, $id);  // 's' for string (status), 'i' for integer (ID)

    // Execute the statement and check if the query was successful
    if ($stmt->execute()) {
        // Success: Return success message
        echo "Status updated successfully";
    } else {
        // Failure: Return error message
        echo "Error updating status";
    }

    $stmt->close();  // Close the prepared statement
} else {
    echo "Missing ID or Status";  // If parameters are missing, return error
}

$conn->close();  // Close the database connection
?>


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/rfid.css">
     <!-- Previous head content remains the same -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
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
                    <li><a href="Guess_record.php">School</a></li>
                </ul>
            </li>
            <li><a href="Report.php"><img width="24" height="24" src="https://img.icons8.com/ios/50/bar-chart--v1.png" alt="bar-chart--v1"/><span>Reports</span></a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
    <div class="record-navbar">
    <ul>
        <li><a href="#" class="nav-option active" data-section="daily-present">Rfid Logs</a></li>
    </ul>
</div>
        <div class="daily-record">
            <div class="title-header-container" >
            <h1>Rfid Report</h1>
            <button class="button">filter</button>
            </div>
            <div class="container-record" >
                    <input class="all" type="text" placeholder="All" >
                    <div class="custom-date-wrapper">
    <input 
        type="date" 
        id="attendanceDate" 
        name="attendanceDate" 
        class="custom-date-input" 
        min="2024-01-01" 
        max="2025-12-31"
    >   
</div>  
                    <div>
                    <button class="btn-record find" type="button">Find</button>
                    <button class="btn-record reset" type="button">Reset</button>
                </div>
            </div>
            <hr>
            <div style="display: none;" class="actions" >
                <div>
                    <h6>Show <input type="text"> entries</h6>
                </div>
                <div>
                    <button>CSV</button>
                    <button>Excel</button>
                    <button class="print" >Print</button>
                </div>
                <div>
                    <h6>Search: </h6>
                    <input type="text">
                </div>
            </div>
            <div class="actions">
            <div style="width: 100%;"  class="table-controls-container">
    <div class="entries-selector">
        <label for="entries-dropdown" class="entries-label">Show</label>
        <select id="entries-dropdown" class="entries-dropdown">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span class="entries-text">entries</span>
    </div>

    
    <div class="export-buttons">
            <button class="csv-btn">CSV</button>
            <button class="excel-btn">Excel</button>
            <button class="print-btn">Print</button>
        </div>
    
    <div class="search-container">
        <label for="search-input" class="search-label">
            <i class="fas fa-search search-icon"></i>
        </label>
        <input 
            type="text" 
            id="search-input" 
            class="search-input" 
            placeholder="Search records..."
        >
    </div>
</div>
    </div>          
    <table class="attendance-table">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>USN</th>
            <th>Course</th>
            <th>Section</th>
            <th>Year</th>
            <th>Rfid Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
    require "./connect.php"; 
    $sql = "SELECT ID_number, `Last Name`, `First Name`, `Middle Name`, USN, Course, Section, Year, status FROM student_create";
    $result = $conn->query($sql);
    if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['ID_number']; ?></td>
                <td><?= htmlspecialchars($row['Last Name']) ?>, <?= htmlspecialchars($row['First Name']) ?> <?= htmlspecialchars($row['Middle Name']) ?></td> <!-- Display full name -->
                <td><?= htmlspecialchars($row['USN']); ?></td>
                <td><?= htmlspecialchars($row['Course']); ?></td>
                <td><?= htmlspecialchars($row['Section']); ?></td>
                <td><?= htmlspecialchars($row['Year']); ?></td>
                <td>
                    <button 
                        class="status-button <?= $row['status'] === 'active' ? 'active' : 'inactive'; ?>" 
                        data-id="<?= $row['ID_number']; ?>" 
                        data-status="<?= $row['status']; ?>" 
                        onclick="updateStatus(this)">
                        <?= $row['status'] === 'active' ? 'Deactivate' : 'Activate'; ?>
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">No data found</td>
        </tr>
    <?php endif; ?>
</tbody>

</table>
    <script>
  function updateStatus(button) {
    const studentId = button.getAttribute('data-id');
    const currentStatus = button.getAttribute('data-status');
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';

    console.log(`Student ID: ${studentId}, Current Status: ${currentStatus}, New Status: ${newStatus}`);

    // Send AJAX request to update the status
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'Rfid.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log('Server response: ' + xhr.responseText); // Log server response
            if (xhr.responseText.trim() === 'Status updated successfully') {
                // Update the button status and text
                button.setAttribute('data-status', newStatus);
                button.textContent = newStatus === 'active' ? 'Deactivate' : 'Activate';
                button.classList.toggle('active');
                button.classList.toggle('inactive');
            } else {
                alert('Failed to update status.');
            }
        } else {
            alert('Error: ' + xhr.statusText);
        }
    };
    xhr.onerror = function () {
        alert('Request failed');
    };
    xhr.send('id=' + studentId + '&status=' + newStatus);
}

    </script>



    <div class="pagination">
    <div class="pagination-info">
        Showing <span id="start-entry">0</span> to <span id="end-entry">0</span> of <span id="total-entries">0</span> entries
    </div>
    <div class="pagination-controls">
        <button id="prev-btn" class="pagination-btn" disabled>
            <i class="fas fa-chevron-left"></i> Previous
        </button>
        <button id="next-btn" class="pagination-btn">
            Next <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
</div>


 <!-- Previous body content remains the same until the content div -->
    <div class="content">
        <!-- Record Navbar remains the same -->
        
        <!-- Daily Record section remains the same -->
        
        <!-- New Attendance Logs Section -->
        <div id="attendance-logs">
            <h1>Attendance Logs</h1>
            
            <div class="user-selector">
                <label for="user-select">Select Student:</label>
                <select id="user-select">
                    <option value="1AY20CS001">John Doe (1AY20CS001)</option>
                    <option value="1AY20CS002">Jane Smith (1AY20CS002)</option>
                    <option value="1AY20CS003">Mike Johnson (1AY20CS003)</option>
                </select>
                
                <div class="custom-date-wrapper">
                    <input 
                        type="date" 
                        id="logDate" 
                        name="logDate" 
                        class="custom-date-input" 
                        min="2024-01-01" 
                        max="2025-12-31"
                    >   
                </div>
            </div>

            <table id="user-attendance-log" class="user-attendance-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-01-15</td>
                        <td>09:15 AM</td>
                        <td>04:30 PM</td>
                        <td>7h 15m</td>
                        <td>
                            <span class="status-present">Present</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-01-16</td>
                        <td>09:30 AM</td>
                        <td>04:45 PM</td>
                        <td>7h 15m</td>
                        <td>
                            <span class="status-late">Late</span>
                        </td>
                    </tr>
                    <tr>
                        <td>2024-01-17</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <span class="status-absent">Absent</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <div class="pagination-info">
                    Showing <span id="log-start-entry">1</span> to <span id="log-end-entry">3</span> of <span id="log-total-entries">3</span> entries
                </div>
                <div class="pagination-controls">
                    <button id="log-prev-btn" class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button id="log-next-btn" class="pagination-btn">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
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

// Add event listeners to filter inputs
    const filterButton = document.querySelector('.button');
        filterButton.addEventListener('click', filterRecords);
        
        document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('attendanceDate');
        
        // Set default value to today's date
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;

        // Optional: Add change event listener
        dateInput.addEventListener('change', function() {
            console.log('Selected date:', this.value);
        });
    });

    document.querySelector('.print').addEventListener('click',()=>{
        console.log('cl')
        window.print()
    })
 // Function to get table data
 function getTableData() {
            const table = document.querySelector('.attendance-table');
            const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent);
            const rows = Array.from(table.querySelectorAll('tbody tr')).map(row => 
                Array.from(row.querySelectorAll('td')).map(td => td.textContent)
            );
            return { headers, rows };
        }

        // CSV Export
        function exportToCSV() {
            const { headers, rows } = getTableData();
            
            // Combine headers and rows
            const csvContent = [
                headers.join(','),
                ...rows.map(row => row.join(','))
            ].join('\n');

            // Create a Blob with the CSV content
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            
            // Create a link to download the file
            if (navigator.msSaveBlob) { // For IE 10+
                navigator.msSaveBlob(blob, 'attendance_report.csv');
            } else {
                link.href = URL.createObjectURL(blob);
                link.download = 'attendance_report.csv';
                link.click();
            }
        }

        // Excel Export
        function exportToExcel() {
            const { headers, rows } = getTableData();
            
            // Create worksheet
            const ws = XLSX.utils.aoa_to_sheet([headers, ...rows]);
            
            // Create workbook and download
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Attendance Report');
            XLSX.writeFile(wb, 'attendance_report.xlsx');
        }

        // Print Function
        function printTable() {
            // Create a new window for printing
            const printWindow = window.open('', '', 'height=500, width=800');
            
            // Get table HTML
            const table = document.querySelector('.attendance-table');
            const tableHTML = table.outerHTML;

            // Create print content with basic styling
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Attendance Report</title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                            table { 
                                width: 100%; 
                                border-collapse: collapse; 
                                margin-bottom: 20px; 
                            }
                            th, td { 
                                border: 1px solid #ddd; 
                                padding: 8px; 
                                text-align: left; 
                            }
                            th { 
                                background-color: #f2f2f2; 
                                font-weight: bold; 
                            }
                        </style>
                    </head>
                    <body>
                        <h1>Attendance Report</h1>
                        ${tableHTML}
                        <p>Printed on: ${new Date().toLocaleString()}</p>
                    </body>
                </html>
            `);

            // Trigger print
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }

        // Add event listeners to export buttons
        document.querySelector('.csv-btn').addEventListener('click', exportToCSV);
        document.querySelector('.excel-btn').addEventListener('click', exportToExcel);
        document.querySelector('.print-btn').addEventListener('click', printTable);
        document.addEventListener('DOMContentLoaded', function() {
    // Pagination variables
    const table = document.querySelector('.attendance-table tbody');
    const rows = table.querySelectorAll('tr');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const startEntrySpan = document.getElementById('start-entry');
    const endEntrySpan = document.getElementById('end-entry');
    const totalEntriesSpan = document.getElementById('total-entries');

    // Pagination settings
    const entriesPerPage = 5;
    let currentPage = 5;
    const totalEntries = rows.length;
    const totalPages = Math.ceil(totalEntries / entriesPerPage);

    // Function to update table visibility
    function updateTableView() {
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;

        rows.forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });

        // Update pagination info
        const start = startIndex + 1;
        const end = Math.min(endIndex, totalEntries);
        
        startEntrySpan.textContent = start;
        endEntrySpan.textContent = end;
        totalEntriesSpan.textContent = totalEntries;

        // Update button states
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    // Previous button event listener
    prevBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            updateTableView();
        }
    });

    // Next button event listener
    nextBtn.addEventListener('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            updateTableView();
        }
    });

    // Initial view
    updateTableView();
});
document.addEventListener('DOMContentLoaded', function() {
    // Navigation between Daily Present and Attendance Logs
    const navOptions = document.querySelectorAll('.nav-option');
    const dailyPresentSection = document.querySelector('.daily-record');
    const attendanceLogsSection = document.getElementById('');

    navOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            // Remove active class from all options
            navOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');

            // Show/hide appropriate sections
            if (this.dataset.section === 'daily-present') {
                dailyPresentSection.style.display = 'block';
                attendanceLogsSection.style.display = 'none';
            } else {
                dailyPresentSection.style.display = 'none';
                attendanceLogsSection.style.display = 'block';
            }
        });
    });
});
    </script>
    
    
</body>
</html>