<!DOCTYPE html>
<html lang="en">

<?php
// Start or resume the session
session_start();
include "../conn.php";
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RN TECH | Profile</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Loading indicator -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
    </div>


    <?php
    include("includes/navbar.php");
    include("includes/sidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Edit Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                ` <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Edit Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Student Edit Profile</h3>
                </div>

                <?php
                if (isset($id)) {
                  $query = "SELECT * FROM student WHERE id = '" . $id . "'";
                  $result = mysqli_query($conn, $query);
                  $num_rows = mysqli_num_rows($result);

                  /// get data from spli_db (student table)
                  while ($row = mysqli_fetch_array($result)) {
                ?>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="quickForm">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="InputName">Name</label>
                          <input type="name" name="name" class="form-control" id="InputName" value="<?php echo $row['name']; ?>">
                        </div>
                        <div class="form-group">
                          <label for="InputEmail1">Email address</label>
                          <input type="email" name="email" class="form-control" id="InputEmail1" value="<?php echo $row['email']; ?>">
                        </div>
                        <div class="form-group">
                          <label for="InputPhoneNumber">Phone Number</label>
                          <input type="PhoneNumber" name="PhoneNumber" class="form-control" id="InputPhoneNumber" value="<?php echo $row['phone_num']; ?>">
                        </div>
                        <div class="form-group">
                          <label for="Address">Address</label>
                          <input type="Address" name="Address" class="form-control" id="InputAddress" value="<?php echo $row['address']; ?>">
                        </div>
                        <div class="form-group">
                          <label for="Status">Status</label>
                          <input type="Status" name="Status" class="form-control" id="InputStatus" value="<?php echo $row['status']; ?>">
                        </div>
                        <div class="form-group mb-0">
                          <!-- <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                      <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label> -->
                        </div>
                      </div>
              </div>
              <!-- /.card-body -->
              <div>
                <button type="submit" class="btn btn-block btn-outline-info"><a href="profile_student.php">Submit</button>
              </div>
              </form>
            </div>

        <?php
                  }
                }
        ?>
        <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jquery-validation -->
  <script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    // $(function () {
    //   $.validator.setDefaults({
    //     submitHandler: function () {
    //       alert( "Form successful submitted!" );
    //     }
    //   });
    //   $('#quickForm').validate({
    //     rules: {
    //       email: {
    //         required: true,
    //         email: true,
    //       },
    //       password: {
    //         required: true,
    //         minlength: 5
    //       },
    //       terms: {
    //         required: true
    //       },
    //     },
    //     messages: {
    //       email: {
    //         required: "Please enter a email address",
    //         email: "Please enter a valid email address"
    //       },
    //       password: {
    //         required: "Please provide a password",
    //         minlength: "Your password must be at least 5 characters long"
    //       },
    //       terms: "Please accept our terms"
    //     },
    //     errorElement: 'span',
    //     errorPlacement: function (error, element) {
    //       error.addClass('invalid-feedback');
    //       element.closest('.form-group').append(error);
    //     },
    //     highlight: function (element, errorClass, validClass) {
    //       $(element).addClass('is-invalid');
    //     },
    //     unhighlight: function (element, errorClass, validClass) {
    //       $(element).removeClass('is-invalid');
    //     }
    //   });
    // });
  </script>
</body>

</html>