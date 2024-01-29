	<!-- SWEEY ALERT -->
	<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="../../dist/js/demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
<?php

include_once "conn.php"; 

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo '<center><script> 
                        Swal.fire({
                            title: "Gagal",
                            text: "Sila masukkan Emel dan Katalaluan.",
                            icon: "error"
                        }).then(function() {
                            window.location.replace("../index.php"); 
                        }); </script></center>';
                        exit();
    } else {

        // --------------------------------------------------------------------- STUDENT --------------------------------------------------------------------- //
        $studentQuery = "SELECT * FROM student WHERE email = ? AND password = ?";
        $studentStmt = mysqli_prepare($conn, $studentQuery);
        

        if ($studentStmt) {
            mysqli_stmt_bind_param($studentStmt, "ss", $email, $password);
            mysqli_stmt_execute($studentStmt);
            $studentResult = mysqli_stmt_get_result($studentStmt);
            $studentRow = mysqli_fetch_assoc($studentResult);


            if ($studentRow) {
                $_SESSION['name'] = strtoupper($studentRow['name']);
                $_SESSION['phone_num'] = $studentRow['phone_num'];
                $_SESSION['address'] = $studentRow['address'];
				$_SESSION['id'] = $studentRow['student_id'];
                $_SESSION['studid'] = $studentRow['id'];
                $_SESSION['bank_slip'] = $studentRow['bank_slip'];
                $_SESSION['slip_ic'] = $studentRow['slip_ic'];
                $status = $studentRow['status'];

                if ($status == "Aktif"){
                    header("Location: student/dashboard_student.php");
                    exit();
                }
                else if($status == "Tidak Aktif"){
                    echo '<center><script> 
                            Swal.fire({
                                title: "Gagal",
                                text: "Harap Maaf. Akaun anda telah dinyahaktif.",
                                icon: "error"
                            }).then(function() {
                                window.location.replace("../index.php"); 
                            }); </script></center>';
                            exit();
                }
                
            }
            else {
                    echo '<center><script> 
                            Swal.fire({
                                title: "Gagal",
                                text: "Sila masukkan Emel dan Katalaluan yang betul.",
                                icon: "error"
                            }).then(function() {
                                window.location.replace("../index.php"); 
                            }); </script></center>';
            }
            
            
            mysqli_stmt_close($studentStmt);
        }

        // --------------------------------------------------------------------- SUPERVISOR --------------------------------------------------------------------- //
        $supervisorQuery = "SELECT * FROM supervisor WHERE email = ? AND password = ?";
        $supervisorStmt = mysqli_prepare($conn, $supervisorQuery);

        if ($supervisorStmt) {
            mysqli_stmt_bind_param($supervisorStmt, "ss", $email, $password);
            mysqli_stmt_execute($supervisorStmt);
            $supervisorResult = mysqli_stmt_get_result($supervisorStmt);
            $supervisorRow = mysqli_fetch_assoc($supervisorResult);

            if ($supervisorRow) {
                $_SESSION['name'] = $supervisorRow['name'];
                $_SESSION['phone_num'] = $supervisorRow['phone_num'];
                $_SESSION['position'] = $supervisorRow['position'];
				$_SESSION['id'] = $supervisorRow['id'];
                $_SESSION['sv_id'] = $supervisorRow['sv_id'];
                $status = $supervisorRow['status'];

                if ($status == "Aktif"){
                    header("Location: sv/dashboard_sv.php");
                    exit();
                }
                else if($status == "Tidak Aktif"){
                    echo '<center><script> 
                            Swal.fire({
                                title: "Gagal",
                                text: "Harap Maaf. Akaun anda telah dinyahaktif.",
                                icon: "error"
                            }).then(function() {
                                window.location.replace("../index.php"); 
                            }); </script></center>';
                            exit();
                }
            }
            else {
                    echo '<center><script> 
                            Swal.fire({
                                title: "Gagal",
                                text: "Sila masukkan Emel dan Katalaluan yang betul.",
                                icon: "error"
                            }).then(function() {
                                window.location.replace("../index.php"); 
                            }); </script></center>';
            }
            mysqli_stmt_close($supervisorStmt);
        }

        // --------------------------------------------------------------------- HR --------------------------------------------------------------------- //
        $hrQuery = "SELECT * FROM hr WHERE email = ? AND password = ?";
        $hrStmt = mysqli_prepare($conn, $hrQuery);

        if ($hrStmt) {
            mysqli_stmt_bind_param($hrStmt, "ss", $email, $password);
            mysqli_stmt_execute($hrStmt);
            $hrResult = mysqli_stmt_get_result($hrStmt);
            $hrRow = mysqli_fetch_assoc($hrResult);

            if ($hrRow) {
				$_SESSION['id'] = strtoupper($hrRow['id']);
                $_SESSION['name'] = strtoupper($hrRow['name']);
                $_SESSION['phone_num'] = $hrRow['phone_num'];
                $_SESSION['profile_pic'] = $hrRow['profile_pic'];


                header("Location: hr/dashboard/dashboard_hr.php");
                exit();
            }else {
                // Check if the result set is empty
                    echo '<center><script> 
                            Swal.fire({
                                title: "Gagal",
                                text: "Sila masukkan Emel dan Katalaluan yang betul.",
                                icon: "error"
                            }).then(function() {
                                window.location.replace("../index.php"); 
                            }); </script></center>';
                            exit();
            }
            mysqli_stmt_close($hrStmt);
        }
    }
} else {
    echo '<center><script> 
            Swal.fire({
                title: "Gagal",
                text: "Permintaan Login anda Tidak Berjaya.",
                icon: "error"
            }).then(function() {
                window.location.replace("../index.php"); 
            }); </script></center>';
            exit();
}
?>
