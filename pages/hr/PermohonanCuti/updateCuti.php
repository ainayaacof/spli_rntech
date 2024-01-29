<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
// Include necessary files and start the session if needed
session_start();
include "../../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['leave_id'], $_POST['date_leave'], $_POST['reason'])) {
        $leave_id = $_POST['leave_id'];
        $date_leave = $_POST['date_leave'];
        $reason = $_POST['reason'];

        // Update the leave application details in the database
        $updateQuery = "UPDATE `leave_app` SET date_leave = '$date_leave', reason = '$reason' WHERE id = $leave_id";

        if (mysqli_query($conn, $updateQuery)) {
            // Successfully updated the leave application details
            // header("Location: list_mc.php?id=$leave_id");
            echo '<center><script> 
            Swal.fire({
                title: "Berjaya",
                text: "Cuti telah dikemaskini.",
                icon: "success"
            }).then(function() {
                window.location.replace("list_mc.php?id=' . $leave_id .'");
            }); </script></center>';
            exit();
        } else {
            // Error in updating the details
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Redirect if required fields are not set
        header("Location: list_mc.php");
        exit();
    }
} else {
    // Redirect if not a POST request
    header("Location: list_mc.php");
    exit();
}
?>
