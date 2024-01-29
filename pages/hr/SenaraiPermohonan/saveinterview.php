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

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the form data
    $student_id = $_POST['id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $link = $_POST['onlineMeetingLink'];
    $statusInterview = "Temuduga";
    $statusApplicationIntern = "Temuduga"; // Status to update in application_intern

    $sql = "SELECT * FROM student WHERE id = '" . $student_id . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];

    $queryInterview = "INSERT INTO interview (student_id, interview_date, interview_time, location, interview_link, status)
                      VALUES ('$student_id', '$date', '$time', '$location', '$link', '$statusInterview')";

    $queryUpdateStatus = "UPDATE application_intern SET status = 'Temuduga'
    WHERE student_id = '" . $student_id . "'";
    if (mysqli_query($conn, $queryInterview)) {
        if (mysqli_query($conn, $queryUpdateStatus)) {
            // Status updated successfully in application_intern table
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

            // Prepare the email content
            $mail->isHTML(true);
            $formattedDate = date('d/m/y', strtotime($date));

            $mail->Subject = 'Interview Confirmation for Industrial Training';
            $mail->Body = "
                <p>Assalamualaikum & Good Afternoon,</p>
            
                <p>Dear $name,</p>
            
                <p>Congratulations on reaching the interview stage for Industrial Training at our Company.</p>
            
                <p>Details of your Interview:</p>
                <ul>
                    <li>Date: $formattedDate</li>
                    <li>Time: $time</li>
                    <li>Location: $location</li>
                </ul>";
            
            // Include online meeting link if the location is not RN Technologies
            if ($location == 'Online Meeting') {
                $mail->Body .= "<p>Online Meeting Link: $link</p>";
            }
        
            $mail->Body .= "
                <p>Please be prepared for the interview at the specified date, time, and location.";
            
            // Additional message if the location is RN Technologies
            if ($location == 'RN Technologies Sdn Bhd') {
                $mail->Body .= " The interview will be conducted at our office.";
            }
            
            $mail->Body .= "</p>
            
                <p>We look forward to meeting you and wish you the best of luck!</p>
            
                <p>Thank you.</p>
                <p>Best regards,<br>RN Technologies</p>
            ";

            // Sender and recipient
            $mail->setfrom('splirnta@gmail.com', 'Admin RN Tech');
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
        echo '<center><script> 
            Swal.fire({
                text: "Tiada ID pengguna, ' . $id . 'dalam data.",
                icon: "error"
            }); </script></center>';
    }
}
}
?>