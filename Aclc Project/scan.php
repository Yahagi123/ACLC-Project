<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "./connect.php";
        $rfid  = trim($_POST['scan']);

        $sql = "SELECT * FROM `student_create` WHERE 'USN' = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $rfid);
        $stmt->execute(); 
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "access granted";
        }
        else {
            echo "access denied";
        }
        $stmt ->close();
        $conn ->close();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID ATTTENDANCE SCAN</title>
</head>
<body>
    <form action="scan.php" method="post">
        <input type="text" name="scan" id="scan">
        <input type="submit" value="submit">
    </form>
</body>
</html>