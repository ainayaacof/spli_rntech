<?php
session_start();
$sv_id = $_SESSION['sv_id'];
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
              <h1 class="m-0">Laman Utama</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
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

          <!-- Small boxes (Stat box) -->
          <div class="row">

            <!-- ----------------------------------------------------------- Total Student : ACTIVE ----------------------------------------------------------- -->
            <div class="col-lg-6 col-8">
              <!-- small box -->
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $query = "SELECT COUNT(*) AS count_result FROM student WHERE sv_id='" . $sv_id . "' AND status ='Aktif'";
                  $result = mysqli_query($conn, $query);

                  // Check if the query was successful
                  if ($result) {
                    // Fetch the row as an associative array
                    $row = mysqli_fetch_assoc($result);

                    // Check if the row exists
                    if ($row) {
                      // Output the name
                      // strtoupper for CAPS LOCK
                      echo "<h3>" . $row['count_result'] . "</h3>";
                    } else {
                      echo "Name not found"; // Handle the case when the row doesn't exist
                    }
                  } else {
                    echo "Error in SQL query: " . mysqli_error($conn); // Handle SQL query error
                  }
                  ?>

                  <p>Jumlah Pelajar : Aktif</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-alt"></i>
                </div>
                <a href="studentlist_sv.php?" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ----------------------------------------------------------- Total Student : NON-ACTIVE ----------------------------------------------------------- -->
            <div class="col-lg-6 col-8">
              <!-- small box -->
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $query = "SELECT COUNT(*) AS count_result FROM student WHERE sv_id='" . $sv_id . "' AND status ='Tidak Aktif'";
                  $result = mysqli_query($conn, $query);

                  // Check if the query was successful
                  if ($result) {
                    // Fetch the row as an associative array
                    $row = mysqli_fetch_assoc($result);

                    // Check if the row exists
                    if ($row) {
                      // Output the name
                      // strtoupper for CAPS LOCK
                      echo "<h3>" . $row['count_result'] . "</h3>";
                    } else {
                      echo "Name not found"; // Handle the case when the row doesn't exist
                    }
                  } else {
                    echo "Error in SQL query: " . mysqli_error($conn); // Handle SQL query error
                  }
                  ?>

                  <p>Jumlah Pelajar : Tidak Aktif</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-alt"></i>
                </div>
                <a href="studentlist_sv.php?" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ----------------------------------------------------------- TO DO List Box ----------------------------------------------------------- -->
            <section class="col-lg-12 connectedSortable">

              <!-- TO DO List -->
              <div class="card card-navy">
                <div class="card-header"><i class="ion ion-clipboard mr-1"></i>
                  <h3 class="card-title">
                    Senarai Tugasan
                  </h3>
                  <button type="button" class="btn" style="float:right" data-toggle="tooltip" data-placement="top" title="Tambah"><a href="addTodo_sv.php?"><i class="fas fa-plus"></i> Tambah</a></button>
                </div>

                <!-- TO-DO LIST -->
                <!-- /.card-header -->
                <div class="card-body">

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

                              <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-striped">
                                  <thead>
                                    <tr>
                                    <th>Bil.</th>
                                    <th>Tugasan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $i = 1;
                                    $query = "SELECT * FROM todo_sv WHERE sv_id = '" . $sv_id . "'";
                                    $result = mysqli_query($conn, $query);
                                    $num_rows = mysqli_num_rows($result);

                                    if ($row = mysqli_fetch_array($result) == null) {
                                      echo "<tr style='text-align:center'><td colspan='2'>Tiada Tugasan yang Disimpan</td></tr>";
                                    } else {
                                      $result = mysqli_query($conn, $query);
                                      $num_rows = mysqli_num_rows($result);
                                      while ($row = mysqli_fetch_array($result)) {
                                        $todo_id = $row["todo_id"];
                                        if ($row['is_done'] != "done") {
                                    ?><tr>
                                            <td>
                                              <?php echo $i++; ?>
                                            </td>
                                            <td>
                                              <label style="padding-right:40px">
                                                <span><?php echo $row['task']; ?></span>
                                              </label>
                                              <label style="padding-right:40px">
                                                <?php
                                                if ($row['is_done'] == 'on going') {
                                                ?><small class="badge badge-warning"><span><?php echo date('d/m/Y', strtotime($row['due_date'])) . "</span></small>";
                                                                                          }
                                                                                          if ($row['is_done'] == 'not yet') {
                                                                                            ?><small class="badge badge-info"><span><?php echo date('d/m/Y', strtotime($row['due_date'])) . "</span></small>";
                                                                                                                                  }
                                                                                                                                    ?>
                                              </label>
                                              <span class="tools" style="float:right">
                                                <button type="submit" class='btn btn-outline-info' data-toggle="tooltip" data-placement="top" title="Kemaskini"><a href="updateTodo_sv.php?todo_id=<?php echo $todo_id; ?>"><i class="fas fa-pen"></i></a></button>
                                              </span>
                                            </td>
                                            </td>
                                          </tr>
                                    <?php }
                                      }
                                    }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                            </div> <!-- TO-DO -->
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->

              </div>
            </section>
          </div>
      </section><br>

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
            "buttons": ["excel", "pdf", "colvis"],
            "language": {
                "emptyTable": "Tiada Tugasan yang Disimpan"
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        var table = $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "pageLength": 5, // tentukan satu page berapa data
            "autoWidth": false,
            "responsive": true,
            "language": {
                "emptyTable": "Tiada Tugasan yang Disimpan"
            }
        });

        // Reinitialize DataTable when "Show Entries" dropdown changes
        $('#entriesDropdown').on('change', function() {
            var entries = $(this).val();
            table.page.len(entries).draw();
        });

    });
</script>

  <!-- <script>
$(document).ready(function() {
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [
            'excel', 'pdf'
        ]
    });
}); -->
  </script>


</body>

</html>