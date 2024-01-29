<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Tugasan Pelajar</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    </script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Loading indicator -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img src="../../assets/img/loading.png" alt="Loading..." class="spinning-image">
        </div>

        <?php
        session_start();

        if (isset($_SESSION['name']) == '') {
            header("Location: ../login.php");
        }

        include "../conn.php";


        $sql = "SELECT * FROM `student` WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['name']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user_id = $row['student_id'];
                $name = $row['name'];
            }
        }

        $query = "SELECT * FROM `leave_app` WHERE student_id = ?";
        $stmtMain = $conn->prepare($query);

        // Check if the prepare statement was successful
        if (!$stmtMain) {
            echo "Error in preparing the statement: " . $conn->error;
            exit();
        }

        $stmtMain->bind_param("s", $_SESSION['id']);
        $stmtMain->execute();
        $resultMain = $stmtMain->get_result();

        // Check if the form is submitted
        if (isset($_POST['submitUpdate'])) {
            // Retrieve form data
            $reason = $_POST['updateReason'];
            $dateLeave = $_POST['updateDate_leave'];
            $dateEnd = $_POST['updateDate_end'];
            $rowsId = $_POST['updateId'];


            $updateSql = "UPDATE `leave_app` SET
                  `reason` = ?,
                  `date_leave` = ?,
                  `date_end` = ?    
                  WHERE `id` = ? AND `student_id` = ?";

            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sssis", $reason, $dateLeave, $dateEnd, $rowsId, $_SESSION['id']);
            if ($updateStmt->execute()) {

                echo '<center><script> 
                Swal.fire({
                    title: "Berjaya",
                    text: "Permohonan cuti anda berjaya dikemaskini.",
                    icon: "success"
                }).then(function() {
                    window.location.replace("' . $_SERVER["PHP_SELF"] . '");
                }); </script></center>';
                exit();
            } else {
                echo "Error updating record: " . $updateStmt->error;
            }

            //  Close the statement
            $updateStmt->close();
        }

        //attachment pulak
        if (isset($_POST['submitAttachment'])) {
            // Retrieve form data
            $reason = $_POST['attachmentReason'];

            // File upload handling
            $targetDirectory = "../upload/";

            // Create the directory if it doesn't exist
            if (!file_exists($targetDirectory)) {
                mkdir($targetDirectory, 0777, true);
            }

            $targetFile = '';

            // Check if a file is provided
            if (!empty($_FILES["inputFile"]["name"])) {
                $targetFile = basename($_FILES["inputFile"]["name"]);

                // Check file size
                if ($_FILES["inputFile"]["size"] > 5000000) {
                    echo "<script type='text/javascript'>alert('Fail Saiz Terlalu Besar. Fail saiz perlu kurang daripada 10 MB.');</script>";
                    exit();
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["inputFile"]["tmp_name"], $targetDirectory . $targetFile)) {

                    // Update the leave_app table with the support_doc
                    $updateAttachmentSql = "UPDATE `leave_app` SET `support_doc` = ? WHERE `student_id` = ? AND `reason` = ? AND `status` = 'Baru'";
                    $updateAttachmentStmt = $conn->prepare($updateAttachmentSql);

                    // Check if the prepare statement was successful
                    if (!$updateAttachmentStmt) {
                        echo "Error in preparing the statement: " . $conn->error;
                        exit();
                    }
                    // Bind parameters and execute the update
                    $updateAttachmentStmt->bind_param("sss", $targetFile, $user_id, $reason);

                    if ($updateAttachmentStmt->execute()) {
                        echo '<center><script> 
                        Swal.fire({
                            title: "Berjaya",
                            text: "Dokumen berjaya disimpan.",
                            icon: "success"
                        }).then(function() {
                            window.location.replace("' . $_SERVER["PHP_SELF"] . '");
                        }); </script></center>';
                        exit();
                    } else {
                        echo "Error updating support document: " . $updateAttachmentStmt->error;
                    }

                    // Close the statement
                    $updateAttachmentStmt->close();
                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                    exit();
                }
            }
        }
        ?>

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
                            <h1 class="m-0">Sejarah Permohonan Cuti</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Sejarah Permohonan Cuti</li>
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
                            <h3 class="card-title">Maklumat Permohonan Cuti</h3>
                        </div>
                        <!-- ./card-header -->
                        <div class="card-body">
                            <!-- <div class="row mt-4"> -->
                            <div class="col-md-3 ml-3">
                                <!-- "Show Entries" dropdown -->
                                <label for="entriesDropdown">Papar:</label>
                                <select id="entriesDropdown">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <!-- /.card-header -->
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Bil.</th>
                                            <th>Tarikh Mula Cuti</th>
                                            <th>Tarikh Tamat Cuti</th>
                                            <th>Sebab</th>
                                            <th class='text-center'>Status</th>
                                            <th class='text-center'>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($resultMain) > 0) {
                                            $counter = 1;
                                            while ($row = mysqli_fetch_assoc($resultMain)) {
                                                // Set class and icon based on status
                                                $statusClass = '';
                                                $updateButton = '';
                                                $attachmentButton = '';  // Initialize button HTML
                                        
                                                switch ($row['status']) {
                                                    case 'Baru':
                                                        $statusClass = 'success';
                                                        $backgroundColor = 'lightskyblue';

                                                        break;
                                                    case 'Lulus':
                                                        $statusClass = 'info';
                                                        $backgroundColor = 'lightgreen';
                                                        break;
                                                    case 'Ditolak':
                                                        $statusClass = 'danger';
                                                        $backgroundColor = 'lightcoral';
                                                        break;
                                                    default:
                                                        $statusClass = 'secondary';
                                                        $backgroundColor = 'yellow';
                                                        break;
                                                }
                                                // Add the update button only if the status is not 'Lulus'
                                                if ($row['status'] !== 'Lulus') {
                                                    $updateButton = "<button type ='button' class='btn btn-primary btn-lg update-details-btn' data-placement='center' title='Kemaskini'
                                                                    data-reason='{$row['reason']}'
                                                                    data-date-leave='{$row['date_leave']}'
                                                                    data-date-end='{$row['date_end']}'
                                                                    data-id='{$row['id']}'>
                                                                    <i class='fas fa-pen'></i></button>";

                                                    $attachmentButton = "<button type='button' class='btn btn-warning btn-lg update-attachment-btn' data-toggle='modal' data-target='#modalBukti' data-placement='center' title='Bukti'
                                                                    data-reason='{$row['reason']}'
                                                                    data-date-leave='{$row['date_leave']}'
                                                                    data-date-end='{$row['date_end']}'
                                                                    data-input-file='{$row['support_doc']}'
                                                                    data-id='{$row['id']}'>
                                                                    <i class='fa fa-file-text'></i></button>";
                                                }

                                                echo "<tr>
                                                                <td>{$counter}</td>
                                                                <td>" . date('d/m/Y', strtotime($row['date_leave'])) . "</td>
                                                                <td>" . date('d/m/Y', strtotime($row['date_end'])) . "</td>
                                                                <td>{$row['reason']}</td>
                                                                <td class='{$statusClass} text-center'style='background-color: {$backgroundColor}'>{$row['status']}</td>
                                                                <td class='text-center'>
                                                                {$updateButton}
                                                                <button type='button' class='btn btn-outline-info btn-lg view-details-btn' data-toggle='modal' data-target='#modalMaklumatAduan' data-placement='top' title='Papar'
                                                                data-reason='{$row['reason']}'
                                                                data-date-leave='{$row['date_leave']}' 
                                                                data-date-end='{$row['date_end']}' 
                                                                data-input-file='{$row['support_doc']}'
                                                                data-row-id='{$row['id']}'>
                                                                <a href='#'><i class='fa fa-search'></a></i></button>

                                                                {$attachmentButton}
                                                                </td>
                                                                </tr>";
                                                $counter++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>Tiada rekod ditemui.</td></tr>";
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!--update-->
    <div class="modal fade" id="modalKemaskini" tabindex="-1" role="dialog" aria-labelledby="modalKemaskiniLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKemaskiniLabel">Kemaskini Aduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to display aduan details -->
                    <form id="aduanKemaskiniForm" method="post" action="sejarah_permohonan.php"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="reason">Sebab Cuti:</label>
                            <input type="text" class="form-control" id="updateReason" name="updateReason">
                        </div>
                        <div class="form-group">
                            <label for="date_leave">Tarikh dari:</label>
                            <input type="date" class="form-control" id="updateDate_leave" name="updateDate_leave">
                        </div>
                        <div class="form-group">
                            <label for="date_end">Tarikh hingga:</label>
                            <input type="date" class="form-control" id="updateDate_end" name="updateDate_end">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="updateId" name="updateId">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submitUpdate"
                                id="submitUpdate">Hantar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--attachment-->
    <div class="modal fade" id="modalBukti" tabindex="-1" role="dialog" aria-labelledby="modalBuktiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuktiLabel">Muatnaik Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to display aduan details -->
                    <form id="aduanBuktiForm" method="post" action="sejarah_permohonan.php"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="attachmentReason" name="attachmentReason">
                        </div>
                        <div class="form-group">
                            <label for="lampiran">Bukti(Tidak Melebihi
                                5mb):</label>
                            <div class="input-group col-sm-10">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputFile" name="inputFile"
                                        accept=".pdf, .doc, .docx, .png, .jpeg, .jpg" onchange="displayFileName()">
                                    <label class="custom-file-label" id="input" for="input" value></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="attId" name="attId">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="submitAttachment"
                                id="submitAttachment">Hantar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--view-->
    <div class="modal fade" id="modalMaklumatAduan" tabindex="-1" role="dialog"
        aria-labelledby="modalMaklumatAduanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMaklumatAduanLabel">Maklumat Aduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to display aduan details -->
                    <form id="aduanDetailsForm">
                        <div class="form-group">
                            <label for="reason">Sebab:</label>
                            <input type="text" class="form-control" id="viewReason" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date_leave">Tarikh dari:</label>
                            <input type="date" class="form-control" id="viewDate_leave" name="date_leave" readonly>
                        </div>
                        <div class="form-group">
                            <label for="date_end">Tarikh hingga:</label>
                            <input type="date" class="form-control" id="viewDate_end" name="date_end" readonly>
                        </div>
                        <div class="form-group">
                            <label for="file">Bukti:</label>
                            <input type="text" class="form-control" id="viewInputFile" name="viewInputFile" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("includes/footer.php");
    ?>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>

    <script>
        //Disply the selected File
        function displayFileName() {
            // Get the selected file input
            var inputFile = document.getElementById('inputFile');
            // Get the file name and display it in the custom-file-label
            var fileName = inputFile.files[0].name;
            var fileLabel = document.querySelector('.custom-file-label');
            fileLabel.innerHTML = fileName;
        }

        $(document).ready(function () {
            var table = $('#example1').DataTable({
                "responsive": true,
                "paging": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                "info": true,
                "buttons": ["pdf"],
                "pageLength": 5,
                "searching": false // Disable searching
            });

            $('#entriesDropdown').on('change', function () {
                var entries = $(this).val();
                table.page.len(entries).draw();
            });

            // Open the modal for viewing details
            $('#example1 tbody').on('click', '.view-details-btn', function () {
                // Get the data attributes from the clicked button
                var reason = $(this).data('reason');
                var dateLeave = $(this).data('date-leave');
                var dateEnd = $(this).data('date-end');
                var inputFile = $(this).data('input-file');

                // Set the form values based on the data attributes
                $('#viewReason').val(reason);
                $('#viewDate_leave').val(dateLeave);
                $('#viewDate_end').val(dateEnd);
                $('#viewInputFile').val(inputFile);

                // Show the modal
                $('#modalMaklumatAduan').modal('show');
            });

            // Open the modal for updating details
            $('#example1 tbody').on('click', '.update-details-btn', function () {

                // Get the data attributes from the clicked button
                var reason = $(this).data('reason');
                var dateLeave = $(this).data('date-leave');
                var dateEnd = $(this).data('date-end');
                var rowId = $(this).data('id');

                console.log("Reason: ", reason);
                console.log("Date Leave: ", dateLeave);
                console.log("Date End: ", dateEnd);
                console.log("Id: ", rowId);

                Swal.fire({
                    title: 'Anda pasti untuk kemaskini?',
                    text: 'Kemaskini akan disimpan!',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kemaskini!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set the form values based on the data attributes
                        $('#updateReason').val(reason);
                        $('#updateDate_leave').val(dateLeave);
                        $('#updateDate_end').val(dateEnd);
                        $('#updateId').val(rowId);

                        // Show the modal
                        $('#modalKemaskini').modal('show');
                    }
                });

            });

            $('#aduanKemaskiniForm').submit(function (e) {
                
                var form = $('#aduanKemaskiniForm')[0];
                var reason = document.getElementById('updateReason').value.trim();;
                var dateLeave = document.getElementById('updateDate_leave').value.trim();;
                var dateEnd = document.getElementById('updateDate_end').value.trim();;
                var rowId = document.getElementById('updateId').value.trim();

                // Check if any of the fields are empty
                if (reason === '' || dateLeave === '' || dateEnd === '' || rowId === '') {
                    // Show error message using SweetAlert
                    Swal.fire({
                        icon: "error",
                        title: "Borang Tidak Lengkap",
                        text: "Sila Lengkapkan Borang permohonan Cuti",
                    });
                    return false;
                } else {
                    return true;
                }
            });

            // Open the modal for attachment details
            $('#example1 tbody').on('click', '.update-attachment-btn', function () {
                // Get the data attributes from the clicked button
                var reason = $(this).data('reason');
                var inputFile = $(this).data('input-file')
                var aId = $(this).data('id')

                console.log("Reason: ", reason);
                console.log("Input File: ", inputFile);
                console.log("Id: ", aId);

                // Set the form values based on the data attributes
                $('#attachmentReason').val(reason);
                $('#inputFile').val(inputFile);
                $('#attId').val(aId);

                // Show the modal
                $('#modalBukti').modal('show');
            });

            $('#aduanBuktiForm').submit(function (e) {
                var inputFile = document.getElementById('inputFile');

                if (inputFile.files.length > 0 && inputFile.files[0].size > 5 * 1024 * 1024) {
                    Toast.fire({
                        icon: "error",
                        title: "Fail Saiz Terlalu Besar",
                        text: "Fail saiz perlu kurang daripada 5 MB.",
                    });
                    return false;
                }
                return true;
            });

        });
    </script>
</body>

</html>