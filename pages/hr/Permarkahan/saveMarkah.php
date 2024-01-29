<?php
session_start();

include "../../conn.php"; // Ensure this file establishes a database connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $category = $_POST['category'];
    $inputDate = $_POST['inputDate'];
    $kriteria = $_POST['kriteria'];
    $markah = $_POST['markah'];

    // Insert into mark_category table
    $sqlCategory = "INSERT INTO mark_category (category, date_create, data_status)
                    VALUES ('$category', '$inputDate', 1)";

    if ($conn->query($sqlCategory) === TRUE) {
        $lastInsertId = $conn->insert_id;

        // Insert into mark_apply table for each criterion and mark
        foreach ($kriteria as $key => $kriteriaValue) {
            $kriteriaValue = $conn->real_escape_string($kriteriaValue);
            $markahValue = $conn->real_escape_string($markah[$key]);

            $sqlApply = "INSERT INTO mark_apply (mark_category_id, type, mark, data_status)
                         VALUES ('$lastInsertId', '$kriteriaValue', '$markahValue', 1)";

            $conn->query($sqlApply);
        }

        $conn->close();

        echo "<script>
                alert('Data inserted successfully.');
                window.location.href = 'list_mark.php';
              </script>";
        exit(); // Stop further execution
    } else {
        echo "Error: " . $sqlCategory . "<br>" . $conn->error;
    }
}
?>
