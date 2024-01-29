<?php
// Start or resume the session
session_start();

require_once('../../phpmailer/PHPMailerAutoload.php');
require_once('../../phpmailer/class.phpmailer.php');

include "../conn.php";
$pengadu = $_REQUEST['pengadu'];
$studname = $_REQUEST['studentName'];
$aduan = $_REQUEST['aduan'];
$date = $_REQUEST['date'];
$time = $_REQUEST['time'];
$type = $_REQUEST['type'];
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];

// Use prepared statement
$sql = "INSERT INTO feedback (pengadu_name, person_name, description, date, time, feedback_type)
        VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);

//auto calculated if status == aduan (>3) hantar noti amaran pada pelajar 

// Bind parameters
$stmt->bind_param("ssssss", $pengadu, $studname, $aduan, $date, $time, $type);

// Execute the statement
if ($stmt->execute()) {
    echo "<center><script> alert('Successfully Update!') </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"1;URL=aduan_sv.php\">";
} else {
    echo "<center><script> alert('Profile cannot be updated.'); </script></center>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=aduan_sv.php\">";
}


//calculate feedback to send email
// Function to calculate feedback_type
    $sql = "SELECT COUNT(*) AS type, student.email AS studemail FROM feedback INNER JOIN student
            WHERE feedback.person_name = '" . $studname . "' AND feedback.feedback_type = 'aduan'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $studemail = $row['studemail'];
    
  
      if ($type == 1) { // Aduan > 3 
        $mail = new PHPMailer();

        // Set the SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'splirnta@gmail.com';
        $mail->Password = 'Adminrnt_123';
    
        // Set the email content
        $mail->isHTML(true);
        $mail->Subject = 'Aduan Pertama';
        $mail->Body = '<p>Anda, <strong>' . $studname . '</strong> telah mendapat <strong>Amaran Pertama</strong></p><br><br>';
        $mail->Body .= '<p><strong>Catatan:</strong> E-mel ini dihantar secara automatik oleh sistem. Sila jangan balas e-mel ini.</p>';
    
        // Set the sender and recipient
        $mail->setFrom('splirnta@gmail.com', 'Admin RNTECH'); // change this to your Gmail address and desired sender name
        $mail->addAddress($studemail, $studname); // replace 'Recipient Name' with the desired recipient name
    
        if (!$mail->send()) {
            // Log the error
            error_log('Error sending email: ' . $mail->ErrorInfo);
            // Display a generic error message (you can handle this differently)
            return false;
        } else {
            // Email sent successfully
            return true;
        }
      }
      elseif ($type == 2) {
        $mail = new PHPMailer();

    // Set the SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'splirnta@gmail.com';
    $mail->Password = 'Adminrnt_123';

    // Set the email content
    $mail->isHTML(true);
    $mail->Subject = 'Aduan Pertama';
    $mail->Body = '<p>Anda, <strong>' . $studname . '</strong> telah mendapat <strong>Amaran Pertama</strong></p><br><br>';
    $mail->Body .= '<p><strong>Catatan:</strong> E-mel ini dihantar secara automatik oleh sistem. Sila jangan balas e-mel ini.</p>';

    // Set the sender and recipient
    $mail->setFrom('splirnta@gmail.com', 'Admin RNTECH'); // change this to your Gmail address and desired sender name
    $mail->addAddress($studemail, $studname); // replace 'Recipient Name' with the desired recipient name

    if (!$mail->send()) {
        // Log the error
        error_log('Error sending email: ' . $mail->ErrorInfo);
        // Display a generic error message (you can handle this differently)
        return false;
    } else {
        // Email sent successfully
        return true;
    }
      }
      elseif ($type >= 3) {
        $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'splirnta@gmail.com';
    $mail->Password = 'Adminrnt_123';                                
		//Sender
		$mail->From = "splirnta@gmail.com";
		$mail->FromName = "ICare2U Support";
		$mail->addAddress($studemail, $studname);			//Recepient
		$mail->isHTML(true);
		$mail->Subject = "Amaran";
		$mail->Body = "Banyak Aduan";
		$mail->AltBody = "This is the plain text version of the email content";
		
		if (!$mail->send()) {
            // Log the error
            error_log('Error sending email: ' . $mail->ErrorInfo);
            // Display a generic error message (you can handle this differently)
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            return false;
        } else {
            // Email sent successfully
            echo 'Message has been sent';
            return true;
        }
      }

// Close the statement and connection
$stmt->close();
$conn->close();
?>