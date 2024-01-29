<?php
// Start or resume the session
session_start();
$_POST['id'] = $_SESSION['id'];
$student_id = $_POST['id'];
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

  <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../dist/js/demo.js"></script>

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
              <h1 class="m-0">Kemaskini Tugasan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                <li class="breadcrumb-item"><a href="tugasan_pelajar.php">Kemaskini Tugasan</a></li>

                <!--BELOW THE LOOP-->

                <?php
                $unique_id = $unique_id = isset($_GET['unique_id']) ? $_GET['unique_id'] : null;

                if (isset($student_id) && isset($unique_id)) {
                  $query = "SELECT * FROM task_activity WHERE student_id = '" . $student_id . "' AND id = '" . $unique_id . "'";
                  $result = mysqli_query($conn, $query);
                  $num_rows = mysqli_num_rows($result);
                  while ($row = mysqli_fetch_array($result)) {
                ?>

                    <li class="breadcrumb-item"><a href="tugasan.php?student_id=<?php echo $student_id ?>&unique_week=<?php echo $row['week']; ?>">Senarai Tugasan</a></li>

                    <li class="breadcrumb-item active">Kemaskini Tugasan</li>
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
              <form method='post' id="update" action='maklumat_tugasan_pelajar_db.php?student_id=<?php echo $student_id; ?>&unique_id=<?php echo $unique_id; ?>$unique_week=<?php echo $row["week"]; ?>'>
                <div class="form-group">
                  <div class="mb-3">
                    <label for="week">Minggu</label>
                    <input type="text" class="form-control" name="week" value="<?php echo $row["week"]; ?>" readonly>
                  </div>

                  <div class="mb-3">
                    <label for="description">Keterangan</label>
                    <textarea class="form-control" name="description" style="height: 150px;"><?php echo $row["task_description"]; ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label for="date">Tarikh</label>
                    <input type="date" class="form-control" name="date" value="<?php echo $row["task_date"]; ?>">
                  </div>

                  <div class="mb-3">
                    <label for="time">Jumlah Masa</label>
                    <!-- <input type="text" class="form-control" name="time" value="<?php echo $row["total_time"]; ?>" readonly> -->
                    <input type="number" class="form-control" id="quantity" name="quantity" min="0" max="100" value="<?php echo $row["total_time"]; ?>">
                  </div>

                  <!-- <button type="submit" name="submit" class="btn btn-danger" onclick="return confirmUpdate()">Simpan</button> -->
                  <div class="d-flex justify-content-end">

                    <button type="submit" id="hantar" class="btn btn-primary" style="margin:5px;" onclick="return confirmUpdate()">Simpan</a></button>
                    <a href="tugasan.php?student_id=<?php echo $student_id ?>&unique_week=<?php echo $row['week']; ?>" style="margin:5px;" class="btn btn-secondary">Kembali</a>
                  </div>
                </div>
              </form>
            </div>
        <?php
                  }
                }
        ?>

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

  <script>

          $(document).on('click', 'form button[type="submit"]', function(e) {
          e.preventDefault();
          var form = $(this).parents('form'); // Get the form element

          Swal.fire({
              title: 'Anda pasti mahu simpan?',
              text: 'Perubahan akan disimpan!',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, simpan!',
              cancelButtonText: 'Batal'
          }).then((result) => {
              // Check if the user clicked "Ya, simpan!"
              if (result.isConfirmed) {
                  form.submit(); // Submit the form
            
              }
          });
      });
  </script>
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