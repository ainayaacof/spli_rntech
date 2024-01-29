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

$title = $_POST['title'];
    $description = $_POST['description'];
    $post_date = $_POST['post_date'];
    $post_time = $_POST['post_time'];
    $date_from = $_POST['date_from'];
    $date= $_POST['date_to'];

$sql = "INSERT INTO intern_post (title, description, post_date, post_time, date_from, date_to)
        VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ssssss", $title, $description, $post_date, $post_time, $date_from, $date);

// Execute the statement
if ($stmt->execute()) {
    // echo "<center><script> alert('Berjaya Ditambah!') </script></center>";
    // echo "<meta http-equiv=\"refresh\" content=\"1;URL=dashboard_sv.php\">";
    echo '<center><script> 
        Swal.fire({
            title: "Berjaya",
            text: "Mesej hebahan berjaya di hantar.",
            icon: "success"
        }).then(function() {
            window.location.replace("hebahan_list.php"); 
        }); </script></center>';

} else {
    echo "<center><script> alert('Tidak Berjaya Ditambah.'); </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=hebahan_list.php\">";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
