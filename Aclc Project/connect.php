<?php
//connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teacher_username";

$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error) {
    die("Connection Failed". $conn->connect_error);
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //get data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt =$conn->prepare("INSERT INTO `teacher_username`(`USN`, `Username`, `Email`, `Password`) VALUES (?,?,?,?)");
    $stmt->bind_param("sss",$username, $email, $hashedpassword);

    //Execute querry
    if ($stmt->execute()){
        echo "REgistration Successful";
    }else{
        echo "Error".$stmt->error;
    }

    $stmt ->close();
    $stmt ->close();
}
?>