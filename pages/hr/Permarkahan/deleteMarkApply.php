<?php

extract($_POST);
extract($_GET);
include "../../conn.php";


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql_select = "SELECT * FROM mark_apply WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mark_category = $row['mark_category_id'];

        $sql_delete = "DELETE FROM mark_apply WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();

        if ($stmt_delete->affected_rows > 0) {
            echo "<script>window.location.href = 'listCategoryData.php?id=$mark_category&notify=1';</script>";
        } else {
            echo "<script>window.location.href = 'listCategoryData.php?id=$mark_category&notify=1';</script>";
        }
    } else {
        echo "<script>window.location.href = 'listCategoryData.php?id=$mark_category&notify=1';</script>";
    }
} else {
    echo "<script>window.location.href = 'listCategoryData.php?id=$mark_category&notify=1';</script>";
}
?>

