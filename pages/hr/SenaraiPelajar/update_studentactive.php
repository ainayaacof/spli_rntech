<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
session_start();
if (!isset($_SESSION['name']) || $_SESSION['name'] == '') {
    header("Location: ../../login.php");
    exit(); // Stop further execution if not authenticated
}

include "../../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_edit'])) {
   
    // Retrieve values from the form
    $user_id = $_POST['id_edit'];
    $start_intern_formatted = $_POST['start_intern'];
    $last_intern_formatted = $_POST['last_intern'];

    // Update internship information in the database
    $update_intern_query = "UPDATE `application_intern` SET `start_intern`='$start_intern_formatted', `last_intern`='$last_intern_formatted' WHERE `student_id`='$user_id'";

    $stmtIntern = $conn->prepare($update_intern_query);

    // Execute the statement
    $successIntern = $stmtIntern->execute();

    // Close the statement
    $stmtIntern->close();

    // Check if the update was successful
    if ($successIntern) {
        echo '<center><script> 
            window.location.replace("viewlist_studentactive.php?id=' . $user_id .'"); </script></center>'; 
    } else {
        echo '<center><script> 
            window.location.replace("viewlist_studentactive.php?id=' . $user_id .'"); </script></center>'; 
    }
} else {
    // Handle cases where the form data or ID is not properly received
    echo "Invalid request";
}

?>
