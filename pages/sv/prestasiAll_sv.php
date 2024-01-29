<?php
session_start();
$_POST['sv_id'] = $_SESSION['sv_id'];
$sv_id = $_POST['sv_id'];
include "../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RNTECH | Senarai Pelajar</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

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
              <h1 class="m-0">Senarai Pelajar : Prestasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Senarai Pelajar Bawah Seliaan</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">
          <div class="card card-navy">
            <div class="card-header card-success">
              <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="aktif-tab" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="true">Aktif</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tidak-aktif-tab" data-toggle="pill" href="#tidak-aktif" role="tab" aria-controls="tidak-aktif" aria-selected="false">Senarai Terdahulu</a>
                </li>
              </ul>
            </div><!-- ./card-header -->
            

            <div class="card-body">
              <div class="tab-content" id="custom-tabs-two-tabContent">

                <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">

                  <div class="col-md-3 ml-3">
                    <!-- "Show Entries" dropdown -->
                    <label for="entriesDropdown">Papar:</label>
                    <select id="entriesDropdown">
                      <option value="5" selected>5</option>
                      <option value="10">10</option>
                      <option value="15">25</option>
                      <option value="20">50</option>
                    </select>
                  </div>

                  <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Bil.</th>
                          <th>Nama Pelajar</th>
                          <th>Nombor Telefon</th>
                          <th>Emel</th>
                          <th>Status</th>
                          <th style="text-align:center">Tindakan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 1;
                        $query = "SELECT * FROM student WHERE sv_id = '" . $sv_id . "' AND status='Aktif'";
                        $result = mysqli_query($conn, $query);
                        $num_rows = mysqli_num_rows($result);

                        if ($row = mysqli_fetch_array($result) == null) {
                          echo "<tr style='text-align:center'><td colspan='6'>Tiada Pelajar dibawah Penyeliaan Anda</td></tr>";
                        } else {
                          $result = mysqli_query($conn, $query);
                          $num_rows = mysqli_num_rows($result);
                          while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $i++ . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["phone_num"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            $student_id = $row['student_id']; ?>
                            <td style="text-align:center"><button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Lihat"><a href="prestasiStudent_sv.php?student_id=<?php echo $student_id; ?>"><i class="fa fa-search"></i></a></button>
                            </td>
                            </tr>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div> <!-- PELAJAR AKTIF -->

                <div class="tab-pane fade" id="tidak-aktif" role="tabpanel" aria-labelledby="tidak-aktif-tab">
                  <div class="table-responsive">

                <div class="col-md-3 ml-3">
                  <!-- "Show Entries" dropdown -->
                  <label for="entriesDropdown">Papar:</label>
                  <select id="entriesDropdown">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                  </select>
                </div>

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                    <tr style="text-align:center">
                      <th>Bil.</th>
                      <th>Nama Pelajar</th>
                      <th>Nombor Telefon</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1;
                    $query = "SELECT * FROM student WHERE sv_id = '" . $sv_id . "' AND status='Tidak Aktif'";
                    $result = mysqli_query($conn, $query);
                    $num_rows = mysqli_num_rows($result);

                    if ($row = mysqli_fetch_array($result) == null) {
                      echo "<tr style='text-align:center'><td colspan='6'>Tiada Pelajar dibawah Penyeliaan Anda</td></tr>";
                    } else {
                      $result = mysqli_query($conn, $query);
                      $num_rows = mysqli_num_rows($result);
                      while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $i++ . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["phone_num"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        $student_id = $row['student_id']; ?>
                        <td style="text-align:center"><button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Lihat"><a href="prestasiStudent_sv.php?student_id=<?php echo $student_id ?>&studname=<?php echo $row['name'] ?>"><i class="fa fa-search"></i></a></button>
                        </td>
                        </tr>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div><!-- PELAJAR : TIDAK AKTIF -->

                </div> 
              </div>
              
            </div><!-- /.card-body -->
          </div><!-- /.card navy -->
        </div><!-- /.container-fluid -->
      </section>

    </div>

    <?php
    include("includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
  <script src="../../plugins/jquery/jquery.min.js"></script>
  <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../plugins/jszip/jszip.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="../../dist/js/adminlte.min.js"></script>


  <!-- Page specific script -->
<script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["excel", "pdf", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      var table = $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 5,
        "responsive": true,
      });
      // Reinitialize DataTable when "Show Entries" dropdown changes
      $('#entriesDropdown').on('change', function() {
        var entries = $(this).val();
        table.page.len(entries).draw();
      });
    });
  </script>


</body>

</html>