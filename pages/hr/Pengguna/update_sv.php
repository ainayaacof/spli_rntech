<?php
session_start();

if (isset($_SESSION['name']) == '') {
    header("Location: ../../login.php");
    exit(); 
}

include "../../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_edit'])) {
    $supervisor_id = $_POST['id_edit'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $position = $_POST['position']; 
    $status = $_POST['status']; 

    $update_query = "UPDATE `supervisor` SET `name`='$name', `email`='$email', `phone_num`='$phone_num', `position`='$position', `status`='$status' WHERE `id`='$supervisor_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: view_user_sv.php?id=$supervisor_id&notify=1");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
