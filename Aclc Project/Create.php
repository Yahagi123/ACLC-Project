<?php
$emptyError = "";
$Create = "";
$displayImage = ""; // Variable to store image URL for display
if (isset($_POST["Create"])) {
    require "./connect.php";
    
    // Sanitize inputs to prevent XSS and SQL injection
    $Last_name = mysqli_real_escape_string($conn, $_POST['Last_name']);
    $First_name = mysqli_real_escape_string($conn, $_POST['First_name']);
    $Middle_name = mysqli_real_escape_string($conn, $_POST['Middle_name']);
    $USN = mysqli_real_escape_string($conn, $_POST['USN']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $Address = mysqli_real_escape_string($conn, $_POST['Address']);
    $Course = mysqli_real_escape_string($conn, $_POST['course']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
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
    
    if (empty($USN) || empty($Course) || empty($Year)) {
        $emptyError = "There is a blank in the form.";
    } else {
        if (empty($emptyError)) {
            $sql = "INSERT INTO `student_create`(`Image`,`Last Name`, `First Name`, `Middle Name`, `USN`, `Email Address`, `Address`, `Course`, `Section`, `Year`,`birthdate`) 
            VALUES ('$image','$Last_name','$First_name','$Middle_name','$USN','$Email','$Address','$Course','$section','$Year','$Birth')";
            
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
    <title>Create Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="create.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="./uploads/logo.png" alt="School Logo">
            <h1>Student Profile Creation</h1>
        </div>
        <form action="Create.php" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="label_container file-upload">
                    <label for="Image">Profile Picture</label>
                    <input type="file" name="Image" id="Image">
                </div>
                <div class="label_container">
                    <label for="Last_name">Last Name</label>
                    <input type="text" name="Last_name" id="Last_name" placeholder="Enter Last name">
                </div>
                <div class="label_container">
                    <label for="Last_name">First Name</label>
                    <input type="text" name="First_name" id="First_name" placeholder="Enter First name">
                </div>
                <div class="label_container">
                    <label for="Middle_name">Middle Initial</label>
                    <input type="text" name="Middle_name" id="Middle_name" placeholder="Enter Middle name">
                </div>
                <div class="label_container">
                    <label for="USN">Card Number</label>
                    <input type="text" name="USN" id="USN" placeholder="Enter USN">
                </div>
                <div class="label_container">
                    <label for="Email">Email Address</label>
                    <input type="email" name="Email" id="Email" placeholder="Enter Email">
                </div>
                <div class="label_container">
                    <label for="Address">Permanent Address</label>
                    <input type="text" name="Address" id="Address" placeholder="Enter Full Address">
                </div>
                <div class="label_container">
                    <label for="course">Course</label>
                    <select name="course" id="course">
                        <option value="">Select Course</option>
                        <option value="ABM">ABM</option>
                        <option value="ICT">ICT</option>
                        <option value="GAS">GAS</option>
                        <option value="CS">Computer Science</option>
                        <option value="AIS">Accounting Information Systems</option>
                        <option value="ENTREP">Entrepreneurship</option>
                        <option value="ACT">ACT</option>
                    </select>
                </div>
                <div class="label_container">
                    <label for="section">Class Section</label>
                    <select name="section" id="section">
                        <option value="">Select Section</option>
                        <option value="11A">11A</option>
                        <option value="12A">12A</option>
                        <option value="12B">12B</option>
                        <option value="21A">21A</option>
                        <option value="22A">22A</option>
                        <option value="21B">21B</option>
                        <option value="22B">22B</option>
                        <option value="31A">31A</option>
                        <option value="31B">31B</option>
                        <option value="32A">32A</option>
                        <option value="32B">32B</option>
                        <option value="41A">41A</option>
                        <option value="42A">42A</option>
                        <option value="42B">42B</option>
                    </select>
                </div>
                <div class="label_container">
                    <label for="Date">Birth Date</label>
                    <input type="date" name="Date" id="Date">
                </div>
                <div class="label_container">
                    <label for="Year">Academic Level</label>
                    <select name="year" id="year">
                        <option value="">Select Level</option>
                        <option value="College">College</option>
                        <option value="Senior High">Senior High</option>
                    </select>
                </div>
                <div class="submit">
                    <input type="submit" value="Create Profile" name="Create">
                    <span><?php echo $Create; ?></span>
                    <span><?php echo $emptyError; ?></span>
                </div>
                <div class="label_container">
                 <button><a href="attendance.php">Back</a></button>
                </div>
                
            </div>
        </form>
    </div>
</body>
</html>