<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../dist/js/demo.js"></script>

<?php
session_start();

include "../conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM `student` WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_id = $row['student_id'];
            $name = $row['name'];
        }
    }

    // Retrieve form data
    $reason = $_POST["reason"];
    $date_leave = $_POST["date_leave"];
    $date_end = $_POST["date_end"];

    // Set status and approved_by values
    $status = "Baru";  // Set the initial status to "mohon"
    $approved_by = 0;  // Set approved_by to null as it's not approved yet

    // File upload handling
    $targetDirectory = "../upload/cutifile/";

    // Create the directory if it doesn't exist
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    $targetFile = basename($_FILES["inputFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["inputFile"]["size"] > 5000000) {
        $uploadOk = 0;
        echo "<script type='text/javascript'>
            alert('Fail Saiz Terlalu Besar. Fail saiz perlu kurang daripada 5 MB.');
            </script>";
        exit();
    } else {
        if (empty($reason) || empty($date_leave) || empty($date_end)) {
        } else {
            // Insert data into the database
            $query = "INSERT INTO leave_app (student_id, reason, date_apply, date_leave, date_end, support_doc, status, approved_by)
            VALUES (?, ?, NOW(), ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Check if the prepare statement was successful
            if (!$stmt) {
                echo "Error in preparing the statement: " . $conn->error;
                exit();
            }

            $stmt->bind_param("sssssss", $_SESSION['id'], $reason, $date_leave, $date_end, $targetFile, $status, $approved_by);
            
            // Execute the query
            if ($stmt->execute()) {
                if (move_uploaded_file($_FILES["inputFile"]["tmp_name"], $targetDirectory . $targetFile)) {
                    error_log('File moved successfully to: ' . $targetDirectory . $targetFile);
                    // Display a success message using JavaScript
                    echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            Swal.fire({
                                title: "Berjaya Hantar",
                                text: "Permohonan cuti anda telah dihantar",
                                icon: "success"
                            }).then(function() {
                                window.location.replace("permohonan_cuti.php"); 
                            }, 1000);
                            }); </script>';
                } else {
                    error_log('Failed to move file to: ' . $targetDirectory . $targetFile);
                    echo "<script type='text/javascript'>
                        alert('Ralat Semasa Memasukkan Aduan. Terjadi ralat semasa memasukkan aduan. Sila cuba lagi.');
                    </script>";
                }
            } else {
                echo "<script type='text/javascript'>
                    alert('Ralat Semasa Memasukkan Aduan. Terjadi ralat semasa memasukkan aduan. Sila cuba lagi.');
                </script>";
            }

            // Close statement and connection
            $stmt->close();
        }
    }
}
$conn->close();
?>
