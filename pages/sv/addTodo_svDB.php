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
$_POST['sv_id'] = $_SESSION['sv_id'];
$sv_id = $_POST['sv_id'];

$tugasan = $_REQUEST['tugasan'];
$date = $_REQUEST['date'];
$status = $_REQUEST['status'];

// Use prepared statement
$sql = "INSERT INTO todo_sv (task, due_date, is_done, sv_id)
        VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ssss", $tugasan, $date, $status, $sv_id);

// Execute the statement
if ($stmt->execute()) {
    // echo "<center><script> alert('Berjaya Ditambah!') </script></center>";
    // echo "<meta http-equiv=\"refresh\" content=\"1;URL=dashboard_sv.php\">";
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini telah berjaya ditambah.",
        icon: "success"
    }).then(function() {
        window.location.replace("dashboard_sv.php"); 
    }); </script></center>';
} else {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini tidak berjaya ditambah.",
        icon: "error"
    }).then(function() {
        window.location.replace("dashboard_sv.php"); 
    }); </script></center>';
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>