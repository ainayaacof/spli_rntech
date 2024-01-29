<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Senarai Pelajar</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../dist/js/demo.js"></script>

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

       
        include "../conn.php";

        // $sql = "SELECT * FROM `student` WHERE name = ?";
        // $stmt = $conn->prepare($sql);
        // $stmt->bind_param("s", $_SESSION['name']);
        // $stmt->execute();
        // $result = $stmt->get_result();

        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         $user_id = $row['student_id'];
        //         $name = $row['name'];
        //     }
        // }

        // if ($_SERVER["REQUEST_METHOD"] == "POST") {

        
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
                            <h1 class="m-0">Permohonan Cuti</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Permohonan Cuti</li>
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
                            <!-- Horizontal Form -->
                            <div class="card card-navy">
                                <div class="card-header">
                                    <h3 class="card-title">Borang Permohonan Cuti</h3>
                                </div>
                                <!-- /.card-header -->
                                <form id="cuti" action="permohonan_cutiDB.php"
                                    method="POST" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="title" class="col-sm-2 col-form-label">Sebab Cuti<span
                                                    style="color: red;">
                                                    *</span></label></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="reason" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dateleave" class="col-sm-2 col-form-label">Tarikh Dari<span
                                                    style="color: red;">
                                                    *</span></label></label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" name="date_leave"
                                                    placeholder="dd/mm/yy">
                                            </div>
                                            <label for="dateend" class="col-sm-2 col-form-label">Tarikh hingga<span
                                                    style="color: red;">
                                                    *</span></label></label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" name="date_end"
                                                    placeholder="dd/mm/yy">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lampiran"
                                                class="col-sm-2 col-form-label">Bukti(Disarankan)</label>
                                            <div class="input-group col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputFile"
                                                        name="inputFile" accept=".pdf, .doc, .docx, .png, .jpeg, .jpg"
                                                        onchange="displayFileName()">
                                                    <label class="custom-file-label" for="inputFile">Tidak Melebihi
                                                        5mb</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="text-align: right; margin-right: 0px;">
                                            <button type="submit" class="btn btn-primary" name="hntar"
                                                id="submitPermohonan">Hantar</button>
                                        </div>
                                    </div>

                                </form>
                                <!-- /.form -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.card-body -->
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

    <!-- Page specific script -->
    <script>
        //Display the selected File
        function displayFileName() {
            // Get the selected file input
            var inputFile = document.getElementById('inputFile');
            // Get the file name and display it in the custom-file-label
            var fileName = inputFile.files[0].name;
            var fileLabel = document.querySelector('.custom-file-label');
            fileLabel.innerHTML = fileName;
        }

        function validateForm() {
            var reason = document.getElementsByName("reason")[0].value;
            var dateLeave = document.getElementsByName("date_leave")[0].value;
            var dateEnd = document.getElementsByName("date_end")[0].value;
            var inputFile = document.getElementById('inputFile');

            // Check if the file size is below 5 MB
            if (inputFile.files.length > 0 && inputFile.files[0].size > 5 * 1024 * 1024) {
                Toast.fire({
                    icon: "error",
                    title: "Fail Saiz Terlalu Besar",
                    text: "Fail saiz perlu kurang daripada 5 MB.",
                });
                return false;
            }

            // Check if other fields are empty
            if (reason === "" || dateLeave === "" || dateEnd === "") {
                Swal.fire({
                    icon: "error",
                    title: "Borang Tidak Lengkap",
                    text: "Sila Lengkapkan Borang permohonan Cuti",
                });
                return false;
            }
            // Check if the file input is empty
             if (inputFile.value === "") {
                 var isConfirmed = confirm("Anda tidak lampirkan bukti yang dapat mengukuhkan permohonan cuti. Anda pasti?");
                 return isConfirmed;
             }
        };
    </script>
    	<script>
		$(document).ready(function () {
            var isConfirmed = false;
			// Attach the form submission handling to the "Save" button click event
			$('#submitPermohonan').on('click', function (e) {
                
				e.preventDefault();
				var form = $('#cuti'); // Get the form element
				
					// Proceed with the SweetAlert confirmation
					Swal.fire({
						title: 'Anda pasti mahu simpan?',
						text: 'Perubahan akan disimpan!',
						icon: 'question',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ya, simpan!',
						cancelButtonText: 'Batal'
					}).then((result) => {
						// Check if the user clicked "Ya, simpan!"
						if (result.value) {
                            isConfirmed = result.value;
							form.submit(); // Submit the form
						}
					});
				

			});
		});
		</script>
</body>

</html>