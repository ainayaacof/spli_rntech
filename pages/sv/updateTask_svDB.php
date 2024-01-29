<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../dist/js/demo.js"></script>

<?php
// Start or resume the session
session_start();

include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted via POST
    $id = $_REQUEST['unique_id'];
    $student_id = $_REQUEST['student_id'];
    $comment = $_POST['commentTask'];
    $unique_week = $_POST['unique_week'];
    $level = $_POST['levelTask'];

    $sql = "UPDATE task_activity SET comment = ?, level = ?, status ='SIGNED' WHERE id = ? AND week = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
$stmt->bind_param("sssi", $comment, $level, $id, $unique_week);

// Execute the statement
if ($stmt->execute()) {
    echo '<center><script>
    window.location.replace("studentActivityView_sv.php?student_id=' . $student_id . '&unique_week=' . $unique_week . '"); </script></center>';
} else {
    echo "<center><script> alert('Tidak berjaya dikemaskini.'); </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=updateTask_sv.php\">";
}

// Close the statement and connection
$stmt->close();
$conn->close();

} else {
    // Handle the case where the form was not submitted via POST
    echo "Form not submitted.";
}

?>