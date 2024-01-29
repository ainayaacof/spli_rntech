<?php
include "../../conn.php";

// Check if the request parameter 'id' is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Perform the database update query
    $sql = "UPDATE feedback SET status = 'Lihat' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $id);
        $stmt->execute();

        // Check for errors during execution
        if ($stmt->errno) {
            // Display an error message
            echo "<script>alert('Ralat Sistem');</script>";
        } else {
            // Check if any rows were affected (if the update was successful)
            if ($stmt->affected_rows > 0) {
                // Display a success message
                echo "<script>alert('Aduan Telah Dilihat!');</script>";
            } else {
                // Display a message if no rows were affected
                echo "<script>alert('Tiada Perubahan');</script>";
            }
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Display an error message if the statement preparation fails
        echo "<script>alert('Ralat dalam penyediaan penyataan');</script>";
    }

    // Redirect to the previous page after execution
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    // Handle cases where 'id' parameter is missing or empty
    echo "<script>alert('ID tidak sah');</script>";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Close the database connection
$conn->close();
?>
