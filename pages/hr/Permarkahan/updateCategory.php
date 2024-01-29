<?php
session_start();

include "../../conn.php"; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve POST data
$id = $_POST['id'];
$category = $_POST['category'];
$date = $_POST['date'];

// Logging received data
file_put_contents('update_log.txt', "ID: $id, Category: $category, Date: $date\n", FILE_APPEND);

// Update query
$query = "UPDATE `mark_category` SET `category`=?, `date_create`=? WHERE `id`=?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ssi', $category, $date, $id);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    echo "Data updated successfully";
} else {
    echo "Error updating data: " . mysqli_error($conn); // Display MySQL error if any
}
mysqli_stmt_close($stmt);


?>

