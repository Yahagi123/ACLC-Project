<?php
    $NameError = "";
    $emailError = "";
    $passwordError = "";
    $CheckError = "";
    $Data_inserted ="";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require "./connect.php";
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password_con'];
    
        //username error 
        if(empty($username)){
            $NameError = 'Username Required';
        }
        elseif(!preg_match(('/^[a-zA-Z]+$/'), $username)){
            $NameError  ="Name should contain Char and Space";
        }
        elseif(!preg_match(("/^[0-9]$/"), $username)){
            $NameError = "Name should have a Number";
        }

        //Email error
        if(empty($email)){
            $emailError = "The Email is required";
        }
        elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $EmailError = "Invalid Email";
        }
        //Password Error
        if(empty($password)){
            $passwordError = "The password is required";
        }
        elseif(strlen($password) <= 8){
            $PasswordError = "Password Must Contain 8-12 letter";
        }
        elseif(!preg_match(("#[0-9]#"), $password)){
            $passwordError = "Password must required number";
        }
        elseif(!preg_match(("#[a-z]#"), $password)){
            $passwordError = "Password required one small letter";
        }
        elseif(!preg_match(("#[A-Z]#"), $password)){
            $PasswordError = "Password required one big letter";
        }
        elseif(!preg_match(("[@_!#$%^&*()<>?/|}{~:]"), $password)){
            $PasswordError = "Password Required Special Character";
        }
        //Same Password Accept
        elseif($password2 != $password){
            $passwordError = "Password Is Incorrect";
        }

        else{ 
        $hash = password_hash($password, algo: PASSWORD_DEFAULT);
        $sql = "INSERT INTO `user`(`Username`, `Email`, `Password`) VALUES ('$username','$email','$hash')";
        if($conn->query($sql)){
         $Data_inserted ="Sign In Successfull";
        }
         else{
             die("connection error". $conn->error);
         }
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
            <div class="submit">
            <input type="submit" value="SignUp" name="SignUp">
            <span style="color : green;"><?php echo $Data_inserted ?></span>
        </div>
        </form>
          </div>

    </div>
</body>
</html>