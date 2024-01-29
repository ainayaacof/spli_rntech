<?php
session_start();

include "../../conn.php"; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $mark = $_POST['mark'];

    $id = mysqli_real_escape_string($conn, $id);
    $type = mysqli_real_escape_string($conn, $type);
    $mark = mysqli_real_escape_string($conn, $mark);

    $updateQuery = "UPDATE mark_apply SET type = '$type', mark = '$mark' WHERE id = '$id'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo "success";
    } else {
        echo "error"; 
    }
} else {
    echo "Invalid request";
}
?>

