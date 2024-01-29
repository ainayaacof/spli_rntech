<?php

extract($_POST);
extract($_GET);
include "../../conn.php";

if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['category']) && !empty($_GET['category'])) {
    $id = $_GET['id'];
    $category = $_GET['category'];

    if ($category === 'student') {
        $sql = "DELETE FROM student WHERE id = ?";
    } elseif ($category === 'supervisor') {
        $sql = "DELETE FROM supervisor WHERE id = ?";
    } else {

        echo "<script>alert('Data tidak valid!');</script>";
        echo "<script>window.location.href = 'list_user.php';</script>";
        exit(); // Stop further execution
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); 
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Data berjaya dipadam!');</script>";
        echo "<script>window.location.href = 'list_user.php';</script>";
    } else {
        echo "<script>alert('Data tidak berjaya dipadam!');</script>";
        echo "<script>window.location.href = 'list_user.php';</script>";
    }
} else {
    echo "<script>alert('Id tidak sepadan!');</script>";
    echo "<script>window.location.href = 'list_user.php';</script>";
}
?>
