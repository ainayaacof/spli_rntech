<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
<link rel="stylesheet" href="../../dist/css/alt/splicss.css">
<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../dist/js/demo.js"></script>

<?php
// Start or resume the session
session_start();
$_POST['st_id'] = $_SESSION['st_id'];
$st_id = $_POST['st_id'];

require_once('../../phpmailer/PHPMailerAutoload.php');
require_once('../../phpmailer/class.phpmailer.php');

include "../conn.php";
$pengadu = $_REQUEST['pengadu'];
$name = $_REQUEST['name'];
$aduan = $_REQUEST['aduan'];
$date = $_REQUEST['date'];
$time = $_REQUEST['time'];
$type = $_REQUEST['type'];
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];

// Use prepared statement to insert feedback data
$sql = "INSERT INTO feedback (pekerja_id, person_name, description, date, time, feedback_type, status) VALUES (?,?,?,?,?,?, 'Baru')";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ssssss", $st_id, $name, $aduan, $date, $time, $type);

// Execute the statement to insert feedback
if ($stmt->execute()) {
    //  Insertion successful
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Aduan anda telah berjaya dihantar",
        icon: "success"
    }).then(function() {
        window.location.replace("aduan_pelajar.php");
        clearForm();
    }); </script></center>';

    //  echo '<script type="text/javascript">
    //     Swal.fire({
    //         title: "Berjaya",
    //         text: "Aduan anda telah berjaya dihantar",
    //         icon: "success"
    //     }).then(function() => {
    //         window.location.replace("aduan_pelajar.php");
    //     });  
    //     </script>';

    // Count the total feedback of type 'aduan' for the person
    $sql_count = "SELECT COUNT(*) AS aduan_count FROM feedback WHERE person_name = ? AND feedback_type = 'aduan'";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param("s", $name);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $aduan_count = $row_count['aduan_count'];

    // Get student's email
    $sql_check_student = "SELECT email FROM student WHERE name = ?";
    $stmt_check_student = $conn->prepare($sql_check_student);
    $stmt_check_student->bind_param("s", $name);
    $stmt_check_student->execute();
    $result_check_student = $stmt_check_student->get_result();

    if ($result_check_student->num_rows > 0) {
        // It's a student, get the email
        $row_email = $result_check_student->fetch_assoc();
        $studemail = $row_email['email'];
    } else {
        // It might be a supervisor, check the supervisor table
        $sql_check_supervisor = "SELECT email FROM supervisor WHERE name = ?";
        $stmt_check_supervisor = $conn->prepare($sql_check_supervisor);
        $stmt_check_supervisor->bind_param("s", $name);
        $stmt_check_supervisor->execute();
        $result_check_supervisor = $stmt_check_supervisor->get_result();

        if ($result_check_supervisor->num_rows > 0) {
            // It's a supervisor, get the email
            $row_email = $result_check_supervisor->fetch_assoc();
            $studemail = $row_email['email'];
        } else {
            // Handle the case when the name is not found in either table
            echo "<script>alert('Name not found in student or supervisor table.');history.go(-1);</script>";
        }
    }
    // Check aduan count and send corresponding emails
    if ($aduan_count > 3 && $aduan_count < 6) {
        // Send email for Aduan Pertama
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'splirnta@gmail.com';
        $mail->Password = 'rhgirgmvnpjrrnol';

        // Set the email content for Aduan Pertama
        $mail->isHTML(true);
        $mail->Subject = 'First Warning: Multiple Violations';
        $mail->Body = '<p>Dear ' . $name . ',</p>';
        $mail->Body .= '<p>We hope this message finds you well. We\'ve noticed multiple instances of reported issues from our system. We encourage you to address these matters promptly to ensure a conducive environment for everyone involved.</p>';
        $mail->Body .= '<p>This is a friendly reminder to rectify the reported issues and ensure compliance with our guidelines and policies. Your attention to this matter is highly appreciated.</p>';
        $mail->Body .= '<p>Thank you for your cooperation.</p>';



        // Set the sender and recipient
        $mail->setFrom('splirnta@gmail.com', 'Admin RN Tech');
        $mail->addAddress($studemail, $name);

        // Send the email
        if (!$mail->send()) {
            // Display error message
            echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');history.go(-1);</script>";
        } else {
            // Display success message
            // echo "<script>alert('Email notification sent successfully.');history.go(-1);</script>";
            echo '<center><script>
            
            $(document).ready(function() {
                Swal.fire({
                    title: "Berjaya",
                    text: "Aduan anda telah berjaya dihantar.",
                    icon: "success"
                }).then(function() {
                    window.location.replace("aduan_pelajar.php"); 
                });
            });
            </script></center>';
        }
    } elseif ($aduan_count >= 6) {
        // Send email for being removed from the internship
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'splirnta@gmail.com';
        $mail->Password = 'rhgirgmvnpjrrnol';

        // Set the email content for Internship Termination
        $mail->isHTML(true);
        $mail->Subject = 'Final Warning: Internship Termination Notice';
        $mail->Body = '<p>Dear ' . $name . ',</p>';
        $mail->Body .= '<p>We regret to inform you that despite previous notifications, the reported issues have persisted, and they\'ve reached a critical point that affects the integrity of our program.</p>';
        $mail->Body .= '<p>Due to repeated violations, we must take strict actions to maintain the quality of our internship program. Regrettably, we have to terminate your internship with immediate effect.</p>';
        $mail->Body .= '<p>We thank you for your participation thus far and wish you the best in your future endeavors.</p>';

        // Set the sender and recipient
        $mail->setFrom('splirnta@gmail.com', 'Admin RN Tech');
        $mail->addAddress($studemail, $name);

        // Send the email
        if (!$mail->send()) {
            // Display error message
            echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');history.go(-1);</script>";
        } else {
            // Display success message
            echo '<center><script> 
            Swal.fire({
                title: "Berjaya",
                text: "Aduan anda telah berjaya dihantar.",
                icon: "success"
            }).then(function() {
                window.location.replace("aduan_pelajar.php"); 
            }); </script></center>';
        }
    }
} else {
    echo '<center><script> 
    Swal.fire({
        title: "Berjaya",
        text: "Aduan anda tidak berjaya dihantar.",
        icon: "success"
    }).then(function() {
        window.location.replace("aduan_pelajar.php"); 
    }); </script></center>';
}

// Close the statement and connection
$stmt->close();
$conn->close();
