<link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../dist/js/demo.js"></script>

<?php
include "conn.php";
// Start or resume the session
session_start();

    // $id = $_SESSION['id'];
// if (isset($_POST['submit'])) {
    $apply_date = $_POST['dateApply'];
    $student_name = $_POST['name'];
    $student_email = $_POST['email'];
    $student_address = $_POST['address'];
    $student_phone = $_POST['phone_num'];
    $apply_date = $_POST['dateApply'];
    $apply_time = $_POST['timeApply'];
    $uni_name = $_POST['universiti'];
    $uni_phone = $_POST['phoneNumU'];
    $course = $_POST['course'];
    $last_intern = $_POST['dateEnd'];
    $start_intern = $_POST['dateStart'];
    // $bankName = $_POST['bank_name'];
    // $bankAcc = $_POST['bank_acc'];


    $post_id = $_GET['post_id']; // get post_id of the tawaran post

    $start_datetime = new DateTime($start_intern); 
    $diff = $start_datetime->diff(new DateTime($last_intern)); 
    $tempoh = $diff->m;



    // Check if the file input is set and not empty
    if (isset($_FILES['resumeFile']) && isset($_FILES['uniFile']) &&
        !empty($_FILES['resumeFile']['name']) && !empty($_FILES['uniFile']['name'])) {

        // -----------------------------get file name --------------------------------------- //
        // resume file name//
        $resumeFileName = $_FILES['resumeFile']['name'];
        $resumeTempName = $_FILES['resumeFile']['tmp_name'];

        // university letter file name//
        $uniFileName = $_FILES['uniFile']['name'];
        $uniTempName = $_FILES['uniFile']['tmp_name'];

        // ic file name//
        // $icFileName = $_FILES['icFile']['name'];
        // $icTempName = $_FILES['icFile']['tmp_name'];
        
        // ------------------- rename file attachment --------------------------------------- //
        // rename resume file --------
        $newResumeFile = $student_name . "_resume_" . $resumeFileName;
        // rename uni letter file --------
        $newUniFile = $student_name . "_uniLetter_" . $uniFileName;
        // rename ic file --------
        // $newICFile = $student_name . "_IC_" . $icFileName;
        
        // ------------------------------------------------------------------------------------------------------------------------------------- //

        // folder name for new application
        $folderName = 'permohonanfile';
        

        // directory path the file attachment it will be saved
        $directoryPath = __DIR__ . '/upload/' . $folderName;

        // Check if the directory doesn't exist
        if (!is_dir($directoryPath)) {
            // The directory doesn't exist, so create it
            mkdir($directoryPath);
        }

        // directory path for each file attachment
        $uploadPathResume = $directoryPath . '/' . $newResumeFile;
        $uploadPathUni = $directoryPath . '/' . $newUniFile;
        // $uploadPathIC = $directoryPath . '/' . $newICFile;

        // echo "<br>directory path for file resume name:" . $uploadPathResume;
        // echo "<br>directory path for file uni letter name:" . $uploadPathUni;
        // echo "<br>directory path for file ic name:" . $uploadPathIC;

        // Move the file attachment to the specified directory:- $uploadPathResume,  $uploadPathUni, $uploadPathIC -------------------------------------------------------------- //
        if (move_uploaded_file($resumeTempName, $uploadPathResume) && move_uploaded_file($uniTempName, $uploadPathUni)) {
            // Insert data into the student table
            $password = generatePassword();
            $queryStudent = "INSERT INTO student (name, phone_num, email, password, address, sv_id, status, student_id) VALUES (?,?,?,?,?,'SV000','Baru', 'IS000')";
            $stmtStudent = $conn->prepare($queryStudent);

            // Bind parameters
            $stmtStudent->bind_param("sssss", $student_name, $student_phone, $student_email, $password, $student_address);
            $stmtStudent->execute();
            $stmtStudent->close();
            
            //----- get student unique id to be insert into application_intern as a temporary student_id -----//
            $queryID = "SELECT * FROM student WHERE name = ? AND email = ?";
            $stmtID = $conn->prepare($queryID);

            // Bind parameters
            $stmtID->bind_param("ss", $student_name, $student_email);
            $stmtID->execute();
            $result = $stmtID->get_result();

            // output data of each row
            while($row = $result->fetch_assoc()) {
                $studentNo_ID = $row['id'];
            }


            // Insert data into the application_intern table
            $query = "INSERT INTO application_intern (student_id, apply_date, apply_time, uni_name, uni_phone, course, resume, uni_letter, last_intern, start_intern, intern_post_id, status, tempoh_intern) VALUES (?,?,?,?,?,?,?,?,?,?,?, 'Baru',?)";
            $stmt = $conn->prepare($query);

            // Bind parameters
            $stmt->bind_param("isssssssssis", $studentNo_ID, $apply_date, $apply_time, $uni_name, $uni_phone, $course, $newResumeFile, $newUniFile, $last_intern, $start_intern, $post_id, $tempoh);
            $updateResult = mysqli_stmt_execute($stmt);

            if ($updateResult) {
                // If update is successful, show a pop-up and redirect to list_apply.php

                echo '<center><script> 
                        Swal.fire({
                            title: "Berjaya",
                            text: "Permohonan Anda Berjaya Dihantar! Kami akan menghantar email untuk tindakan selanjutnya.",
                            icon: "success"
                        }).then(function() {
                            window.location.replace("../index.php"); 
                        }); </script></center>';
            } else {
                // If there is an error, display the error message
                echo 'Error: ' . mysqli_error($conn);
            }
        } else {
        echo "Error uploading file.";
        }
    }
    else {
        echo '<center><script> 
                Swal.fire({
                    title: "Tidak Berjaya",
                    text: "Maklumat yang diisi perlulah lengkap dengan dokumen.",
                    icon: "error"
                }).then(function() {
                    window.location.replace("../index.php"); 
                }); </script></center>';
    }

$conn->close();
// }

function generatePassword() {
    // Generate a random 6-digit number
    $password = rand(100000, 999999);
    return $password;
}
?>