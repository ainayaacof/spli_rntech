<?php
// Start or resume the session
session_start();

include "../../conn.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RNTECH | Laman Utama</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../../../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../../dist/css/alt/splicss.css">
  <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../../plugins/fullcalendar/main.css">
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">

  <style>
    /* Custom style for highlighted days */
    .fc-day-has-event {
      background-color: lightgreen !important;
    }

    /* Secondary style for highlighted days (alternative) */
    .fc-day-has-event-secondary {
      background-color: lightskyblue !important;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">




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
              <h1 class="m-0">Laman Utama</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard_hr.php">Laman Utama</a></li>
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
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>
                    <?php
                    $namesm2 = mysqli_query($conn, "SELECT * FROM `application_intern` WHERE `status` = 'Baru'");
                    $numm2 = mysqli_num_rows($namesm2);
                    $myrowm2 = mysqli_fetch_array($namesm2);
                    print $numm2;
                    ?>
                  </h3>

                  <p>Permohonan Baru</p>
                </div>
                <div class="icon">
                  <i class="ion ion-university"></i>
                </div>
                <a href="SenaraiPermohonan/list_apply.php" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>
                    <?php
                    $namesm2 = mysqli_query($conn, "SELECT * FROM `student` WHERE `status`= 'Aktif'");
                    $numm2 = mysqli_num_rows($namesm2);
                    $myrowm2 = mysqli_fetch_array($namesm2);
                    print $numm2;
                    ?>
                  </h3>
                  <p>Jumlah Pelajar</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>
                <a href="SenaraiPelajar/list_student.php" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>
                    <?php
                    $namesm2 = mysqli_query($conn, "SELECT * FROM `supervisor` WHERE `status`= 'Aktif' ");
                    $numm2 = mysqli_num_rows($namesm2);
                    $myrowm2 = mysqli_fetch_array($namesm2);
                    print $numm2;
                    ?>
                  </h3>
                  <p>Jumlah Penyelia</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>
                    <?php
                    $namesm2 = mysqli_query($conn, "SELECT * FROM `feedback` WHERE `status`= 'Baru' ");
                    $numm2 = mysqli_num_rows($namesm2);
                    $myrowm2 = mysqli_fetch_array($namesm2);
                    print $numm2;
                    ?>
                  </h3>
                  <p>Aduan</p>
                </div>
                <div class="icon">
                  <i class="ion ion-chatbubble"></i>
                </div>
                <a href="Aduan/aduan.php" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>

        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="card card-primary">
                <div class="card-body p-0">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="eventModalLabel">Maklumat Temuduga</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p><strong>ID:</strong> <span id="modalStudentID"></span></p>
              <p><strong>Nama:</strong> <span id="modalNama"></span></p>
              <p><strong>Lokasi:</strong> <span id="modalLocation"></span></p>
              <p><strong>Masa :</strong> <span id="modalTime"></span></p>
              <div id="linkContainer">
                <p><strong>Link:</strong> <span id="modalLink"></span></p>
              </div>
              <!-- You can add more event details here if needed -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>

  <script src="../../../plugins/jquery/jquery.min.js"></script>
  <script src="../../../plugins/jquery-ui/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../plugins/chart.js/Chart.min.js"></script>
  <script src="../../../plugins/sparklines/sparkline.js"></script>
  <script src="../../../plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="../../../plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="../../../plugins/moment/moment.min.js"></script>
  <script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
  <script src="../../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="../../../plugins/summernote/summernote-bs4.min.js"></script>
  <script src="../../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="../../../dist/js/adminlte.js"></script>
  <script src="../../../plugins/jquery/jquery.min.js"></script>
  <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
  <script src="../../../plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="../../../dist/js/adminlte.min.js"></script>
  <script src="../../../plugins/fullcalendar/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../../splirntech/plugins/fullcalendar/locales/ms.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        eventClick: function(info) {
          // Display event details in the Bootstrap modal
          $('#modalStudentID').text(info.event.extendedProps.student_id);
          $('#modalLocation').text(info.event.extendedProps.location);
          $('#modalNama').text(info.event.extendedProps.student_name);


          var linkData = info.event.extendedProps.link;
          if (linkData !== null && linkData.trim() !== '') {
            $('#modalLink').text(linkData);
            $('#linkContainer').show();
          } else {
            $('#linkContainer').hide();
          }

          var eventTime = new Date(info.event.start);
          var formattedTime = eventTime.toLocaleString('en-US', {
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
          });
          $('#modalTime').text(formattedTime);

          // Show the modal
          $('#eventModal').modal('show');
        },
        editable: false,
        events: {
          url: 'event.php', // URL to fetch events
          method: 'POST',
          extraParams: {}, // Additional parameters if needed
          failure: function() {
            alert('There was an error while fetching events!');
          }
        },
        eventDidMount: function(info) {
          // If event exists on the day, highlight the background of the day
          if (info.event.start) {
            var el = info.el;
            el.style.backgroundColor = 'lightgreen';

            // var loc = info.event.extendedProps.location;

            // if (loc === 'Online Meeting') {
            //   el.style.backgroundColor = 'lightcoral';
            // } else {
            //   el.style.backgroundColor = 'lightgreen';
            // }
          }
        }
      });
      calendar.render();
    });
  </script>

</body>

</html>