<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
include "../../conn.php";

// Assuming $conn is your database connection

$studentId = $_GET['studentID'];
$supervisorId = $_POST['supervisor_id'];

// Update the student's supervisor in the database using a prepared statement
$updateQuery = "UPDATE student SET sv_id = ? WHERE student_id = ?";
$stmt = mysqli_prepare($conn, $updateQuery);

// Bind parameters and execute
mysqli_stmt_bind_param($stmt, 'ss', $supervisorId, $studentId);
$updateResult = mysqli_stmt_execute($stmt);

if ($updateResult) {
    // If update is successful, show a pop-up and redirect to list_apply.php
    echo '<center><script> 
        Swal.fire({
            title: "Berjaya",
            text: "Penyelia industri telah berjaya disimpan.",
            icon: "success"
        }).then(function() {
            window.location.replace("list_apply.php");
        }); </script></center>';
} else {
    // If there is an error, display the error message
    echo 'Error: ' . mysqli_error($conn);
}
?>
