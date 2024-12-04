<?php
$NameError = "";
$passwordError = "";
$emailError = "";
$Data_inserted = "";

if (isset($_POST["submit"])) {
    require "./connect.php";

    // Validate and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password_con'];
    $role = $_POST['role'];

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

    if (empty($NameError) && empty($emailError) && empty($passwordError)) {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statements to insert data securely
        $stmt = $conn->prepare("INSERT INTO `user` (`Username`, `Email`, `Password`, `Role`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hash, $role);

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
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
     <!-- SIGN IN FORM-->
     <!--Header-->
     <div class="container">
          <div class="signin_form">
          <div class="circle_icon">
                <span></span>
            </div>
            <h2>Sign Up</h2>
        <form action="SignUp.php" method="POST">
            <div class="validation"></div>
            <div class="label_container">
                <label for="Username">Username</label>
                <input type="text" name="username" id="username" placeholder="Username">
                <span><?php echo $NameError?></span>
            </div>
            <div class="label_container">
                <label for="Email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email Address">
                <span><?php echo $emailError?></span>
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
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="submit">
            <input type="submit" value="SignUp" name="submit" id="submit">
            <span style="color : green;"><?php echo $Data_inserted ?></span>
        </div>
        </form>
          </div>

    </div>
</body>
</html>