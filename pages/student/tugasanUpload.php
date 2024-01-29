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
 $week = $_GET['unique_week'];
 
    // Check if the file input is set and not empty
    if (isset($_FILES['pdfFile']) && !empty($_FILES['pdfFile']['name'])) {
        $pdfFileName = $_FILES['pdfFile']['name'];
        $pdfTempName = $_FILES['pdfFile']['tmp_name'];

        // Define the directory path where you want to save the PDF file
        $uploadPath = '../upload/' . $pdfFileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($pdfTempName, $uploadPath)) {
            // Insert data into the database
            $sql_update = "UPDATE `task_activity` SET
            `add_doc` = ?
            WHERE `student_id` = ? AND week = ?";

            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param(
                "ssi",
                $pdfFileName,
                $id, $week
            );

            // Execute the statement
            if ($stmt->execute()) {
                echo '<center><script> 
                Swal.fire({
                    title: "Berjaya",
                    text: "Lampiran berjaya disimpan.",
                    icon: "success"
                }).then(function() {
                    window.location.replace("tugasan_pelajar.php");
                    clearForm();
                }); </script></center>';
            } else {
                echo "<center><script> alert('Lampiran Tidak Berjaya Dimuatnaik!') </script></center>";
                echo "<meta http-equiv=\"refresh\" content=\"1;URL=tugasan_pelajar.php\">";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Please select a PDF file.";
    }

    $conn->close();

?>