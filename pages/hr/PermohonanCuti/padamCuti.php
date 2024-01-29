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

// Check if the request parameter 'id_pusat' is set and not empty
// Check if the request parameter 'id' is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Get the value of 'id'
    $id = $_GET['id'];
  
    // Perform the database delete query
    $sql = "DELETE FROM leave_app WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); 
    $stmt->execute();
  
    if ($stmt->affected_rows > 0) {
      echo '<center><script> 
      Swal.fire({
          title: "Berjaya",
          text: "Data berjaya dipadam! ",
          icon: "success"
      }).then(function() {
          window.location.replace("list_mc.php");
      }); </script></center>';
    } else {
      echo '<center><script> 
      Swal.fire({
          title: "Berjaya",
          text: "Data tidak berjaya dipadam! ",
          icon: "success"
      }).then(function() {
          window.location.replace("list_mc.php");
      }); </script></center>';
    }
}
  
?>
