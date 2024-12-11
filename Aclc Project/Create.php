<?php
$emptyError = "";
$Create = "";
$displayImage = ""; // Variable to store image URL for display
if (isset($_POST["Create"])) {
    require "./connect.php";
    
    // Sanitize inputs to prevent XSS and SQL injection
    $Student = mysqli_real_escape_string($conn, $_POST['Name']);
    $USN = mysqli_real_escape_string($conn, $_POST['USN']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Address = mysqli_real_escape_string($conn, $_POST['Address']);
    $Course = mysqli_real_escape_string($conn, $_POST['course']);
    $Birth = mysqli_real_escape_string($conn, $_POST['Date']);
    $Year = mysqli_real_escape_string($conn, $_POST['year']);
    
    // Handle image file upload
    $image = "";
    if (isset($_FILES['Image']) && $_FILES['Image']['error'] == 0) {
        $imageTmpName = $_FILES['Image']['tmp_name'];
        $imageName = $_FILES['Image']['name'];
        $imageSize = $_FILES['Image']['size'];
        $imageError = $_FILES['Image']['error'];
        
        // Set allowed file types and size limit
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        if (in_array($imageExtension, $allowedExtensions)) {
            if ($imageSize <= 2000000) { // 2MB size limit
                $imageNewName = uniqid('', true) . "." . $imageExtension;
                $imageDestination = "uploads/" . $imageNewName;
                
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    $image = $imageDestination;
                } else {
                    $emptyError = "Failed to upload the image.";
                }
            } else {
                $emptyError = "Image file is too large.";
            }
        } else {
            $emptyError = "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }
    
    if (empty($Student) || empty($USN) || empty($Course) || empty($Year)) {
        $emptyError = "There is a blank in the form.";
    } else {
        if (empty($emptyError)) {
            $sql = "INSERT INTO `student_create`(`Image`, `student name`, `USN`, `Email Address`, `Address`, `Course`, `Year`, `birthdate`) 
                    VALUES ('$image', '$Student', '$USN', '$Email', '$Address', '$Course', '$Year', '$Birth')";
            
            if ($conn->query($sql)) {
                $Create = "Successfully created new UID";
                
                // Retrieve the image path for displaying
                $lastId = $conn->insert_id;
                $result = $conn->query("SELECT `Image` FROM `student_create` WHERE `Id_number` = $lastId");
                $row = $result->fetch_assoc();
                $displayImage = $row['Image']; // Store the image URL for display
            } else {
                die("Connection Error: " . $conn->connect_error);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create #Student</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/create.css">
</head>
<body>
    <div class="container">
        <form action="Create.php" method="POST" enctype="multipart/form-data">
            <div class="label_container">
                <label for="image">Image</label>
                <input type="file" name="Image" id="Image">
            </div>
            <div class="label_container">
                <label for="Name">First Name</label>
                <input type="text" name="Name" id="Name">
            </div>
            <div class="label_container">
                <label for="USN">USN</label>
                <input type="text" name="USN" id="USN">
            </div>
            <div class="label_container">
                <label for="Email">Email Address</label>
                <input type="Email" name="Email" id="Email">
            </div>
            <div class="label_container">
                <label for="Address">Address</label>
                <input type="text" name="Address" id="Address">
            </div>
            <div class="label_container">
                <label for="Course">Course</label>
                <select name="course" id="course">
                    <option value="ABM">ABM</option>
                    <option value="ICT">ICT</option>
                    <option value="GAS">GAS</option>
                    <option value="CS">Computer Science</option>
                    <option value="AIS">Accounting Information Systems</option>
                    <option value="ENTREP">Entrepreneurship</option>
                    <option value="ACT">ACT</option>
                </select>
                <label for="Course">of</label>
                <select name="course" id="course">
                    <option value="A1">11A</option>
                    <option value="A2">12A</option>
                    <option value="A2">12B</option>
                    <option value="A2">12B</option>
                    <option value="A2">21A</option>
                    <option value="A2">22A</option>
                    <option value="A2">21B</option>
                    <option value="A2">22B</option>
                    <option value="A2">31A</option>
                    <option value="A2">31B</option>
                    <option value="A2">32A</option>
                    <option value="A2">32A</option>
                    <option value="A2">32B</option>
                    <option value="A2">32B</option>
                    <option value="A2">41A</option>
                    <option value="A2">42A</option>
                    <option value="A2">42B</option>
                    <option value="A2">42B</option>
                </select>
            </div>
            <div class="label_container">
                <label for="Date">Birth Date</label>
                <input type="date" name="Date" id="Date">
            </div>
            <div class="label_container">
                <label for="Year">Year</label>
                <select name="year" id="year">Year
                <option value="College">College</option>
                <option value="Senior">Senior</option>
                </select>
            </div>
            <div class="submit">
                <input type="submit" value="Create" name="Create">
                <span><?php echo $Create; ?></span>
                <span><?php echo $emptyError; ?></span>
            </div>
        </form>

    </div>
</body>
</html>
