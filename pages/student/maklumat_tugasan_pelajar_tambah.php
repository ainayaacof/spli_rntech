<?php
// Start or resume the session
session_start();
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];
$unique_week = $_GET['unique_week'];
include "../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RN TECH | Task</title>

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

    <!-- Loading indicator -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
    </div>
    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <?php
    include("includes/navbar.php");
    ?>


    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <?php
    include("includes/sidebar.php");
    ?>

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Tambah Tugasan Harian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                <li class="breadcrumb-item"><a href="tugasan_pelajar.php">Tugasan Pelajar</a></li>
                <li class="breadcrumb-item"><a href="tugasan.php?student_id=<?php echo $id; ?>&unique_week=<?php echo $unique_week; ?>">Senarai Tugasan</a></li>
                <li class="breadcrumb-item active">Tambah Tugasan Harian</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">
          <div class="card card-navy">
            <div class="card-header">
              <h3 class="card-title">Maklumat Aktiviti Tugasan</h3>
            </div>
            <div class="card-body">
              <form method='post' action='maklumat_tugasan_pelajar_save.php?id=<?php echo $id; ?>' enctype='multipart/form-data'>
                <div class="form-group">
                  <div class="mb-3">
                    <label for="week">Minggu</label>
                    <input type="text" class="form-control" name="week" value=" <?php echo $unique_week; ?>" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="description">Keterangan</label>
                    <textarea class="form-control" name="description" style="height: 150px;" required></textarea>
                  </div>

                  <div class="mb-3">
                    <label for="date">Tarikh</label>
                    <input type="date" class="form-control" name="date" value="" required>
                  </div>

                  <div class="mb-3">
                    <label for="time">Jumlah Masa</label>
                    <!-- <input type="time" class="form-control" name="time" value="">  -->
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0" max="100" value="<?php echo $row["total_time"]; ?>" >



                  </div>

                  <!-- <div class="mb-3">
										<label for="comment">Komen</label>
										<input type="text" class="form-control" name="comment" value="" readonly>
									</div>
									 -->

                  <div class="d-flex justify-content-end">
                    <!-- <label for="document">Lampiran</label> -->
                    <br>
                    <!-- <label for="pdfFile">Choose a file:</label> -->
                    <!-- <input type="file" name="pdfFile" id="pdfFile" accept=".pdf"> -->
                    <br>
                    <button type="submit" class="btn btn-primary" style="margin:5px;" name="submit">Simpan Je</button>
                    <a href="tugasan.php?student_id=<?php echo $id; ?>&unique_week=<?php echo $unique_week; ?>" class="btn btn-secondary" style="margin:5px;">Kembali</a>

                  </div>
                </div>
              </form>
            </div>

          </div><!-- /.card -->
        </div><!-- /.container-fluid -->
      </section><!-- Section -->


      <br><br>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <?php
    include("includes/footer.php");
    ?>

    <!-- ---------------------------------------- FUNCTION ---------------------------------------- -->
    <?php

    function getNextWeek($conn, $id)
    {
      $nextWeek = "SELECT MAX(week) AS week FROM task_activity WHERE student_id = '" . $id . "'";
      $result = $conn->query($nextWeek);

      if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maxWeek = $row['week'];
        return $maxWeek + 1;
      }

      // Default to Week 1 if no records found
      return 1;
    }
    ?>


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