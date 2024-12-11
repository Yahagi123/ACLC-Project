<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Attendance Monitoring Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
</head>
<body>
    <div class="navbar">
        <h2>Attendance System Admin</h2>
      <div class="nav-links">
        <ul>
          <li><a href="#">Notification</a></li>
          <li><a href="#">Message</a></li>
          <li><a href="#">Profile</a></li>
        </ul>
      </div>
    </div>
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
            <li class="dropdown">
                <a href="#"><i class="fas fa-users"></i>Record</a>
                <ul class="student_drop">
                    <li><a href="Senior.php"><i class="fas fa-user-graduate"></i> Senior High</a></li>
                    <li><a href="collage.php"><i class="fas fa-user-graduate"></i> College</a></li>
                </ul>
            </li>           
            <li class="dropdown">
            <a href="#"><i class="fas fa-users"></i> Student</a>
                <ul class="student_drop">
                    <li><a href="Senior.php"><i class="fas fa-user-graduate"></i>Student Record</a></li>
                    <li><a href="collage.php"><i class="fas fa-user-graduate"></i>Teacher Record</a></li>
                </ul>
            <li><a href="Calendar.php"><i class="fas fa-calendar"></i>Analysis</a></li>
            <li><a href="#"><i class="fas fa-clock"></i> Schedule</a></li>
            <li><a href="teacher.php"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
            <li style="background:red;"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="box_container">
        <div class="boxs">
            <h3>Total School Facilities</h3>
            <h2>4</h2>
        </div>
        <div class="boxs">
            <h3>Total Senior High</h3>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h3>Total College</h3>
            <h2>---</h2>
        </div>
        <div class="boxs">
            <h3>Total Teachers</h3>
            <h2>---</h2>
        </div>
    </div>
    <div class="carousel-container">
 <h2>Currently Room Schedule</h2>
 <div class="buttons">
    <button id="prev">Previous</button>
    <button id="next">Next</button>
  </div> 
  <a href="#">Edit the Schedule</a>
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
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");
    let currentIndex = 0;

    function updateSlide() {
      const offset = currentIndex * -100; // Calculate offset percentage
      carousel.style.transform = `translateX(${offset}%)`;
    }

    prevButton.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + 2) % 2; // Cycle back if at the start
      updateSlide();
    });

    nextButton.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % 2; // Cycle forward
      updateSlide();
    });
  </script>
 </div>
</body>
</html>
