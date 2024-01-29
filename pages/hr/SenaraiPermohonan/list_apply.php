<link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
<script src="sweetalert2/dist/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>



<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RNTECH | Senarai Permohonan</title>

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
                            <h1 class="m-0">Senarai Permohonan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Senarai Permohonan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-navy">
                                <div class="card-header">
                                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="senaraipemohon-tab" data-toggle="pill" href="#senaraipemohon" role="tab" aria-controls="senaraipemohon" aria-selected="true">Senarai Permohonan Latihan Industri</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="temuduga-tab" data-toggle="pill" href="#temuduga" role="tab" aria-controls="temuduga" aria-selected="false">Temuduga</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tetapSv-tab" data-toggle="pill" href="#tetapSv" role="tab" aria-controls="tetapSv" aria-selected="false">Tetapan Pilihan SV</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-two-tabContent">
                                        <div class="tab-pane fade show active" id="senaraipemohon" role="tabpanel" aria-labelledby="senaraipemohon-tab">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Bil.</th>
                                                        <th width="23%">Nama</th>
                                                        <th width="15%">Tarikh Permohonan</th>
                                                        <th width="15%">Tempoh Latihan Industri</th>
                                                        <th>Universiti</th>
                                                        <th width="19%" style="text-align: center;">Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $bil = 1;
                                                    $query = "SELECT application_intern.*, student.name, student.phone_num, student.email, student.address, student.id AS studID
                                                  FROM application_intern
                                                  JOIN student ON application_intern.student_id = student.id
                                                  WHERE application_intern.status = 'Baru'";
                                                    $result = mysqli_query($conn, $query);
                                                    $num_rows = mysqli_num_rows($result);
                                                    while ($myrow = mysqli_fetch_array($result)) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $bil++ ?></td>
                                                            <td><?php echo $myrow['name']; ?></td>
                                                            <td><?php echo date('d/m/Y', strtotime($myrow['apply_date'])); ?></td>
                                                            <td><?php echo $myrow['tempoh_intern'];?>&nbsp bulan</td>
                                                            <td><?php echo $myrow['uni_name']; ?></td>
                                                            <td class="text-center">
                                                                <a href="view_student.php?id=<?php echo $myrow['studID']; ?>&notify=1" class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="tooltip" data-placement="top" title="Terima"><i style="font-size:20px" class='fas fa-eye'></i></a>
                                                                <button class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="modal" data-target="#myModal_<?php echo $myrow['id']; ?>" data-placement="center" title="Temuduga" data-id="<?php echo $myrow['studID']; ?>"><i style='font-size:20px' class='fas fa-user-tie'></i></button>
                                                                <a href="terimaStudent.php?id=<?php echo $myrow['studID']; ?>&notify=1" class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="tooltip" data-placement="top" title="Terima"><i style="font-size:20px" class='fas fa-check'></i></a>
                                                                <a href="tolakStudent.php?id=<?php echo $myrow['studID']; ?>&notify=1" class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="tooltip" data-placement="top" title="Tolak"><i style="font-size:20px" class="fa">&#xf00d;</i></a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="tab-pane fade" id="temuduga" role="tabpanel" aria-labelledby="temuduga-tab">
                                            <?php
                                            $i = 1;
                                            $queryAktif = "SELECT interview.ID, interview.student_id, student.name AS name, interview.interview_date, interview.interview_time, interview.location, interview.interview_link, student.id AS studID
                                                FROM interview
                                                JOIN student ON interview.student_id = student.id
                                                WHERE interview.status='Temuduga'";

                                            $resultAktif = mysqli_query($conn, $queryAktif);

                                            if (!$resultAktif) {
                                                // Query execution failed, handle the error
                                                echo "Error: " . mysqli_error($conn); // Display the specific error message
                                            } else {
                                            ?>
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="3%">Bil.</th>
                                                            <th>Nama</th>
                                                            <th>Tarkih</th>
                                                            <th>Masa</th>
                                                            <th>Lokasi</th>
                                                            <th>Link Temuduga</th>
                                                            <th width="15%">Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (mysqli_num_rows($resultAktif) > 0) {
                                                            while ($myrowAktif = mysqli_fetch_array($resultAktif)) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $i++; ?> </td>
                                                                    <td><?php echo $myrowAktif['name']; ?></td>
                                                                    <td><?php echo date('d/m/Y', strtotime($myrowAktif['interview_date'])); ?></td>
                                                                    <td><?php echo date('h:i A', strtotime($myrowAktif['interview_time'])); ?></td>
                                                                    <td><?php echo $myrowAktif['location']; ?></td>
                                                                    <?php
                                                                    if ($myrowAktif['interview_link'] != null){?>
                                                                    <td><?php echo $myrowAktif['interview_link']; ?></td>
                                                                    <?php 
                                                                    }
                                                                    else if($myrowAktif['interview_link'] == null){ ?>
                                                                        <td>Tiada</td>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <a href="update_interview.php?id=<?php echo $myrowAktif['ID']; ?>" class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="tooltip" data-placement="top" title="Kemaskini"><i class="fas fa-edit" style="font-size: 20px;"></i></a>
                                                                        <a href="terimaStudent.php?id=<?php echo $myrowAktif['studID']; ?>&notify=1" class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="tooltip" data-placement="top" title="Terima"><i class="fas fa-check" style="font-size: 20px;"></i></a>
                                                                        <a href="tolakStudent.php?id=<?php echo $myrowAktif['studID']; ?>&notify=1" class="btn btn-outline-primary btn-sm" style="margin:2px;" data-toggle="tooltip" data-placement="top" title="Tolak"><i class="fas fa-times" style="font-size: 20px;"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td colspan="7">Tiada data</td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            <?php
                                            }
                                            ?>
                                        </div>



                                        <!-- Tab for Tetapan Pilihan SV -->
                                        <div class="tab-pane fade" id="tetapSv" role="tabpanel" aria-labelledby="tetapSv-tab">
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="3%">Bil.</th>
                                                        <th>ID</th>
                                                        <th>Nama</th>
                                                        <th>Universiti</th>
                                                        <th width="15%">Kursus</th>
                                                        <th width="30%">Pilih Penyelia Latihan Industri</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $bil = 1;
                                                    $query = "SELECT application_intern.*, student.name AS name, student.phone_num, student.email, student.address
                                            FROM application_intern
                                            JOIN student ON application_intern.student_id = student.student_id
                                            WHERE application_intern.status = 'Berjaya' AND student.sv_id = 'SV000'";

                                                    $result = mysqli_query($conn, $query);
                                                    $num_rows = mysqli_num_rows($result);

                                                    if ($num_rows > 0) {
                                                        while ($myrow = mysqli_fetch_array($result)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $bil++; ?></td>
                                                                <td><?php echo $myrow['student_id']; ?></td>
                                                                <td><?php echo $myrow['name']; ?></td>
                                                                <td><?php echo $myrow['uni_name']; ?></td>
                                                                <td><?php echo $myrow['course']; ?></td>
                                                                <?php $studentID = $myrow['student_id']; ?>
                                                                <td>
                                                                    <div id="supervisorDropdownContainer">
                                                                        <?php
                                                                        $supervisorQuery = "SELECT * FROM supervisor";
                                                                        $supervisorResult = mysqli_query($conn, $supervisorQuery);
                                                                        ?>
                                                                        <form id="selectSupervisorForm" action="update_supervisor.php?studentID=<?php echo $studentID; ?>" method="POST">
                                                                            <div class="form-group d-flex">
                                                                                <select id="supervisor_id" name="supervisor_id" class="form-control" required>
                                                                                    <option value="" selected disabled>Sila pilih penyelia industri</option>

                                                                                    <?php
                                                                                    while ($supervisor = mysqli_fetch_assoc($supervisorResult)) {
                                                                                        echo '<option value="' . $supervisor['sv_id'] . '">' . $supervisor['name'] . '</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <button id="doneChoosingSupervisorBtn" class="btn btn-primary ml-2">Selesai</button>
                                                                                <!-- Add a hidden input to store the student ID -->
                                                                                <div class="form-group d-flex">
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="7">Tiada Data</td>
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
                    </div>
                </div>
            </section>

            <!------------------------------------------Modal Maklumat Permohonan-------------------------------------------------------------->

            <?php
            $query = "SELECT application_intern.*, student.name, student.phone_num, student.email, student.address
                FROM application_intern
                JOIN student ON application_intern.student_id = student.id
                WHERE application_intern.status = 'Baru'";
            $result = mysqli_query($conn, $query);
            $bil = 1;
            while ($myrow = mysqli_fetch_array($result)) {
                $modalId = "viewUserDataModal_" . $bil;
            ?>
                <div class="modal fade" id="viewUserDataModal_<?php echo $myrow['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewUserDataModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewUserDataModalLabel">Maklumat Permohonan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" value="<?php echo $myrow['name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="phone_num">Phone Number:</label>
                                    <input type="text" class="form-control" id="phone_num" value="<?php echo $myrow['phone_num']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" value="<?php echo $myrow['email']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address:</label>
                                    <input type="text" class="form-control" id="address" value="<?php echo $myrow['address']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="uni_name">University Name:</label>
                                    <input type="text" class="form-control" id="uni_name" value="<?php echo $myrow['uni_name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="uni_phone">University Phone:</label>
                                    <input type="text" class="form-control" id="uni_phone" value="<?php echo $myrow['uni_phone']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="course">Course:</label>
                                    <input type="text" class="form-control" id="course" value="<?php echo $myrow['course']; ?>" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="mark">Mark:</label>
                                    <input type="text" class="form-control" id="mark" value="<?php echo $myrow['mark']; ?>" readonly>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                $bil++;
            }
            ?>

            <!------------------------------------------Modal Maklumat Temuduga -------------------------------------------------------------->
            <?php
            $query = "SELECT application_intern.*,  student.name, student.phone_num, student.email, student.address
              FROM application_intern
              JOIN student ON application_intern.student_id = student.id
              WHERE application_intern.status = 'Baru'";
            $result = mysqli_query($conn, $query);
            $num_rows = mysqli_num_rows($result);
            while ($myrow = mysqli_fetch_array($result)) {
            ?>
                <form action="saveinterview.php" method="POST">
                    <div class="modal fade" id="myModal_<?php echo $myrow['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Maklumat Temuduga</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-2 col-form-label">Tarikh:</label>
                                        <div class="col-sm-10">
                                            <input type="date" id="date" name="date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="time" class="col-sm-2 col-form-label">Masa:</label>
                                        <div class="col-sm-10">
                                            <input type="time" id="time" name="time" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="dropdown" class="col-sm-2 col-form-label">Lokasi:</label>
                                        <div class="col-sm-10">
                                            <select id="location" name="location" class="form-control" required>
                                                <option>Pilih Jenis Temuduga</option>
                                                <option value="Online Meeting">Online Meeting</option>
                                                <option value="RN Technologies Sdn Bhd">RN Technologies Sdn. Bhd.</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="post_time" value="<?php echo $currenttime; ?>">
                                    <input type="hidden" name="post_date" value="<?php echo $Date; ?>">
                                    <div class="form-group row" id="onlineMeetingLinkDiv" style="display: none;">
                                        <label for="onlineMeetingLink" class="col-sm-2 col-form-label">Link:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="onlineMeetingLink" name="onlineMeetingLink" placeholder="Enter Online Meeting Link">
                                        </div>
                                    </div>
                                    <input type="hidden" id="student_id" name="id" value="<?php echo $myrow['student_id']; ?>">
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" class="btn btn-primary" name="submit">Hantar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php
            }
            ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               


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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha512-Gn5384xqQ1aoPHyBY6lLzC2nSF/xMjDI1+tsvLVW5N1gDx0ehwMbxZ0tRW9LZ6a2uM2w8EYBGe8UFAO6H34WcQ==" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyFHS3hT4FQq6p3L/GDg6qjkA0rTl5o6v" crossorigin="anonymous"></script>
    <script src="../SenaraiPermohonan/permohonan.js"></script>



    
    <script>
        $(function() {
            // Check if the DataTable for #example2 exists and destroy it
            if ($.fn.DataTable.isDataTable('#example2')) {
                $('#example2').DataTable().destroy();
            }

            // Initialize DataTable for the second table
            $('#example2').DataTable({
                "paging": true, // Enable pagination
                "lengthChange": true, // Enable entries dropdown
                "searching": true, // Enable search box

            });
        });
    </script>

    <script>
        // jQuery script to show/hide the input field based on the selected option
        $(document).ready(function() {
            // Initial check on page load
            checkLocation();

            // Bind the change event of the dropdown
            $("#location").change(function() {
                // Check whenever the dropdown changes
                checkLocation();
            });

            function checkLocation() {
                // Get the selected value
                var selectedLocation = $("#location").val();

                // Check if the selected location is "Online Meeting"
                if (selectedLocation === "Online Meeting") {
                    // If "Online Meeting" is selected, show the input field
                    $("#onlineMeetingLinkDiv").show();
                } else {
                    // If any other option is selected, hide the input field
                    $("#onlineMeetingLinkDiv").hide();
                }
            }
        });
    </script>

</body>

</html>