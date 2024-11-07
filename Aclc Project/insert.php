<?php
    if(isset($_POST["SignUp"])){
    require "./connect.php";
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_con'];
    
    
    if(empty($username) || empty($email) || empty($password) || empty($password_confirm)){
        header('Location ./SignUp,php?error=empty');
        exit();
    }
    }
    if ($conn->connect_error) {
        die("Connection Error: " . $conn->connect_error);
        
    }
?>