<?php
$NameError = "";
$passwordError = "";
$emailError = "";
$imageError = "";
$Data_inserted = "";

if (isset($_POST["submit"])) {
    require "./connect.php";

    // Validate and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password_con'];
    $role = $_POST['role'];

    // Image upload handling
    $image = $_FILES['image'];
    $imagePath = "";
    if ($image['name']) {
        $imageName = $image['name'];
        $imageTmp = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];

        if ($imageError === 0) {
            // Validate image file size (e.g., max 5MB)
            if ($imageSize < 5000000) {
                $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                // Check file extension
                if (in_array($imageExtension, $allowedExtensions)) {
                    // Generate a unique name for the image
                    $imageNewName = uniqid('', true) . "." . $imageExtension;
                    $imagePath = "uploads/" . $imageNewName;

                    // Ensure the 'uploads/' directory exists and has the right permissions
                    if (!is_dir('uploads')) {
                        mkdir('uploads', 0755);
                    }

                    // Move the image to the uploads directory
                    if (move_uploaded_file($imageTmp, $imagePath)) {
                        echo "File uploaded successfully. Image path: " . $imagePath; // Debugging
                    } else {
                        $imageError = "Failed to upload file.";
                    }
                } else {
                    $imageError = "Invalid image format. Allowed formats: jpg, jpeg, png, gif.";
                }
            } else {
                $imageError = "Image size exceeds the maximum limit (5MB).";
            }
        } else {
            $imageError = "There was an error uploading the image.";
        }
    }

    // Basic validations
    if (empty($username)) {
        $NameError = "Username is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "A valid email is required.";
    }
    if (empty($password) || empty($password2)) {
        $passwordError = "Both password fields are required.";
    } elseif ($password !== $password2) {
        $passwordError = "Passwords do not match.";
    }

    if (empty($NameError) && empty($emailError) && empty($passwordError) && empty($imageError)) {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statements to insert data securely
        $stmt = $conn->prepare("INSERT INTO `user` (`Username`, `Email`, `Password`, `Role`, `Image`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hash, $role, $imagePath);

        if ($stmt->execute()) {
            $Data_inserted = "Data Inserted Successfully.";
        } else {
            $Data_inserted = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/Signup.css">
</head>
<body>
    <!-- SIGN IN FORM-->
    <!--Header-->
    <div class="container">
        <div class="signin_form">
            <div class="circle_icon"></div>
            <h2>Sign Up</h2>
            <form action="SignUp.php" method="POST" enctype="multipart/form-data">
                <div class="validation"></div>
                <div class="label_container">
                    <label for="Username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username">
                    <span><?php echo $NameError ?></span>
                </div>
                <div class="label_container">
                    <label for="Email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email Address">
                    <span><?php echo $emailError ?></span>
                </div>
                <div class="label_container">
                    <label for="Password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                    <span><?php echo $passwordError ?></span>
                </div>
                <div class="label_container">
                    <label for="Confirm Password">Confirm Password</label>
                    <input type="password" name="password_con" id="password_con" placeholder="Confirm Password">
                </div>
                <div class="label_container">
                    <select name="role" id="role">
                        <option value="Teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="label_container">
                    <label for="Image">Profile Image</label>
                    <input type="file" name="image" id="image">
                    <span><?php echo $imageError ?></span>
                </div>
                <div class="submit">
                    <input type="submit" value="SignUp" name="submit" id="submit">
                    <span style="color: green;"><?php echo $Data_inserted ?></span>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
