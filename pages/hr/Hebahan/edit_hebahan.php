<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
// Start or resume the session
session_start();

include "../../conn.php";

if ($_SERVER['REQUEST_METHOD'] =='POST') {
    // Form was submitted via POST
    $hebahan_id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date_to = $_POST['date_to'];

    $sql = "UPDATE intern_post SET title = ?, description = ?, date_to = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
$stmt->bind_param("sssi", $title, $description, $date_to, $hebahan_id);

// Execute the statement
if ($stmt->execute()) {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Tugasan ini telah berjaya dikemaskini.",
        icon: "success"
    }).then(function() {
        window.location.replace("update_hebahan.php?id=' . $hebahan_id . '"); 
    }); </script></center>';
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