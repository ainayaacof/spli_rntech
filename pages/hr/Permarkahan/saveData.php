<?php
session_start();

include "../../conn.php"; // Ensure this file establishes a database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $type = $_POST['type'];
    $mark = $_POST['mark'];
    $mark_category_id = $_POST['mark_category_id']; 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO mark_apply (type, mark, mark_category_id, data_status) VALUES ('$type', '$mark', '$mark_category_id', '1')";

    if ($conn->query($sql) === TRUE) {
        // On success, display a success message using JavaScript
        echo "<script>alert('Data inserted successfully');</script>";
        // Redirect back to the previous page using JavaScript
        echo "<script>window.history.go(-1);</script>";
        exit; // Stop further execution
    } else {
        // On failure, you might want to return an error message or perform other error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
