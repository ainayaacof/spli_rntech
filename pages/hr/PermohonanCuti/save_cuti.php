<?php

session_start();
include "../../conn.php";

if (isset($_POST['submit'])) {
    $student_id = $_POST['nama'];
    $application_date = $_POST['tarikh_mohon'];
    $leave_date = $_POST['tarikh_cuti_dari'];
    $leave_end = $_POST['tarikh_cuti_hingga'];
    $reason = $_POST['sebab'];

    // Check if the file input is set and not empty
    if (isset($_FILES['pdfFile']) && !empty($_FILES['pdfFile']['name'])) {
        $pdfFileName = $_FILES['pdfFile']['name'];
        $pdfTempName = $_FILES['pdfFile']['tmp_name'];

        // Define the directory path where you want to save the PDF file
        $uploadPath = '../../upload/' . $pdfFileName;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($pdfTempName, $uploadPath)) {
            
            // Insert data into the leave_app table
            $query = "INSERT INTO leave_app (student_id, reason, date_apply, date_leave, date_end, support_doc, status, approved_by) VALUES (?,?,?,?,?,?,'Lulus','0')";
            $stmt = $conn->prepare($query);

            // Bind parameters
            $stmt->bind_param("ssssss", $student_id, $reason, $application_date, $leave_date, $leave_end, $pdfFileName);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "<center><script> alert('Berjaya Disimpan!') </script></center>";
                echo "<meta http-equiv=\"refresh\" content=\"1;URL=list_mc.php\">";
            } else {
                echo "<center><script> alert('Tidak Berjaya Disimpan!') </script></center>";
                echo "<meta http-equiv=\"refresh\" content=\"1;URL=list_mc.php\">";
            }

            // Close the statement
            $stmt->close();
        }
        else {
            echo "Error uploading file.";
        }
    }
    else {
        echo "Please select a PDF file.";
    }

    $conn->close();
}

?>
