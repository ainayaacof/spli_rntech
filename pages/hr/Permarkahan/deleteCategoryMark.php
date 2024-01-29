<?php

extract($_POST);
extract($_GET);
include "../../conn.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM mark_category WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); 
    $stmt->execute();

    if ($stmt->affected_rows > 0) {

        $sql_delete_apply = "DELETE FROM mark_apply WHERE mark_category_id = ?";
        $stmt_delete_apply = $conn->prepare($sql_delete_apply);
        $stmt_delete_apply->bind_param("i", $id); 
        $stmt_delete_apply->execute();

        if ($stmt_delete_apply->affected_rows > 0) {
            echo "<script>alert('Data berjaya dipadam!');</script>";
            echo "<script>window.location.href = 'list_mark.php';</script>";
        } else {
            echo "<script>alert('Data pada tidak berjaya dipadam!');</script>";
            echo "<script>window.location.href = 'list_mark.php';</script>";
        }
    } else {
        echo "<script>alert('Data pada tidak berjaya dipadam!');</script>";
        echo "<script>window.location.href = 'list_mark.php';</script>";
    }
}

?>
