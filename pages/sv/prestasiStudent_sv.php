<?php
// Start or resume the session
session_start();

include "../conn.php";
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];

$_POST['sv_id'] = $_SESSION['sv_id'];
$sv_id = $_POST['sv_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RNTECH | Student</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.css">
    <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
    <link rel="stylesheet" href="../../dist/css/page.css">
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">


    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
                            <h1 class="m-0">Aktiviti Tugasan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Info Pelajar</li>
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
                            <h3 class="card-title"><b>MAKLUMAT PELAJAR</b></h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <!-- Info Pelajar -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Maklumat Pelajar</h4><br>
                                            <hr> <!-- Horizontal line for spacing -->
                                            <?php
                                            $student_id = $_REQUEST['student_id'];
                                            $query = "SELECT * FROM student WHERE student_id = '" . $student_id . "'";
                                            $result = mysqli_query($conn, $query);
                                            $num_rows = mysqli_num_rows($result);

                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <div class="card-text">
                                                    <p><strong>Nama Pelajar:</strong> <?php echo $row["name"]; ?></p>
                                                    <p><strong>Nombor Telefon:</strong> <?php echo $row["phone_num"]; ?></p>
                                                    <p><strong>Email:</strong> <?php echo $row["email"]; ?></p>
                                                    <p><strong>Alamat:</strong> <?php echo $row["address"]; ?></p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                                <!-- Info Universiti -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title"> Maklumat Universiti </h4><br>
                                            <hr> <!-- Horizontal line for spacing -->
                                            <?php
                                            $query = "SELECT * FROM application_intern WHERE student_id = '" . $student_id . "'";
                                            $result = mysqli_query($conn, $query);
                                            $num_rows = mysqli_num_rows($result);

                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <div class="card-text">
                                                    <p><strong>Kursus:</strong> <?php echo $row["course"]; ?></p>
                                                    <p><strong>Nama Universiti:</strong> <?php echo $row["uni_name"]; ?></p>
                                                    <p><strong>Nombor Telefon Universiti:</strong> <?php echo $row["uni_phone"]; ?></p>
                                                    <p><strong>Tarikh Latihan Industri:</strong> <?php echo date("d/m/Y", strtotime($row["start_intern"])); ?> - <?php echo date("d/m/Y", strtotime($row["last_intern"])); ?></p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.container-fluid -->
            </section><!-- Section 1 -->

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title"><b>PRESTASI PELAJAR</b></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h3 class="card-title">Graf Prestasi Tugasan Pelajar</h3>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                        <?php
                                        $query = "SELECT week, level FROM task_activity where student_id ='" . $_GET['student_id'] . "'";
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
                                </div><!--  END OF LINE CHART -->
                                <!-- ----------------------------------------------------------- ADUAN PELAJAR ----------------------------------------------------------- -->
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h3 class="card-title">Aduan yang Dikenakan</h3>
                                    </div>

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

                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                                <tr style="text-align:center">
                                                    <th>Bil.</th>
                                                    <th>Aduan</th>
                                                    <th>Tarikh Aduan</th>
                                                    <th>Masa Aduan</th>
                                                    <th>Jenis Aduan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                // Check if 'studname' is set in $_GET
                                                if (isset($_GET['studname'])) {
                                                    $studname = $_GET['studname'];
                                                    $query = "SELECT * FROM feedback where person_name ='" . $_GET['studname'] . "'";
                                                    $result = mysqli_query($conn, $query);

                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $i++ . "</td>";
                                                        echo "<td>" .  $row['description'] . "</td>";
                                                        echo "<td>" .  $row['date'] . "</td>";
                                                        echo "<td>" .  $row['time'] . "</td>";
                                                        echo "<td>" .  $row['feedback_type'] . "</td>";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>

                                    </div> <!-- /.card-body -->

                                </div> <!-- END OF ADUAN TABLE -->


                                <!-- Back button -->
                                    
                            </div><!-- END OF CLASS ROW -->
                            <button class="btn btn-secondary" style="margin:5px; float:right;"><a href="prestasiAll_sv.php" style="color:white">Kembali</a></button>
                        </div><!-- /.card-body -->
                    </div><!-- /.container-fluid -->
            </section><!-- Section 2 -->
            <br><br>
        </div>
        <?php
        include("includes/footer.php");
        ?>
    </div>



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
                    },
                    {
                        label: 'Memuaskan',
                        data: memuaskanData,
                        borderColor: 'yellow',
                        backgroundColor: 'rgba(255, 255, 0, 0.1)',
                    },
                    {
                        label: 'Tidak Memuaskan',
                        data: tidakmemuaskanData,
                        borderColor: 'red',
                        backgroundColor: 'rgba(255, 0, 0, 0.1)',
                    },
                    {
                        label: 'Sangat Tidak Memuaskan',
                        data: sangattidakmemuaskanData,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 128, 0, 0.1)',
                    },
                    {
                        label: 'Tiada',
                        data: tiadaData,
                        borderColor: 'orange',
                        backgroundColor: 'rgba(0, 128, 0, 0.1)',
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    </script>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

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

    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>


    <!-- Pagination function -->
    <script>
        $(function() {
            var table = $('#example2').DataTable({
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf"],
                "pageLength": 5, // tentukan satu page berapa data
                "searching": false // Disable searching
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