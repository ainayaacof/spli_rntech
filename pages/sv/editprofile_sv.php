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
    include("includes/mainsidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <!--  <h1 class="m-0">Profile</h1> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Profile</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <div class="card">
        <div class="col-sm-6">
          <p style="padding-left: 80px;"></p>
          <h1>Edit Profile</h1>
        </div>
        <?php
        if (isset($id)) {
          $query = "SELECT * FROM supervisor WHERE id = '" . $id . "'";
          //$query = "SELECT * FROM supervisor WHERE id = 2";
          $result = mysqli_query($conn, $query);
          $num_rows = mysqli_num_rows($result);

          /// get data from spli_db (supervisor table)
          while ($row = mysqli_fetch_array($result)) {
        ?>

            <div class="d-flex justify-content-between align-items-center mb-1">
              <!-- <h4 class="text-right"><p style="padding-top: 20px;">Edit Profile</p></h4> -->
            </div>
            <div class="tab-pane" id="settings">
              <form method='post' action='updateprofile_svDB.php' class="form-horizontal">
                <div class="form-group row">
                  <p style="padding-left: 20px;"><label for="inputStudentName" class="col-sm-12 col-form-label">Name</label></p>
                  <p style="padding-left: 95px;"></p>
                  <div class="col-sm-10">
                    <input type="name" class="form-control" name="sv_name" value="<?php echo $row['name']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <p style="padding-left: 20px;"><label for="inputPhoneNumber" class="col-sm-12 col-form-label">Phone Number</label></p>
                  <p style="padding-left: 30px;"></p>
                  <div class="col-sm-10">
                    <input type="phoneNumber" class="form-control" name="sv_phone" value="<?php echo $row['phone_num']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <p style="padding-left: 20px;"><label for="sv_email" class="col-sm-12 col-form-label">Email</label></p>
                  <p style="padding-left: 95px;"></p>
                  <div class="col-sm-10">
                    <p class="padding-left"><input type="email" class="form-control" name="sv_email" value="<?php echo $row['email']; ?>"></p>
                  </div>
                </div>
                <div class="form-group row">
                  <p style="padding-left: 20px;"><label for="sv_position" class="col-sm-12 col-form-label">Position</label></p>
                  <p style="padding-left: 80px;"></p>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="sv_status" value="<?php echo $row['position']; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <p style="padding-left: 20px;"><label for="sv_status" class="col-sm-12 col-form-label">Status</label></p>
                  <p style="padding-left: 90px;"></p>
                  <div class="col-sm-10">
                    <input style="padding-left: 20px;" type="text" class="form-control" name="sv_status" value="<?php echo $row['status']; ?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <input type='submit' name='submit' value='SAVE' class='btn btn-outline-info' onclick='return confirmUpdate()'>
                  </div>
                </div>
              </form>
            </div>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>


  <?php
  include("includes/footer.php");
  ?>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
  </div>

  <script src="../../plugins/jquery/jquery.min.js"></script>
  <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../plugins/chart.js/Chart.min.js"></script>
  <script src="../../plugins/sparklines/sparkline.js"></script>
  <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="../../plugins/moment/moment.min.js"></script>
  <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
  <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
  <script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="../../dist/js/adminlte.js"></script>
  <script src="../../dist/js/demo.js"></script>
  <script src="../../dist/js/pages/dashboard.js"></script>
</body>

</html>