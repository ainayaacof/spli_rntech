<?php
include "conn.php";
require_once('../phpmailer/PHPMailerAutoload.php');
require_once('../phpmailer/class.phpmailer.php');

if (isset($_POST['email'])) {
    include("conn.php");

    $email = $_POST['email'];

    $query_student = "SELECT * FROM student WHERE email = '$email'";
    $query_supervisor = "SELECT * FROM supervisor WHERE email = '$email'";
    $query_hr = "SELECT * FROM hr WHERE email = '$email'";

    $result_student = mysqli_query($conn, $query_student);
    $result_supervisor = mysqli_query($conn, $query_supervisor);
    $result_hr = mysqli_query($conn, $query_hr);

    $num_student = mysqli_num_rows($result_student);
    $num_supervisor = mysqli_num_rows($result_supervisor);
    $num_hr = mysqli_num_rows($result_hr);

    if ($num_student > 0 || $num_supervisor > 0 || $num_hr > 0) {

        $query = '';
        $tableName = '';
        if ($num_student > 0) {
            $query = "SELECT * FROM student WHERE email = '$email'";
            $tableName = 'student_table';
        } elseif ($num_supervisor > 0) {
            $query = "SELECT * FROM supervisor WHERE email = '$email'";
            $tableName = 'supervisor_table';
        } elseif ($num_hr > 0) {
            $query = "SELECT * FROM hr WHERE email = '$email'";
            $tableName = 'hr_table';
        }

        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        $usernameapply = $row["name"]; 
        $recoveremail = $row["email"]; 

        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
        $rexpDate = date("Y-m-d H:i:s", $expFormat);
        $rkey = md5(2418 * 2);
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $rkey = $rkey . $addKey;

        mysqli_query($conn, "INSERT INTO `password_reset_temp` (`remail`, `rkey`, `rexpDate`) VALUES ('$email', '$rkey', '$rexpDate')");

        $output = '<p>Dear ' . $usernameapply . ',</p>';
        $output .= '<p>Please click on the following link to reset your password.</p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p><a href="http://localhost/splirnt/pages/resetPassword.php?key=' . $rkey . '&email=' . $recoveremail . '&action=reset" target="_blank">Click Here</a></p>';
        $output .= '<p>-------------------------------------------------------------</p>';
        $output .= '<p>Please be sure to copy the entire link into your browser. The link will expire after 1 day for security reasons.</p>';
        $output .= '<p>If you did not request this forgotten password email, no action is needed. However, for security reasons, you may want to change your password.</p>';
        $output .= '<p>Thanks,</p>';
        $output .= '<p>ICare2u</p>';

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'splirnta@gmail.com';
        $mail->Password = 'rhgirgmvnpjrrnol';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->From = "splirnta@gmail.com"; 
        $mail->FromName = "Admin Support";
        $mail->addAddress($email, "Recipient User");
        $mail->isHTML(true);
        $mail->Subject = "[SPLI-Notification] Password Recovery - " . $rexpDate;
        $mail->Body = $output;
        $mail->AltBody = "This is the plain text version of the email content";

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $mesej = "An email has been sent to you with instructions on how to reset your password.";
            ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
            ?><script type="text/JavaScript"> setTimeout("location.href='/splirnt/pages/login.php';",0);</script> <?php
            exit;
        }
    } else {
        $mesej = "Inactive or invalid recovery email. Please make sure your email is already registered before.";
        ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
        ?><script type="text/JavaScript"> setTimeout("location.href='/splirnt/pages/login.php';",0);</script> <?php
        exit;
    }
}
?>
