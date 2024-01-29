<?php
session_start();

$student_id = $_GET['student_id'];
$unique_week = $_GET['unique_week'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>

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
                            <h1 class="m-0">Senarai Tugasan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                                <li class="breadcrumb-item"><a href="tugasan_pelajar.php">Tugasan Pelajar</a></li>
                                <li class="breadcrumb-item active">Senarai Tugasan</li>
                            </ol>
                        </div><!-- /.col -->
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-navy">
                                <!-- "Show Entries" dropdown -->
                                <div class="row mt-4">
                                    <div class="col-md-6 ml-4">
                                        <!-- "Show Entries" dropdown -->
                                        <label for="entriesDropdown">Papar:</label>
                                        <select id="entriesDropdown">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>

                                    <div class="col-md-5 text-right">
                                        <div class="col-md-12 text-right">
                                            <!-- add week-->
                                            <a href="maklumat_tugasan_pelajar_tambah.php?unique_week=<?php echo $unique_week; ?>" class="btn btn-success"><i class="fa fa-plus">Tambah Aktiviti</i></a>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content" id="custom-tabs-two-tabContent">
                                            <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
                                                <?php
                                                // $student_id = $_GET['student_id'];  
                                                // $unique_week = $_GET['unique_week'];
                                                $queryAktif = "SELECT * FROM `task_activity` WHERE student_id ='" . $_SESSION['id'] . "' AND week = '" . $unique_week . "'";
                                                $resultAktif = mysqli_query($conn, $queryAktif);
                                                ?>
                                                <table id="example1" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tarikh</th>
                                                            <th>Tugasan</th>
                                                            <th>Waktu Bekerja (JAM)</th>
                                                            <th width="5%"> Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        if (mysqli_num_rows($resultAktif) > 0) {
                                                            while ($myrowAktif = mysqli_fetch_array($resultAktif)) {
                                                        ?>
                                                                <tr>
                                                                    <th>
                                                                        <?php echo $i++; ?>
                                                                    </th>
                                                                    <td>
                                                                        <?php echo date('d/m/Y', strtotime($myrowAktif['task_date'])); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        // separate sentence
                                                                        $description = $myrowAktif["task_description"];
                                                                        //split
                                                                        $sentences = preg_split('/(?=[0-9]\.)|(?=-)/', $description);
                                                                        foreach ($sentences as $sentence) {
                                                                            if (!empty($sentence)) {
                                                                                echo "<span style='display:block;'>$sentence</span>";
                                                                            }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $myrowAktif['total_time']; ?>
                                                                    </td>
                                                                    <?php
                                                                    $unique_week = $myrowAktif['week'];
                                                                    ?>
                                                                    <td>

                                                                        <!-- Action buttons -->
                                                                        <div class="btn-group">
                                                                            <a href="maklumat_tugasan_pelajar_edit.php?unique_id=<?php echo $myrowAktif['id']; ?>&unique_week<?php echo $unique_week; ?>" class="btn btn-primary" style="margin:1px;" title="Kemaskini"><i class="fas fa-pen"></i></a>
                                                                            <a href="tugasanDelete.php?unique_id=<?php echo $myrowAktif['id']; ?>&unique_week=<?php echo $unique_week; ?>" class="btn btn-danger" style="margin:1px;" title="Padam"><i style="font-size:20px" id="delete" class="fa fa-trash-o"></i></a>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td colspan="6">Tiada data</td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>

                                                    <script>
                                                        document.getElementById('delete').addEventListener('click', function() {
                                                            var activeTab = document.querySelector('div:not([style="display:none"])');
                                                            localStorage.setItem('tidak-aktif-tab', 'Your data from ' + activeTab.id);
                                                        });

                                                        
                                                    </script>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php
    include("includes/footer.php");
    ?>

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
    <!-- <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script> -->

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
});
    </script>

-->
    <script>
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["pdf"],
                "searching": false // Disable searching
            });

            $('#entriesDropdown').on('change', function() {
                var entries = $(this).val();
                table.page.len(entries).draw();
            });

            // Handle the "Tambah Aktivtiti" button click
            $('#keterangan').on('click', function() {
                // Clear the form
                $('#keteranganForm')[0].reset();

                // Set the modal title
                $('#keteranganModalLabel').text('Tambah Aduan');

                // Show the modal
                $('#keteranganModal').modal('show');
            });

            $('#example1 tbody').on('click', '.btn-info', function() {
                // Get the data of the clicked row
                var rowData = table.row($(this).closest('tr')).data();

                // Set the form values based on the row data
                $('#rowId').val(rowData[0]); // Assuming the ID is in the first column
                $('#date').val(rowData[1]); // Adjust accordingly for other columns

                // Set the modal title
                $('#keteranganModalLabel').text('Edit Aktiviti');

                // Show the modal
                $('#keteranganModal').modal('show');
            });

            $('#tambahMingguBtn').on('click', function() {
                // Clear the form
                $('#insertForm')[0].reset();

                // Set the modal title
                $('#keteranganModalLabel').text('Tambah Aktiviti');

                // Show the modal
                $('#keteranganModal').modal('show');
            });

            // Add this script to handle form submission via AJAX
            $(document).ready(function() {
                $("#insertForm").submit(function(event) {
                    event.preventDefault();

                    // Get form data
                    var formData = $(this).serialize();

                    // AJAX request to insert data
                    $.ajax({
                        type: "POST",
                        url: "", // Replace with your server-side script
                        data: formData,
                        success: function(response) {
                            // Handle success (if needed)
                            console.log(response);

                            // Close the modal
                            $("#keteranganModal").modal("hide");
                        },
                        error: function(error) {
                            // Handle error (if needed)
                            console.log(error);
                        }
                    });
                });
            });

            $('.btn-danger').click(function(e) {
				e.preventDefault();
				var deleteURL = $(this).attr('href');

				Swal.fire({
					title: 'Adakah anda pasti?',
					text: 'Data akan di padam dari sistem!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Padam!',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							type: 'GET',
							url: deleteURL, // Replace this URL with your delete endpoint
							success: function(response) {
								Swal.fire({
									title: 'Dihapuskan!',
									text: 'Maklumat telah berjaya dipadam.',
									icon: 'success'
								}).then(() => {
									location.reload(); // Refresh the page after successful deletion
								});
							},
							error: function() {
								Swal.fire({
									title: 'Ralat!',
									text: 'Gagal memadam maklumat.',
									icon: 'error'
								});
							}
						});
					}
				});
            });
        });

        

           

    </script>


</body>

</html>