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
        $sql_student = "UPDATE student SET status = 'Aktif' WHERE id = '" . $id . "'";
        if (mysqli_query($conn, $sql_student)) {
            // Update 'application_intern' table status to 'Berjaya'
            $sql_application = "UPDATE application_intern SET status = 'Berjaya' WHERE student_id = '" . $id . "'";
            mysqli_query($conn, $sql_application);

            // update status of interview
            $sql_interview = "UPDATE interview SET status ='Done' WHERE student_id = '" . $id . "'";
            mysqli_query($conn, $sql_interview);

            // Get the maximum student ID
            $queryMaxId = "SELECT MAX(student_id) as max_id FROM student";
            $resultMaxId = $conn->query($queryMaxId);

            if ($resultMaxId && $resultMaxId->num_rows > 0) {
                $rowMaxId = $resultMaxId->fetch_assoc();
                $maxId = $rowMaxId['max_id'];
            } else {
                $maxId = 0; // If no records are found, start from ID 1
            }

            // Extract the numeric part from the current maximum ID
            $numericPart = (int)filter_var($maxId, FILTER_SANITIZE_NUMBER_INT);

            // Increment the ID for the new student
            $newId = $numericPart+1;

            // Increment the numeric part
            $newNumericPart = $numericPart + 1;

            // Format the new ID back into the desired format
            $newId = "IS" . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);

            // Insert the new student into the database
            $queryInsert = "UPDATE student SET student_id = '" . $newId . "' WHERE id= '" . $id . "'";
            $resultInsert = $conn->query($queryInsert);

            $queryInsert = "UPDATE application_intern SET student_id = '" . $newId . "' WHERE student_id= '" . $id . "'";
            $resultInsert = $conn->query($queryInsert);

            $queryInsert = "UPDATE interview SET student_id = '" . $newId . "' WHERE student_id= '" . $id . "'";
            $resultInsert = $conn->query($queryInsert);


            

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
            $mail->Subject = 'Confirmation of Acceptance for Industrial Training';
            $mail->Body = "
                <p>Assalamualaikum & Good Afternoon,</p>

                <p>Congratulations $name,</p>

                <p>We are pleased to inform you that your application for Industrial Training at our Company has been accepted.</p>

                <p>Details of your Industrial Training:</p>
                <ul>
                    <li>Working days: Sunday - Thursday</li>
                    <li>Working hours: 9.00am - 6.00pm</li>
                    <li>Attire: Smart Casual</li>
                    <li>Facilities provided: Working space, PC's</li>
                    <li>Allowance: RM400 per month</li>
                </ul>

                <p>If you want to log in to the system, you can use the following credentials:</p>
                <p>Email: $email</p>
                <p>Password: $password</p>

                <p>We look forward to having you join us for this new journey. Welcome aboard!</p>

                <p>Thank you.</p>
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
        echo '<center><script> 
            Swal.fire({
                text: "Tiada ID pengguna, ' . $id . 'dalam data.",
                icon: "error"
            }); </script></center>';
    }
}
?>
