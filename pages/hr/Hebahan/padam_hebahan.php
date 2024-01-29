<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php

extract($_POST);
extract($_GET);
include "../../conn.php";


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql_select = "SELECT * FROM intern_post WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mark_category = $row['id'];

        $sql_delete = "DELETE FROM intern_post WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        $stmt_delete->execute();

        if ($stmt_delete->affected_rows > 0) {
            echo '<center><script> 
            Swal.fire({
                title: "Berjaya",
                text: "Hebahan telah dipadam",
                icon: "success"
            }).then(function() {
                window.location.replace("hebahan_list.php"); 
            }); </script></center>';
        } else {
            echo "<center><script> alert('Tidak berjaya dipadam.'); </script></center>";
            echo "<meta http-equiv=\"refresh\" content=\"0;URL=hebahan_list.php\">";
        }
    } else {
        // Handle the case where the form was not submitted via POST
        echo "Form not submitted.";
    }}
?>

