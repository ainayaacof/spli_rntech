<?php
include "../../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST['newPassword'];
    $userId = $_POST['userId'];
    $userType = $_POST['userType'];

    if ($userType === 'student') {
        // Update student password in the student table
        $query = "UPDATE student SET password = '$newPassword' WHERE id = '$userId'";
    } elseif ($userType === 'supervisor') {
        // Update supervisor password in the supervisor table
        $query = "UPDATE supervisor SET password = '$newPassword' WHERE id = '$userId'";
    }

    if (isset($query) && !empty($query)) {
        // Execute the query only if $query is set and not empty
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Handle success - Password updated successfully
            echo '<script>alert("Password updated successfully!");</script>';
            // Redirect back to the previous page
            echo '<script>window.history.go(-1);</script>';
            exit; // Stop further execution to prevent accidental output interfering with the redirect
        } else {
            // Handle failure - Error occurred during password update
            die("Error updating password: " . mysqli_error($conn));
        }
    } else {
        // Handle scenario where $query is not set or empty
        echo "Query is not set or empty";
    }
}
?>
