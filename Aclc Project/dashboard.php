<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
</head>
<body>
    <div class="header">
        <h2>Admin Dashboard</h2>
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
            <h2>4</h2>
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
    <div class="box_survey">
    <div class="survey_box">
            <h2></h2>
            <h2>4</h2>
        </div>
    <div class="survey_box">
        <h2>Most</h2>
        <li>1</li>
        <li>2</li>
    </div>    
    </div>
 <div class="carousel-container">
 <h2>Currently Room Schedule</h2>
    <div class="carousel" id="carousel">
      <!-- Table 1 -->
       
      <div class="table-container">
        <table>
          <thead>
            <tr>AM Schedule</tr>
            <tr>
                <th>Time</th>
              <th>Library</th>
              <th>201</th>
              <th>AVR</th>
              <th>Comlab</th>
              <th>301</th>
              <th>302</th>
              <th>303</th>
              <th>NSTP Room</th>
              <th>Chem Lab</th>
              <th>PE Room</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>7:00AM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>8:00AM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>9:00AM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>10:00AM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>11:00AM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>12:00AM</td>
            <td>Lunck Break</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- Table 2 -->
       <h2></h2>
      <div class="table-container">
        <table>
          <thead>
            <tr>PM Schedule</tr>
            <tr>
                <th>Time</th>
              <th>Library</th>
              <th>201</th>
              <th>AVR</th>
              <th>Comlab</th>
              <th>301</th>
              <th>302</th>
              <th>303</th>
              <th>NSTP Room</th>
              <th>Chem Lab</th>
              <th>PE Room</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1:00PM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>2:00PM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>3:00PM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>4:00PM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>5:00AM</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
            <tr>
            <td>6:00AM</td>
            <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
              <td>--</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

    <script>
        const carousel = document.getElementById("carousel");
    let currentIndex = 0;

    function slideTables() {
      currentIndex = (currentIndex + 1) % 2; // Toggle between 0 and 1
      const offset = currentIndex * -100; // Calculate offset percentage
      carousel.style.transform = `translateX(${offset}%)`;
    }

    // Auto-slide every 3 seconds
    setInterval(slideTables, 5000);
    </script>
</body>
</html>