<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RN TECH | Senarai Pelajar</title>

  <?php include "../includes/styles.php"; ?>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Loading indicator -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
    </div>



    <?php
    include("../includes/navbar.php");
    include("../includes/sidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Hebahan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Hebahan </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-10">
              <div class="card-body">
                <!-- Horizontal Form -->
                <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Iklan Latihan Industri</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <?php
                  date_default_timezone_set('Asia/Kuala_Lumpur');
                  $Date = gmdate('Y-m-d');
                  $currenttime = date('h:ia');
                  ?>
                  <form action="hebahan_save.php" method="POST">

                    <div class="card-body">
                      <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Tajuk</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="title" placeholder="" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" name="description" rows="3" placeholder="" required></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="datefrom" class="col-sm-2 col-form-label">Tarikh Dari</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" name="date_from" placeholder="dd/mm/yy" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="dateto" class="col-sm-2 col-form-label">Tarikh hingga</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" name="date_to" placeholder="dd/mm/yy" required>
                        </div>
                      </div>
                      </div>
                    </div>
                    <input type="hidden" name="post_time" value="<?php echo $currenttime; ?>">
                    <input type="hidden" name="post_date" value="<?php echo $Date; ?>">
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                  </form>
                  <!-- /.form -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </section>



    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
  <?php include "../includes/scripts.php"; ?>

</body>

</html>