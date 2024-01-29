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

    $id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    $week = $_POST['week'];
    $task_description = $_POST['description'];
    $task_date = $_POST['date'];
    $total_time = $_POST['quantity'];

    $query = "INSERT INTO task_activity (student_id, week, task_description, task_date, total_time, level) VALUES (?,?,?,?,?,'Tiada')";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("sssss", $id, $week, $task_description, $task_date, $total_time);

    

    // Execute the statement
    if ($stmt->execute()) {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini telah berjaya ditambah.",
        icon: "success"
    }).then(function() {
        window.location.replace("tugasan.php?student_id=' . $id . '&unique_week=' . $week . '"); 
    }); </script></center>';
    } else {
        echo "<center><script> alert('Failed to Update!'); </script></center>";
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=tugasan.php\">";
    }

    // Close the statement
    $stmt->close();
    $conn->close();
}
?>