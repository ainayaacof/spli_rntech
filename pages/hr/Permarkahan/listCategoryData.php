<?php
session_start();

include "../../conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT ma.*, mc.category AS category_name 
              FROM `mark_apply` ma 
              JOIN `mark_category` mc ON ma.mark_category_id = mc.id 
              WHERE ma.`data_status`='1' AND ma.mark_category_id = $id";
} else {
    $query = "SELECT ma.*, mc.category AS category_name 
              FROM `mark_apply` ma 
              JOIN `mark_category` mc ON ma.mark_category_id = mc.id 
              WHERE ma.`data_status`='1'";
}

$result = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($result);

$category_name = '';
$mark_category_id = '';

if ($num_rows > 0) {
    $row = mysqli_fetch_array($result);
    $category_name = $row['category_name'];
    $mark_category_id = $row['mark_category_id'];
    mysqli_data_seek($result, 0);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Senarai Kelas Markah</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../../dist/css/alt/splicss.css">
    <?php include "../includes/styles.php"; ?>

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
                            <h1 class="m-0">Senarai Kelas Permarkahan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Senarai Kelas Permarkahan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Senarai Kategori Permarkahan: <?php echo $category_name; ?></h3>
                                    <button type="button" class="btn btn-navy btn-sm float-right text-white" id="addRecordButton" data-toggle="modal" data-target="#addDataModal">
                                        <i class="fas fa-plus"></i>
                                        <span class="ml-1">Rekod Baru</span>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <!-- Your content here -->
                                    <table id="example1" class="table table-bordered table-striped">
                                        <!-- Table content -->
                                        <thead>
                                            <tr>
                                                <th width="5%" style="text-align: center;">Bil</th>
                                                <th>Kelas</th>
                                                <th width="20%" style="text-align: center;">Markah</th>
                                                <th width="10%" style="text-align: center;">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            while ($myrow = mysqli_fetch_array($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $myrow['type']; ?></td>
                                                    <td style="text-align: center;"><?php echo $myrow['mark']; ?></td>
                                                    <td>
                                                        <center>
                                                            <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $myrow['id']; ?>" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                            <button class="btn btn-info btn-sm edit-btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                                                            <button class="btn btn-success btn-sm save-btn" style="display: none;" data-toggle="tooltip" data-placement="top" title="Save"><i class="fas fa-save"></i></button>
                                                        </center>
                                                    </td>
                                                </tr>
                                            <?php
                                                $counter++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer">
                                    <button onclick="goBack()" class="btn btn-info back-button">
                                        <i class="fas fa-chevron-circle-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Add New Data Modal -->
            <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDataModalLabel">Tambah Data Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addDataForm">
                            <div class="modal-body">
                                <!-- Your form inputs here -->
                                <div class="form-group">
                                    <label for="type">Kelas</label>
                                    <input type="text" class="form-control" id="type" name="type" required>
                                </div>
                                <div class="form-group">
                                    <label for="mark">Markah</label>
                                    <input type="text" class="form-control" id="mark" name="mark" required>
                                </div>
                                <!-- Add a hidden input for mark_category_id -->
                                <input type="hidden" id="mark_category_id" name="mark_category_id" value="<?php echo $mark_category_id; ?>">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
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
    <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../../dist/js/adminlte.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/mark.js"></script>

    <script>
        $(document).ready(function() {
            // Show add data modal when clicking the button
            $('#addRecordButton').on('click', function() {
                var markCategoryId = "<?php echo $mark_category_id; ?>";
                $('#mark_category_id').val(markCategoryId);
                $('#addDataModal').modal('show');
            });

            $('#addDataForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'saveData.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addDataModal').modal('hide'); // Hide the modal on success

                        // Show SweetAlert upon successful addition
                        Swal.fire({
                            title: 'Berjaya!',
                            text: 'Rekod berjaya di tambah.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Refresh the page
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>


</body>

</html>