<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RN TECH | Senarai Permarkahan</title>

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
              <h1 class="m-0">Senarai Permarkahan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Senarai Permarkahan</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-navy">
                <div class="card-header">
                  <h3 class="card-title">Senarai Kategori Permarkahan</h3>
                  <a href="add_mark.php" class="btn btn-navy btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Rekod Baru">
                    <i class="fas fa-plus"></i>
                    <span class="ml-1">Rekod Baru</span>
                  </a>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">Bil</th>
                        <th>Kategori</th>
                        <th width="15%">Tarikh Kuatkuasa</th>
                        <th width="11%">Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query = "SELECT * FROM `mark_category` WHERE `data_status`='1'";
                      $result = mysqli_query($conn, $query);
                      $num_rows = mysqli_num_rows($result);
                      $count = 1;
                      while ($myrow = mysqli_fetch_array($result)) {
                      ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><span class="category" id="categoryInput_<?php echo $myrow['id']; ?>" name="category"><?php echo $myrow['category']; ?></span></td>
                          <td><span class="date" id="dateInput_<?php echo $myrow['id']; ?>" name="date"><?php echo date('d/m/Y', strtotime($myrow['date_create'])); ?></span></td>
                          <td>
                            <a href="listCategoryData.php?id=<?php echo $myrow['id']; ?>&notify=1" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="View"><i class="fas fa-search"></i></a>
                            <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $myrow['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>
                            <button class="btn btn-info  btn-sm edit-btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-success btn-sm save-btn" style="display: none;" data-toggle="tooltip" data-placement="top" title="Save"><i class="fas fa-save"></i></button>
                          </td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>
  <?php include "../includes/scripts.php"; ?>
  <script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="js/list_mark.js"></script>



</body>

</html>