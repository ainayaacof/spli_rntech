<?php
session_start();

include "../conn.php";

if (isset($_SESSION['name']) == '') {
  header("Location: ../login.php");
}

$sql = "SELECT * FROM `student` WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $user_id = $row['id'];
    $name = $row['name'];
    $student_id = $row['student_id'];
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RNTECH | Dashboard</title>

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
  <link rel="stylesheet" href="../../plugins/calendar/css/kalendar.css">
  <link rel="stylesheet" href="../../plugins/calendar/css/kalendar.css">
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

  <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../dist/js/demo.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Laman Utama</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Laman Utama</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <?php
              // Fetch start_intern and last_intern from the application_intern table
              $queryInternDate = "SELECT start_intern, last_intern FROM application_intern WHERE student_id = '" . $student_id . "'";
              $resultInternDate = mysqli_query($conn, $queryInternDate);

              if ($resultInternDate) {
                $rowInternDate = mysqli_fetch_array($resultInternDate);

                $startInternDateString = $rowInternDate['start_intern'];
                $lastInternDateString = $rowInternDate['last_intern'];

                $startInternDate = new DateTime($startInternDateString);
                $lastInternDate = new DateTime($lastInternDateString);

                // Calculate the difference in days
                $totalDays = $startInternDate->diff($lastInternDate)->days + 1;

                // Calculate the difference between today and the start intern date
                $daysPassed = $startInternDate->diff(new DateTime())->days + 1;

                // Display the result in your HTML
                echo "<div class='small-box bg-info'>
                <div class='inner'>
                  <h3>{$daysPassed}/{$totalDays}</h3>
                  <p>Hari Latihan Industri</p>
                </div>
                <div class='icon'>
                  <i class='ion ion-android-calendar'></i>
                </div>
                <a href='#' class='small-box-footer'><i class='ion-calendar'></i></a>
              </div>";
                  } else {
                    // Handle the case where the query fails
                    echo "Error: " . mysqli_error($conn);
                  }
              ?>

            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <?php
              // Fetch start_intern and last_intern from the application_intern table
              $queryInternWeek = "SELECT start_intern, last_intern FROM application_intern WHERE student_id = '" . $student_id . "'";
              $resultInternWeek = mysqli_query($conn, $queryInternWeek);

              if ($resultInternWeek) {
                $rowInternWeek = mysqli_fetch_array($resultInternWeek);

                // Assuming your start and last intern dates are retrieved from the database
                $startInternWeekString = $rowInternWeek['start_intern']; // Replace with the actual column name
                $lastInternWeekString = $rowInternWeek['last_intern'];   // Replace with the actual column name

                // Create DateTime objects from the date strings
                $startInternWeek = new DateTime($startInternDateString);
                $lastInternWeek = new DateTime($lastInternDateString);

                // Calculate the total difference in weeks
                $totalWeeks = ceil($startInternWeek->diff($lastInternWeek)->days / 7);

                // Calculate the difference between today and the start intern date in weeks
                $weeksPassed = ceil($startInternWeek->diff(new DateTime())->days / 7);

                // Display the result in your HTML
                echo "<div class='small-box bg-success'>
            <div class='inner'>
              <h3>{$weeksPassed}/{$totalWeeks}</h3>
              <p>Minggu Latihan Industri</p>
            </div>
            <div class='icon'>
              <i class='ion ion-stats-bars'></i>
            </div>
            <a href='#' class='small-box-footer'><i class='ion-stats-bars'></i></a>
          </div>";
              } else {
                // Handle the case where the query fails
                echo "Error: " . mysqli_error($conn);
              }
              ?>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <?php
              // Fetch the count of feedback entries for the logged-in user
              $queryFeedbackCount = "SELECT COUNT(*) AS feedback_count FROM feedback WHERE pekerja_id = '" . $student_id . "'";
              $resultFeedbackCount = mysqli_query($conn, $queryFeedbackCount);

              if ($resultFeedbackCount) {
                $rowFeedbackCount = mysqli_fetch_assoc($resultFeedbackCount);
                $feedbackCount = $rowFeedbackCount['feedback_count'];

                // Display the result in your HTML
                echo "<div class='small-box bg-danger'>
            <div class='inner'>
              <h3>{$feedbackCount}</h3>
              <p>Aduan Dibuat</p>
            </div>
            <div class='icon'>
              <i class='ion ion-android-warning'></i>
            </div>
            <a href='#' class='small-box-footer'><i class='ion-android-alert'></i></a>
          </div>";
              } else {
                // Handle the case where the query fails
                echo "Error: " . mysqli_error($conn);
              }
              ?>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <?php
              $queryTaskActivityCount = "SELECT COUNT(*) AS task_count FROM task_activity WHERE student_id = '" . $student_id . "'";
              $resultTaskActivityCount = mysqli_query($conn, $queryTaskActivityCount);

              if ($resultTaskActivityCount) {
                $rowTaskActivityCount = mysqli_fetch_assoc($resultTaskActivityCount);
                $taskActivityCount = $rowTaskActivityCount['task_count'];

                // Display the result in your HTML
                echo "<div class='small-box bg-warning'>
            <div class='inner'>
              <h3>{$taskActivityCount}</h3>
              <p>Laporan Harian</p>
            </div>
            <div class='icon'>
              <i class='ion ion-compose'></i>
            </div>
            <a href='#' class='small-box-footer'><i class='ion-ios-compose'></i></a>
          </div>";
              } else {
                // Handle the case where the query fails
                echo "Error: " . mysqli_error($conn);
              }
              ?>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-lg-6 connectedSortable">
              <div class="card card-navy" style="border: 1px solid navy;">
                <div class="card-header">
                  <h4 class="card-title"><b>Maklumat Umum</b></h4>
                </div><!-- /.card-header -->

                <?php
                $query = "SELECT student.name AS student_name, student.phone_num AS student_phone_num,
                supervisor.name AS supervisor_name, supervisor.phone_num AS supervisor_phone_num, application_intern.last_intern AS student_last_intern, 
              application_intern.start_intern AS student_start_intern
                FROM student
                LEFT JOIN supervisor ON student.sv_id = supervisor.sv_id
                LEFT JOIN application_intern ON student.student_id = application_intern.student_id
                WHERE student.student_id = '" . $student_id . "'";
                $result = mysqli_query($conn, $query);

                $num_rows = mysqli_num_rows($result);

                while ($row = mysqli_fetch_array($result)) {
                ?>
                  <div class="card-body">
                    <p><strong>Nama Pelajar:</strong>
                      <?php echo $row["student_name"]; ?>
                    </p>
                    <p><strong>Nombor Telefon pelajar:</strong>
                      <?php echo $row["student_phone_num"]; ?>
                    </p>
                    <p><strong>Tarikh Kemasukan:</strong>
                      <?php echo date('d/m/Y', strtotime($row['student_start_intern'])) ?>
                    </p>
                    <p><strong>Tarikh Tamat:</strong>
                      <?php echo date('d/m/Y', strtotime($row['student_last_intern'])) ?>
                    </p>
                    <hr style="border-color: black; border-width: 2px;">
                    <p><strong>Nama Penyelia Industri:</strong>
                      <?php echo $row["supervisor_name"]; ?>
                    </p>
                    <p><strong>Nombor Telefon Penyelia:</strong>
                      <?php echo $row["supervisor_phone_num"]; ?>
                    </p>
                  </div>
                <?php
                }
                ?>
              </div>

              <div class="card card-navy" style="border: 1px solid navy;">
                <div class="card-header">
                  <h3 class="card-title"><b>Graf Prestasi Mingguan</b></h3>
                </div><!-- /.card-header -->
                <div class="card-body" style="background-color: white;">
                  <div class="card-body" style="background-color: white;">
                    <canvas id="myChart" style="width:100%;max-width:800px"></canvas>
                    <?php
                    $query = "SELECT week, level FROM task_activity where student_id ='" . $student_id . "'";
                    $result = mysqli_query($conn, $query);


                    // ----------------------------------------------------------- LINE CHART ----------------------------------------------------------- //
                    // array to store data of week and level
                    $databyWeek = [];

                    while ($row = mysqli_fetch_array($result)) {
                      $week = $row["week"];
                      $level = $row["level"];

                      // Store data in the array
                      if (!isset($databyWeek[$week])) {
                        $databyWeek[$week] = ['Sangat Memuaskan' => 0, 'Memuaskan' => 0, 'Tidak Memuaskan' => 0, 'Sangat Tidak Memuaskan' => 0, 'Tiada' => 0];
                      }

                      $databyWeek[$week][$level]++;
                    }

                    // Convert PHP array to JavaScript format
                    $dataByWeekJson = json_encode($databyWeek);
                    ?>
                  </div>
                </div>
              </div>
            </section>

            <section class="col-lg-6 connectedSortable">
              <!-- CALENDAR -->
              <div class="card calendar" style="border:1px solid navy;">
                <div class="card-body">
                  <div class="container">
                    <div class="calendar">
                      <div class="header">
                        <div class="month"></div>
                        <div class="btns">
                          <div class="btn today-btn">
                            <i class="fas fa-calendar-day"></i>
                          </div>
                          <div class="btn prev-btn">
                            <i class="fas fa-chevron-left"></i>
                          </div>
                          <div class="btn next-btn">
                            <i class="fas fa-chevron-right"></i>
                          </div>
                        </div>
                      </div>
                      <div class="weekdays">
                        <div class="day">Ahad</div>
                        <div class="day">Isnin</div>
                        <div class="day">Selasa</div>
                        <div class="day">Rabu</div>
                        <div class="day">Khamis</div>
                        <div class="day">Jumaat</div>
                        <div class="day">Sabtu</div>
                      </div>
                      <div class="days">
                        <!-- add days using js -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
  </div>

  <div>
    <?php
    include("includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>

  <script>
      // Check if the login was successful
      <?php 

      $checkFile = "SELECT * FROM student WHERE student_id = '" .$_SESSION['id']. "'";
      $result = mysqli_query($conn, $checkFile);

      if ($result) {
      $row = mysqli_fetch_assoc($result);
      if ($row) {
        $slip_ic = $row['slip_ic'];
        $bank_slip = $row['bank_slip'];
      } else {
        echo "Name not found";
      }
      } else {
      echo "Error in SQL query: " . mysqli_error($conn);
      }
      
      if ($slip_ic == null && $bank_slip == null): ?>
          // Display a popup message
          Swal.fire({
                title: 'Selamat Datang!',
                icon: 'warning',
                text: 'Sila Kemaskini Maklumat Anda.',
                confirmButtonText: 'Kemaskini',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                // Handle the result if needed
                if (result.isConfirmed) {
                    window.location.replace("profile_student.php");
                } else {
                    // User clicked Cancel or closed the SweetAlert
                }
            });
      <?php endif; ?>
  </script>


  <!-- line chart script -->
  <script>
    var databyWeek = <?php echo $dataByWeekJson; ?>;

    var weeks = Object.keys(databyWeek);
    var sangatmemuaskanData = [];
    var memuaskanData = [];
    var tidakmemuaskanData = [];
    var sangattidakmemuaskanData = [];
    var tiadaData = [];

    weeks.forEach(function(week) {
      sangatmemuaskanData.push(databyWeek[week]['Sangat Memuaskan']);
      memuaskanData.push(databyWeek[week]['Memuaskan']);
      tidakmemuaskanData.push(databyWeek[week]['Tidak Memuaskan']);
      sangattidakmemuaskanData.push(databyWeek[week]['Sangat Tidak Memuaskan']);
      tiadaData.push(databyWeek[week]['Tiada']);
    });

    // javascript to create line chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: weeks,
        datasets: [{
            label: 'Sangat Memuaskan',
            data: sangatmemuaskanData,
            borderColor: 'green',
            backgroundColor: 'rgba(0, 128, 0, 0.1)',
            pointStyle: 'circle',
          },
          {
            label: 'Memuaskan',
            data: memuaskanData,
            borderColor: 'yellow',
            backgroundColor: 'rgba(255, 255, 0, 0.1)',
            pointStyle: 'circle',
          },
          {
            label: 'Tidak Memuaskan',
            data: tidakmemuaskanData,
            borderColor: 'red',
            backgroundColor: 'rgba(255, 0, 0, 0.1)',
            pointStyle: 'circle',
          },
          {
            label: 'Sangat Tidak Memuaskan',
            data: sangattidakmemuaskanData,
            borderColor: 'blue',
            backgroundColor: 'rgba(0, 128, 0, 0.1)',
            pointStyle: 'circle',
          },
          {
            label: 'Tiada',
            data: tiadaData,
            borderColor: 'orange',
            backgroundColor: 'rgba(0, 128, 0, 0.1)',
            pointStyle: 'circle',
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            type: 'linear', // Use 'linear' scale for x-axis
            position: 'bottom',
          },
        },
      },
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
  <script src="../../dist/js/pages/dashboard.js"></script>
  <script src="../../plugins/calendar/js/kalendar.js"></script>
</body>

</html>