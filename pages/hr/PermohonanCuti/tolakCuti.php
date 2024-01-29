<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
require_once '../../../phpmailer/PHPMailerAutoload.php';
require_once '../../../phpmailer/class.phpmailer.php';
require_once '../../conn.php';
session_start();

if (isset($_GET['notify']) && isset($_SESSION['id'])) {
    $leave_id = $_GET['id'];
    $hr_user_id = $_SESSION['id'];

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die('Could not connect to the database: ' . mysqli_connect_error());
    }

    // Fetch leave application details
    $sql = "SELECT * FROM leave_app WHERE id = '$leave_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    
        $student_id = $row['student_id'];
        $date_leave = date('d/m/Y', strtotime($row['date_leave']));
        $date_end = $row['date_end'] !== null ? date('d/m/Y', strtotime($row['date_end'])) : null;
    
        // Update the status of the leave application to 'Lulus' and set approved_by field with HR user ID
        $sql_update = "UPDATE leave_app SET status = 'Ditolak', approved_by = '$hr_user_id' WHERE id = '$leave_id'";
        if (mysqli_query($conn, $sql_update)) {
            // Fetch student details from the 'student' table based on student_id
            $sql_student = "SELECT * FROM student WHERE student_id = '$student_id'";
            $result_student = mysqli_query($conn, $sql_student);
    
            if ($result_student && mysqli_num_rows($result_student) > 0) {
                $student_row = mysqli_fetch_assoc($result_student);
    
                $name = $student_row['name'];
                $email = $student_row['email'];
                $mail = new PHPMailer();

                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->Username = 'splirnta@gmail.com';
                $mail->Password = 'rhgirgmvnpjrrnol';

                $mail->isHTML(true);
                $mail->Subject = 'Pemberitahuan: Permohonan Cuti Ditolak';
                $mail->Body = "
                    <p>Tuan/Puan $name yang dihormati,</p>
                
                    <p>Dengan segala hormatnya, kami ingin memaklumkan bahawa permohonan cuti anda telah ditolak oleh pihak Pengurusan Sumber Manusia (HR).</p>
                
                    <p>Butiran:</p>
                    <ul>
                        <li>Tarikh Cuti: $date_leave</li>
                    </ul>
                
                    <p>Terima kasih.</p>
                    <p>Sekian, <br>RN Technologies Sdn Bhd </p>
                ";
                
                // Sender and recipient
                $mail->setFrom('splirnta@gmail.com', 'Admin RN Tech');
                $mail->addAddress($email, $name);

                // Send email and handle success/error
                if (!$mail->send()) {
                    // Display error message
                    echo "<script>alert('Error sending email: " . $mail->ErrorInfo . "');history.go(-1);</script>";
                } else {
                    // Display success message
                    echo '<center><script> 
                    Swal.fire({
                        title: "Berjaya",
                        text: "Pemberitahuan Status Cuti Berjaya Dihantar. ",
                        icon: "success"
                    }).then(function() {
                        window.location.replace("list_mc.php");
                    }); </script></center>';
                }
            } else {
                echo "No student found with ID: $student_id";
            }
        } else {
            die('Error updating leave application status: ' . mysqli_error($conn));
        }

        mysqli_close($conn);
    } else {
        echo "No leave application found with ID: $id";
    }
}
?>
