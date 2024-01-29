<?php
// Include necessary files and start the session if needed
session_start();
include "../../conn.php";

// Check if the ID is provided via GET parameter
if (isset($_GET['id'])) {
  $leave_id = $_GET['id'];

  // Query to fetch leave application details based on the provided ID
  $query = "SELECT la.id, la.student_id, la.date_apply, la.date_leave, la.reason, la.support_doc, la.status, s.name 
            FROM `leave_app` la 
            JOIN `student` s ON la.student_id = s.student_id 
            WHERE la.id = $leave_id";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $leaveDetails = mysqli_fetch_assoc($result);

    // Assign retrieved data to variables
    $name = $leaveDetails['name'];
    $date_apply = $leaveDetails['date_apply'];
    $date_leave = $leaveDetails['date_leave'];
    $reason = $leaveDetails['reason'];
    $resume = $leaveDetails['support_doc'];
    $status = $leaveDetails['status'];
  } else {
    // No leave application found with the provided ID
    echo "No data found";
    exit();
  }
} else {
  // Redirect if ID is not provided
  header("Location: list_mc.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RN TECH | Maklumat Pengguna</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../../dist/css/alt/splicss.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


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

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Maklumat Permohonan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Lihat: Maklumat Permohonan Cuti</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-navy">
                <div class="card-header">
                  <h4 class="card-title mb-0">Maklumat Permohonan Cuti</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th scope="row" style="width: 15%;">Nama</th>
                        <td>: <?php echo $name; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Tarikh Mohon</th>
                        <td>: <?php echo date('d/m/Y', strtotime($date_apply)); ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Tarikh Cuti</th>
                        <td>: <?php echo date('d/m/Y', strtotime($date_leave)); ?></td>
                      </tr>

                      <tr>
                        <th scope="row">Sebab</th>
                        <td>: <?php echo $reason; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Lampiran</th>
                        <td>
                          <?php if (!empty($resume)) { ?>
                            <a href="../../upload/<?php echo $resume; ?>" target="_blank" class="btn btn-sm btn-light" style="background-color: #ced4da;">
                              <i class="bi bi-download"></i> Muat Turun
                            </a>
                          <?php } else {
                            echo ": Tiada Lampiran";
                          } ?>
                        </td>
                      </tr>

                      <tr>
                        <th scope="row">Status</th>
                        <td>: <?php echo $status; ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="text-right mt-3">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                  </div>
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

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>


  <script src="../../../plugins/jquery/jquery.min.js"></script>
  <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../../plugins/jszip/jszip.min.js"></script>
  <script src="../../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="../../../dist/js/adminlte.min.js"></script>
  <script src="../PermohonanCuti/cuti.js"></script>

</body>

</html>