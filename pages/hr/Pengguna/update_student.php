<?php
session_start();

if (isset($_SESSION['name']) == '') {
    header("Location: ../../login.php");
    exit(); // Stop further execution if not authenticated
}

include "../../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_edit'])) {
    // Retrieve values from the form
    $user_id = $_POST['id_edit'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $address = $_POST['address'];

    // Update student information in the database
    $update_query = "UPDATE `student` SET `name`='$name', `email`='$email', `phone_num`='$phone_num', `address`='$address' WHERE `student_id`='$user_id'";

    if (mysqli_query($conn, $update_query)) {
        // Redirect to the view page after successful update
        header("Location: view_user_student.php?id=$user_id&notify=1");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Handle cases where the form data or ID is not properly received
    echo "Invalid request";
}
?>
