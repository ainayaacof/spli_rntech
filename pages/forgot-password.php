<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> SPLIRNT | Forgot Password</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head> 

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h3"><b>Lupa Katalaluan</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Katalaluan yang baru akan di hantar ke email yang berdaftar. Sila semak emel anda.</p>
                <form id="forgotPasswordForm" action="forgot-password-send.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Emel">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success btn-block">Hantar</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="login.php">Halaman Log Masuk</a>
                </p>
            </div>
        </div>
    </div>


<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#forgotPasswordForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'forgot-password-send.php', // Update this URL to your password change endpoint
            data: formData,
            success: function(response) {
                // Handle success - Show success message using SweetAlert
                Swal.fire({
                    title: 'Berjaya!',
                    text: 'Sila lihat emel anda untuk proses penukaran katalaluan.',
                    icon: 'success'
                }).then(function() {
                    // Redirect to login.php after displaying success message
                    window.location.href = 'login.php';
                });
            },
            error: function() {
                // Handle error - Show error message using SweetAlert
                Swal.fire({
                    title: 'Ralat!',
                    text: 'Proses penukaran katalaluan tidak berjaya.',
                    icon: 'error'
                });
            }
        });
    });
</script>


</body>
</html>
