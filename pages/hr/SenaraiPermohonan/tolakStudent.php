<link rel="stylesheet" href="../../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../../dist/js/demo.js"></script>

<?php
// Include necessary PHPMailer files
require_once '../../../phpmailer/PHPMailerAutoload.php';
require_once '../../../phpmailer/class.phpmailer.php';
require_once '../../conn.php'; // Include the conn.php file for database connection

if (isset($_GET['notify'])) {
    $id = $_GET['id'];

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die('Could not connect to the database: ' . mysqli_connect_error());
    }

    // Fetch student details
    $sql = "SELECT * FROM student WHERE id = '" . $id . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];

        // Update the student status to 'Aktif'
        $sql_student = "UPDATE student SET status = 'Gagal' WHERE id = '" . $id . "'";
        if (mysqli_query($conn, $sql_student)) {
            // Update 'application_intern' table status to 'Berjaya'
            $sql_application = "UPDATE application_intern SET status = 'Gagal' WHERE student_id = '" . $id . "'";
            mysqli_query($conn, $sql_application);

            // Create a new PHPMailer instance
            $mail = new PHPMailer();

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'splirnta@gmail.com';
            $mail->Password = 'rhgirgmvnpjrrnol';

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Notification Regarding Your Industrial Training Application';
            $mail->Body = "
                <p>Dear <strong>$name</strong> ,</p>
                <p>We hope this message finds you well.</p>
                <p>We regret to inform you that after careful consideration, your application for Industrial Training at RN Technologies has not been successful on this occasion.</p>
                <p>Please do not be discouraged as the selection process was highly competitive, and we appreciate your interest in our program.</p>
                <p>We wish you the very best in your future endeavors and encourage you to pursue other opportunities. Thank you for considering RN Technologies for your Industrial Training.</p>
                <p>Thank you for your understanding.</p>
                <p>Best regards,<br>RN Technologies</p>
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
                    text: "Emel pengesahan berjaya di hantar ke penerima. ",
                    icon: "success"
                }).then(function() {
                    window.location.replace("list_apply.php");
                }); </script></center>';

            }
        } else {
            die('Error updating student status: ' . mysqli_error($conn));
        }

        mysqli_close($conn);
    } else {
        echo "No student found with ID: $id";
    }
}
?>
