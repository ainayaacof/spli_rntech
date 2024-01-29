<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../dist/js/demo.js"></script>

<?php
// Start or resume the session
session_start();

include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted via POST
    // $id = $_REQUEST['unique_id'];
    $student_id = $_GET['student_id'];
    $unique_id = $_GET['unique_id'];
    $unique_week = $_POST['week'];
    $task_description = $_POST['description'];
    $task_date = $_POST['date'];
    $total_time = $_POST['quantity'];

    // $sql = "UPDATE task_activity SET description = ? WHERE id = ? AND week = ?";
    $sql = "UPDATE task_activity SET task_description = ?, task_date = ?, total_time = ?/* add other columns */ WHERE student_id = ? AND id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
$stmt->bind_param("sssss", $task_description, $task_date, $total_time, $student_id, $unique_id);

if ($stmt->execute()) {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini telah berjaya dikemaskini.",
        icon: "success"
    }).then(function() {
        window.location.replace("tugasan.php?student_id=' . $student_id . '&unique_week=' . $unique_week . '"); 
    }); </script></center>';
} else {
    echo "<center><script> alert('Profile cannot be updated.'); </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=maklumat_tugasan_pelajar_edit.php\">";
}

// Close the statement and connection
$stmt->close();
$conn->close();

} else {
    // Handle the case where the form was not submitted via POST
    echo "Form not submitted.";
}

?>
