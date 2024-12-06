<?php
require "./connect.php";

// Get the student ID and action from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Validate the student ID
if (!empty($id)) {
    switch ($action) {
        case 'activate':
            // Update status to 'active'
            $sql = "UPDATE `student_create` SET `status` = 'active' WHERE `ID_number` = '$id'";
            if ($conn->query($sql) === TRUE) {
                echo "Student activated successfully.";
            } else {
                echo "Error activating student: " . $conn->error;
            }
            break;
        
        case 'deactivate':
            // Update status to 'inactive'
            $sql = "UPDATE `student_create` SET `status` = 'inactive' WHERE `ID_number` = '$id'";
            if ($conn->query($sql) === TRUE) {
                echo "Student deactivated successfully.";
            } else {
                echo "Error deactivating student: " . $conn->error;
            }
            break;

        case 'delete':
            // Delete the student record
            $sql = "DELETE FROM `student_create` WHERE `ID_number` = '$id'";
            if ($conn->query($sql) === TRUE) {
                echo "Student deleted successfully.";
            } else {
                echo "Error deleting student: " . $conn->error;
            }
            break;

        default:
            echo "Invalid action.";
            break;
    }
}
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'delete') {
        // Perform delete action
        $sql = "DELETE FROM `user` WHERE `UID` = $id";
        if (mysqli_query($conn, $sql)) {
            // Redirect to Teacher.php after deletion
            header("Location: Teacher.php?status=deleted");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
// Redirect back to the student list page after the action
header("Location: Rfid.php");
exit();
?>
