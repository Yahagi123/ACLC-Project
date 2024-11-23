<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    require "./connect.php";
    $rfid = $_POST['scan'];

    $sql = "SELECT * FROM `student_create`";
    $result = mysqli_query($conn, $sql);
    
    $sql2 = "SELECT * FROM `student_create` where USN = $rfid";
    if($rfid !== ''){
        
    $result2 = mysqli_query($conn, $sql2);
    }

    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID ATTTENDANCE MONITORING SYSTEM</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cb73975b1a.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="header">
        <span>Attendance System</span>
        <ul>
            <li><a href="scan.php"><i class="fa-solid fa-eye"></i>Scan</a></li>
            <li><a href="#"><i class="fa-solid fa-circle-exclamation"></i>About</a></li>
            <li><a href="SignIn.php"><i class="fa-solid fa-user"></i>Sign In</a></li>
        </ul>
    </div>
    <!-- Clock -->
    <div class="clock_container">
    <span id="hours">00</span> :
    <span id="minutes">00</span> :
    <span id="seconds">00</span>
    <span id="ampm">AM</span>
    </div>
     <script src="script.js"></script>
    <div class="container">
    <div class="student_info">
    <span> </span>
        <div class="student">
            <?php 
            if($rfid !== ''){
                if(mysqli_num_rows($result2) > 0){
                    foreach($result2 as $row2){
                        ?> 
                        <p>Name : <?= $row2['student name'] ?></p>
                        <p>USN :<?=$row2 ['USN']?></p>
                        <p>Course :<?=$row2 ['Course']?></p>
                        <p>Year :<?=$row2 ['Year']?></p>

                        <?php
                    }
                }
            }
            else{
                ?> <p>Name: </p> 
                <p>USN:</p>
                <p>Course:</p>
                <p>Year</p>
                <?php
            }
            ?>
        </div>
        <table>
            <tr>
                <td>Time In</td>
                <td>Time Out</td>
                <td>Date Logged</td>
            </tr>
            
        </table>
        </div>
     <!-- RFID -->  
      <form action="index.php" method="post" class="scanner">
        <input type="text" name="scan" id="scan" placeholder="Scan Your ID Here">
      </form>
    <div class="history">
        <table>
            <th>Recent</th>
                <tr>
                    <td>Student Name</td>
                    <td>Student Id</td>
                    <td>Course</td>
                    <td>Year</td>
                    <td>Time In</td>
                    <td>Time Out</td>
                    <td>Date Logged</td>
                </tr>
                <?php
                 if($rfid !== ''){
                    if(mysqli_num_rows($result2) > 0){
                        foreach($result2 as $row2){
                            ?>
                            <tr>
                            
                            <td><?= $row2['student name'] ?></td>
                            <td><?=$row2 ['USN']?></td>
                            <td><?=$row2 ['Course']?></td>
                            <td><?=$row2 ['Year']?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
        </table>
    </div>
    </div>
</body>
</html>