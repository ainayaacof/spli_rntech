<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../dist/js/demo.js"></script>

<?php
include "../conn.php";
// Start or resume the session
session_start();

    $student_id = $_SESSION['id'];
    $unique_week = $_GET['unique_week'];
    $unique_id = $unique_id = isset($_GET['unique_id']) ? $_GET['unique_id'] : null;

    // sql to delete a record
    $sql = "DELETE FROM task_activity WHERE student_id = '" . $student_id . "' AND id = '" . $unique_id . "'";

    if ($conn->query($sql) === TRUE) {
        echo '<center><script> 
        Swal.fire({
            title: "Berjaya",
            text: "Tugasan ini telah berjaya dihapus.",
            icon: "success"
        }).then(function() {
            window.location.replace("tugasan.php?student_id=' . $student_id . '&unique_week=' . $unique_week . '"); 
        }); </script></center>';
    } else {
    echo "Error deleting record: " . $conn->error;
    }

    $conn->close();

?>

