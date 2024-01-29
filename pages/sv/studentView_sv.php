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
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
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
                                                    <p><strong>Emel:</strong> <?php echo $row["email"]; ?></p>
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
                            <h3 class="card-title"><b>MINGGU TUGASAN</b></h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">Bil</th>
                                            <th width="50%">Minggu</th>
                                            <th width="10%" style="text-align:center">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $query = "SELECT student_id, MIN(week) AS unique_week, add_doc FROM task_activity WHERE student_id = '" . $student_id . "' GROUP BY student_id, week";
                                        $result = mysqli_query($conn, $query);
                                        $num_rows = mysqli_num_rows($result);

                                        if ($num_rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                                <tr>
                                                    <?php
                                                    echo "<td>" . $i++ . "</td>";
                                                    ?>
                                                    <td>Minggu&ensp;&ensp;<?php echo $row["unique_week"];
                                                                            $unique_week = $row["unique_week"]; ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <button type="button" class="btn btn-outline-info" data-toggle="tooltip" data-placement="top" title="Lihat">
                                                            <a href="studentActivityView_sv.php?student_id=<?php echo $student_id ?>&unique_week=<?php echo $unique_week ?>"><i class="fa fa-search"></i></a>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='4' style='text-align: center;'>Tiada Rekod Minggu</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Back button -->
                            <p></p>
                            <button type="button" class="btn btn-secondary" style="float:right">
                                <a href="studentlist_sv.php" style="text-decoration: none; color:white;">Kembali</a>
                            </button>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.container-fluid -->
            </section><!-- Section 2 -->
            <br><br>
        </div>
        <?php
        include("includes/footer.php");
        ?>
    </div>

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