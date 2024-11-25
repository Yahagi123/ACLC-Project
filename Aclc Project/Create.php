<?php 
$emptyError="";
$Create= "";
if(isset($_POST["Create"])){
    require "./connect.php";
    $image = $_POST['Image'];
    $Student = $_POST['Name'];
    $USN = $_POST['USN'];
    $Course = $_POST['Course'];
    $Year = $_POST['year'];

    if(empty($Student) || empty($USN) || empty($Course) || empty($Year)){
        $emptyError= "There a Blank In the Page";
    }
    else{
        $sql = "INSERT INTO `student_create`(`Image`,`Student Name`, `USN`, `Course`, `Year`) VALUES ('$image','$Student','$USN','$Course','$Year')";
        if($conn->query($sql)){
            $Create ="Succesfully Create New UID";
        }
        else{
            die("Connection Error". $conn->connect_error);
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create_Student</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="create.css">
</head>
<body>
    <div class="container">
          
        <form action="Create.php" method="POST">
            <div class="label_container">
             <label for="image">image</label>
             <input type="file" name="Image" id="Image">
            </div>
            <div class="label_container">
                <label for="Name">Student_Name</label> 
                <input type="text" name="Name" id="Name">
            </div>
            <div class="label_container">
                <label for="USN">USN</label>
                <input type="text" name="USN" id="USN">
            </div>
            <div class="label_container">
                <label for="Course">Course</label>
                <input type="text" name="Course" id="Course">
            </div>
            <div class="label_container">
                <label for="Year">Year</label>
                <input type="Text" name="year" id="year">
            </div>
            <div class="submit">
                <input type="submit" value="Create" name="Create">
                <span><?php echo $Create ?></span>
                </div>
        </form>

    </div>
</body>
</html>