<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Calendar</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../../plugins/fullcalendar/main.css">
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <?php include "../includes/styles.php"; ?>

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

<body class="hold-transition sidebar-mini">
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
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Kalendar IV</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Kalendar IV</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
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
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark"></aside>

  </div>

  <script src="../../../plugins/jquery/jquery.min.js"></script>
  <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="../../../dist/js/adminlte.min.js"></script>
  <script src="../../../plugins/moment/moment.min.js"></script>
  <script src="../../../plugins/fullcalendar/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
          }
        }
      });
      calendar.render();
    });
  </script>

  </div>
</body>

</html>