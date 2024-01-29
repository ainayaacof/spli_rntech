<?php
// Start or resume the session
session_start();

include "../conn.php";
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];

$_POST['sv_id'] = $_SESSION['sv_id'];
$sv_id = $_POST['sv_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RNTECH | ADUAN</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.css">
  <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
</head>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
      <img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
    </div>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <?php
    include("includes/navbar.php");
    ?>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <?php
    include("includes/mainsidebar.php");
    ?>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Tugasan</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="card-header">
              <h3>Kemaskini Tugasan</h3>
            </div>
            <?php
            if (isset($id)) {
              $todo_id = $_REQUEST['todo_id'];
              $query = "SELECT * FROM todo_sv WHERE sv_id = '" . $sv_id . "' AND todo_id ='" . $todo_id . "' ";
              //$query = "SELECT * FROM supervisor WHERE id = 2";
              $result = mysqli_query($conn, $query);
              $num_rows = mysqli_num_rows($result);

              /// get data from spli_db (supervisor table)
              while ($row = mysqli_fetch_array($result)) {
            ?>
                <!-- form start -->

                <div class="card-body">
                  <form method='post' action='updateTodo_svDB.php?todo_id=<?php echo $todo_id; ?>' class="form-horizontal">
                    <div class="form-group">

                      <p>
                        <label for="name">Tugasan</label><label style="color:red">*</label>
                        <input type="name" class="form-control" name="tugasan" id="tugasan" value="<?php echo $row['task']; ?>">
                      <p>
                        <label for="date">Tarikh</label><label style="color:red">*</label>
                        <input type="date" class="form-control" name="date" id="date" value="<?php echo $row['due_date']; ?>">
                      <p>
                        <label for="status">Status</label><label style="color:red">*</label>&emsp;&emsp;&emsp;
                        <input type="radio" name="status" id="status" value="on going" required>&emsp;Dalam Proses&emsp;&emsp;
                        <input type="radio" name="status" id="status" value="not yet" required>&emsp;Belum Bermula&emsp;&emsp;
                        <input type="radio" name="status" id="status" value="done" required>&emsp;Selesai&emsp;&emsp;
                      <p>
                        <button type='submit' name='submit' class='btn btn-secondary' style="float:right"><a href="dashboard_sv.php" style="color:white">Kembali</a></button>
                        <input type='submit' name='submit' value='Kemaskini' class='btn btn-primary' onclick='return confirmUpdate()' style="float:right; margin-right:5px">
                    </div>
                  </form>
                </div>
                <!-- /.card-body -->
            <?php
              }
            }
            ?>
          </div>
        </div>
      </section>


    </div>



    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
  <?php
  include("includes/footer.php");
  ?>

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