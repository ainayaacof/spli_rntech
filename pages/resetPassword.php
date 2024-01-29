<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Forgot Password (v2)</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>


<?php
extract($_POST);
extract($_GET);

// reset action check
if (isset($pass1) && isset($pass2)) {
    if ($pass1 != $pass2) {
        $mesej = "Password not match.";
        ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
        ?><script type="text/JavaScript"> setTimeout("location.href='resetPassword.php?key=<?php print $hkey; ?>&email=<?php print $hemail; ?>&action=reset';",0);</script> <?php
        exit;
    } else {
        include("conn.php");

        // Check if email exists in student table
        $query_student = "SELECT * FROM student WHERE email ='$hemail'";
        $result_student = mysqli_query($conn, $query_student);
        $num_student = mysqli_num_rows($result_student);

        // Check if email exists in supervisor table
        $query_supervisor = "SELECT * FROM supervisor WHERE email ='$hemail'";
        $result_supervisor = mysqli_query($conn, $query_supervisor);
        $num_supervisor = mysqli_num_rows($result_supervisor);

        // Check if email exists in hr table
        $query_hr = "SELECT * FROM hr WHERE email ='$hemail'";
        $result_hr = mysqli_query($conn, $query_hr);
        $num_hr = mysqli_num_rows($result_hr);

        // Identify the table with the matching email and update password
        if ($num_student > 0) {
            mysqli_query($conn, "UPDATE student SET password='$pass1' WHERE email ='$hemail'");
        } elseif ($num_supervisor > 0) {
            mysqli_query($conn, "UPDATE supervisor SET password='$pass1' WHERE email ='$hemail'");
        } elseif ($num_hr > 0) {
            mysqli_query($conn, "UPDATE hr SET password='$pass1' WHERE email ='$hemail'");
        }

        // Delete entry from password_reset_temp
        mysqli_query($conn, "DELETE FROM password_reset_temp WHERE remail='$hemail'");
        
            $mesej = "Password recovery successful. Please login with the new password.";
            ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
            ?><script type="text/JavaScript"> setTimeout("location.href='http://localhost/splirntV1/pages/login.php';",0);</script> <?php
            exit;
        }
    }

// reset action check
if (isset($key) && isset($email) && isset($action)) {
    include("conn.php");
    $curDate = date("Y-m-d H:i:s");
    $names = mysqli_query($conn, "SELECT * FROM password_reset_temp WHERE remail='$email' AND rkey='$key'");
    $num = mysqli_num_rows($names);
    $myrow = mysqli_fetch_array($names);
    if ($num > 0) {
        //call table item
        $remail = $myrow["remail"];
        $rkey = $myrow["rkey"];
        $rexpDate = $myrow["rexpDate"];
        if ($rexpDate >= $curDate) {
            //Link valid
        } else {
            $mesej = "The link is expired. You are trying to use the expired link which is valid only 24 hours after the request.";
            ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
            ?><script type="text/JavaScript"> setTimeout("location.href='http://localhost/splirntV1/pages/login.php';",0);</script> <?php
            exit;
        }
    } else {
        $mesej = "The link is invalid/expired. Either you did not copy the correct link from the email, or you have already used the key in which case it is deactivated.";
        ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
        ?><script type="text/JavaScript"> setTimeout("location.href='http://localhost/splirntV1/pages/login.php';",0);</script> <?php
        exit;
    }
} else {

    $mesej = "The link is invalid/expired. Either you did not copy the correct link from the email, or you have already used the key in which case it is deactivated.";
    ?><script type="text/javascript"> alert("<?php print $mesej; ?>");</script><?php
    ?><script type="text/JavaScript"> setTimeout("location.href='http://localhost/splirntV1/pages/login.php';",0);</script> <?php
    exit;
}
?>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-success">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h3"><b>Reset Katalaluan</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sila masukkan katalaluan baru anda.</p>

      <form class="login100-form validate-form" id="reset-password-form" action="#" method="post">
        <div class="input-group mb-3">
          <input class="form-control" type="password" id="pass1" name="pass1" placeholder="New Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input class="form-control" type="password" id="pass2" name="pass2" placeholder="Retype Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-block">Reset Password</button>
          </div>
        </div>

        <!-- Hidden fields -->
        <input type="hidden" name="hkey" id="hkey" value="<?php print $rkey; ?>">
        <input type="hidden" name="hemail" id="hemail" value="<?php print $remail; ?>">
      </form>
      
      <!-- Back to Homepage link -->
      <p class="mt-3 mb-1">
        <a href="../" class="text-left">Back to Homepage</a>
      </p>
    </div>
  </div>
</div>

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>