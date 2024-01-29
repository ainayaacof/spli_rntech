<?php
session_start();

include "../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Tugasan Pelajar</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    

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
                            <h1 class="m-0">Tugasan Pelajar</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Tugasan Pelajar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-navy">
                        <div class="card-header">
                            <h3 class="card-title"><b>Maklumat Pelajar</b></h3>
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
                                            $query = "SELECT * FROM student WHERE student_id = '" . $_SESSION['id'] . "'";
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
                                            $query = "SELECT * FROM application_intern WHERE student_id = '" . $_SESSION['id'] . "'";
                                            $result = mysqli_query($conn, $query);
                                            $num_rows = mysqli_num_rows($result);

                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <div class="card-text">
                                                    <p><strong>Kursus:</strong> <?php echo $row["course"]; ?></p>
                                                    <p><strong>Nama Universiti:</strong> <?php echo $row["uni_name"]; ?></p>
                                                    <p><strong>Nombor Telefon Universiti:</strong> <?php echo $row["uni_phone"]; ?></p>
                                                    <p><strong>Tarikh Latihan Industri:</strong> <?php echo date("d/m/Y", strtotime($row["start_intern"])); ?> - <?php echo date("d/m/Y", strtotime($row["last_intern"]));
                                                                                                                                                                    ?></p>
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-navy">
                                <div class="card-header">


                                    <h4 class="card-title"><b>Minggu</b></h4><br>


                                </div>

                                <!-- "Show Entries" dropdown -->
                                <div class="row mt-4">
                                    <div class="col-md-3 ml-3">
                                        <!-- "Show Entries" dropdown -->
                                        <label for="entriesDropdown">Papar:</label>
                                        <select id="entriesDropdown">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 text-right">
                                        <!-- add week-->
                                        <a href="maklumat_tugasan_pelajar.php" class="btn btn-success"><i class="fa fa-plus">Tambah Minggu</i></a>
                                    </div>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div>
                                        <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">

                                            <?php
                                            $i = 1;
                                            $queryAktif = "SELECT student_id, MIN(week) AS unique_week, add_doc FROM task_activity WHERE student_id = '" . $_SESSION['id'] . "' GROUP BY student_id, week";
                                            $resultAktif = mysqli_query($conn, $queryAktif);
                                            $num_rows = mysqli_num_rows($resultAktif);
                                            ?>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">Bil</th>
                                                        <th width="30%">Minggu</th>
                                                        <!-- <th width="30%">Lampiran</th> -->
                                                        <th width="5%">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($num_rows > 0) {
                                                        while ($myrowAktif = mysqli_fetch_array($resultAktif)) {
                                                    ?>
                                                            <tr class="expandable-row">
                                                                <?php
                                                                echo "<td>" . $i++ . "</td>";
                                                                ?>
                                                                <td>Minggu&ensp;&ensp;<?php echo $myrowAktif["unique_week"]; ?></td>

                                                                <td style="text-align: center;">

                                                                    <button type="button" class="btn btn-outline-info">
                                                                        <a href="tugasan.php?student_id=<?php echo $_SESSION['id']; ?>&unique_week=<?php echo $myrowAktif["unique_week"]; ?>"><i class="fa fa-search"></i></a>
                                                                    </button>

                                                                    <!-- <button type="button" class="btn btn-outline-info">
                                                                        <a href="laporan_sv.php?student_id=<?php echo $_SESSION['id']; ?>&unique_week=<?php echo $myrowAktif["unique_week"]; ?>" target="_blank"><i class="fa">&#xf00d;</i></a>
                                                                    </button> -->
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='3' style='text-align: center;'>No Record</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#example1').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf"],
                "searching": false // Disable searching
            });

            // Reinitialize DataTable when "Show Entries" dropdown changes
            $('#entriesDropdown').on('change', function() {
                var entries = $(this).val();
                table.page.len(entries).draw();
            });

            // Add event listener to handle click event on "non-active" button
            $('#example1 tbody').on('click', '.delete-row-btn', function() {
                // Get the parent row of the clicked button
                var row = $(this).closest('tr');

                // Remove the row from the table
                if (row) {
                    table.row(row).remove().draw();
                }
            });

            // Add event listener to handle click event on "non-active" button outside of DataTable
            $(document).on('click', '.delete-row-btn', function() {
                var activeTab = document.querySelector('div:not([style="display:none"])');
                localStorage.setItem('tidak-aktif-tab', 'Your data from ' + activeTab.id);
            });

            // Get all the categories from category table
            $sql = "SELECT * FROM `weeks`";
            $all_weeks = mysqli_query($con, $sql);

            // Store the Category ID in a "id" variable
            $id = mysqli_real_escape_string($con, $_POST['Minggu']);

            $('#entriesDropdown').on('change', function() {
                var entries = $(this).val();
                table.page.len(entries).draw();
            });

            // Add event listener to handle click event on "Tambah Minggu" button
            $('#tambahMingguBtn').on('click', function() {
                // Assuming data
                var newRow = table.row.add([
                    '../../../ - ../../..',
                    '../../../ - ../../..',
                    'Minggu X',
                    'Status Y',
                    '<div class="btn-group">' +
                    '<a href="#" class="btn btn-primary btn-sm" style="margin:5px;" data-toggle="tooltip" data-placement="top" title="View">' +
                    '<i style="font-size:20px" class="fa">&#xf002; </i>' +
                    '</a>' +
                    '<a href="#" class="btn btn-warning btn-sm delete-row-btn" style="margin:5px;" data-toggle="tooltip" data-placement="top" title="non-active">' +
                    '<i style="font-size:20px" class="fa">&#xf00d;</i>' +
                    '</a>' +
                    '</div>'
                ]).draw(false).node();

                // Set a class to the new row for identification
                $(newRow).addClass('new-row');
            });
        });
    </script>
</body>

</html>