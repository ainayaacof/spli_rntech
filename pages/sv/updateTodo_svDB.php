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
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];
$_POST['sv_id'] = $_SESSION['sv_id'];
$sv_id = $_POST['sv_id'];

$todo_id = $_REQUEST['todo_id'];
$tugasan = $_REQUEST['tugasan'];
$date = $_REQUEST['date'];
$status = $_REQUEST['status'];

// Use prepared statement
$sql = "UPDATE todo_sv SET task = ?, due_date = ?, is_done = ? WHERE sv_id = ? AND todo_id = ?";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssii", $tugasan, $date, $status, $sv_id, $todo_id);

// Execute the statement
if ($stmt->execute()) {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini telah berjaya dikemaskini.",
        icon: "success"
    }).then(function() {
        window.location.replace("dashboard_sv.php"); 
    }); </script></center>';
} else {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini tidak berjaya dikemaskini.",
        icon: "error"
    }).then(function() {
        window.location.replace("dashboard_sv.php"); 
    }); </script></center>';
}

// Close the statement and connection
$stmt->close();
$conn->close();
} else {
    // Handle the case where the form was not submitted via POST
    echo "Not submitted.";
}
?>