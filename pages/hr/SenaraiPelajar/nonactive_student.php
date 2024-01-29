<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>


<?php
include "../../conn.php";

// Check if the request parameter 'id' is set and not empty
if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['student_id']);

    // Perform the database update query
    $sql = "UPDATE student SET status = 'Tidak Aktif' WHERE student_id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        //  Insertion successful
        echo '<center><script> 
        Swal.fire({
            title: "Berjaya",
            text: "Pelajar telah dinyahaktifkan",
            icon: "success"
        }).then(function() {
            window.location.replace("list_student.php");
        }); </script></center>';
    }
} else {
    // Handle cases where 'id' parameter is missing or empty
    echo "<script>alert('ID tidak sah');</script>";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Close the database connection
$conn->close();
?>
