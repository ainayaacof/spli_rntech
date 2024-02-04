<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Senarai Pelajar</title>

    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

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
                $_SESSION['st_id'] = $row['student_id']; // Set the session variable
                $user_id = $row['student_id'];
                $name = $row['name'];
            }
        }
        $_POST['st_id'] = $_SESSION['st_id'];
        $st_id = $_POST['st_id'];

        // Fetch student names from the database
        $queryStudents = "SELECT student.id AS studID, student.name AS studName 
        FROM student 
        WHERE student.status ='Aktif' AND student.student_id != ?";
        $stmtStudents = $conn->prepare($queryStudents);
        $stmtStudents->bind_param("s", $user_id);
        $stmtStudents->execute();
        $resultStudents = $stmtStudents->get_result();

        // Check if there are rows returned
        if ($resultStudents->num_rows > 0) {
            // Store student names in an array
            $students = array();
            while ($row = $resultStudents->fetch_assoc()) {
                $students[] = $row["studName"];
            }
        } else {
            // Handle the case when no students are found
            echo "No active students found in the database.";
        }

        // Fetch supervisor names from the database
        $querySupervisor = "SELECT name FROM supervisor";
        $resultSupervisor = $conn->query($querySupervisor);

        // Check if there are rows returned for supervisors
        if ($resultSupervisor->num_rows > 0) {
            // Store supervisor names in an array
            $supervisors = array();
            while ($row = $resultSupervisor->fetch_assoc()) {
                $supervisors[] = $row["name"];
            }
        } else {
            // Handle the case when no supervisors are found
            echo "No supervisors found in the database.";
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
                            <h1 class="m-0">Aduan Pelajar</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Aduan Pelajar</li>
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
                                <!-- Horizontal Form -->

                                <div class="card-header">
                                    <h3 class="card-title">Borang Aduan</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <form id="formAduan" method='post' action='addFeedback_stDB.php' enctype="multipart/form-data">
                                            <div class="form-group">
                                                <p>
                                                    <label for="name">Pengadu</label>
                                                    <input class="form-control" name="pengadu" id="pengadu"
                                                        value="<?php echo $name; ?>" readonly>
                                                </p>
                                                <p>
                                                    <label for="date">Nama Pelajar Atau Penyelia<span
                                                            style="color: red;"> *</span></label>
                                                    <select name="name" id="AduName" class="form-control">
                                                        <option value=""> -- Pilih Nama -- </option>
                                                        <?php
                                                        // Display active students
                                                        foreach ($students as $student) {
                                                            echo "<option value=\"$student\"> $student</option>";
                                                        }

                                                        // Display supervisors
                                                        foreach ($supervisors as $supervisor) {
                                                            echo "<option value=\"$supervisor\"> $supervisor</option>";
                                                        }
                                                        ?>
                                                    </select>

                                                </p>
                                                <p>
                                                    <?php
                                                    date_default_timezone_set('Asia/Kuala_Lumpur');
                                                    $Date = gmdate('Y-m-d');
                                                    $currenttime = date('h:i A');
                                                    ?>
                                                    <label for="aduan">Aduan<span style="color: red;"> *</span></label>
                                                    <input class="form-control" name="aduan" id="aduanDibuat"
                                                        placeholder="Aduan yang ingin dikenakan">
                                                </p>
                                                <p>
                                                    <label for="date">Tarikh Aduan</label>
                                                    <input type="form-control" class="form-control" value="<?php echo date('d/m/Y', strtotime($Date)); ?>" readonly>
                                                        <input type="hidden" name="date" id="date" value="<?php echo $Date; ?>">
                                                </p>
                                                <p>
                                                    <label for="masa">Masa Aduan</label>
                                                    <input type="form-control" class="form-control" name="time"
                                                        id="time" value="<?php echo $currenttime; ?>"
                                                        placeholder="<?php echo $currenttime; ?>" readonly>
                                                </p>
                                                <p>
                                                    <label for="type">Jenis Aduan<span style="color: red;">
                                                            *</span></label>
                                                    <select name="type" id="jenisAduan" class="form-control">
                                                        <option value=""> -- Pilih Jenis Aduan -- </option>
                                                        <option value="Maklum Balas"> Maklum Balas </option>
                                                        <option value="Aduan"> Aduan </option>
                                                    </select>
                                                </p>
                                                <div style="text-align: right; margin-right: 0px;">
                                                    <!-- <input type='submit' id='htrAduanST' value='Hantar' class='btn btn-primary'> -->
                                                    <button type='submit' id='htrAduanST' class='btn btn-primary' style="margin-right:5px;">Simpan</button>
                                                    <button type="button" id="btnClear" class="btn btn-secondary">Set Semula</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- END OF FORM -->
                                </div>
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


    <!-- <script>
        function validateForm() {
            console.log("validateForm called");
            var name = document.getElementsByName("name")[0].value;
            console.log("Name:", name);
            var aduan = document.getElementsByName("aduan")[0].value;
            var type = document.getElementsByName("type")[0].value;

            // Check if other fields are empty
            if (name === "" || aduan === "" || type === "") {
                Swal.fire({
                    icon: "error",
                    title: "Borang Tidak Lengkap",
                    text: "Sila Lengkapkan Borang Aduan",
                });
                return false;
            } else {
                return true;
            }
        }
    </script> -->

    <script>
		$(document).ready(function () {
            // Function to clear form fields
            function clearForm() {
                $('#formAduan')[0].reset();
            }

            // Attach the clearForm function to the "Clear Form" button click event
            $('#btnClear').on('click', function () {
                var form = $(this).parents('form'); // Get the form element

                // Check for required fields
                var requiredFields = form.find('[required]');
                var isValid = true;

                // Remove any existing error messages "Sila isi ruangan ini"
                form.find('.error-message').remove();
                clearForm();
            });

			// Attach the form submission handling to the "Save" button click event
			$('#htrAduanST').on('click', function (e) {
				e.preventDefault();
				var form = $('#formAduan'); // Get the form element

				// Check for required fields
				var requiredFields = form.find('[required]');
				var isValid = true;

				// Remove any existing error messages
				form.find('.error-message').remove();

				// print message on id studentName if the field is empty
                if ($('#AduName').val().trim() === '') {
                    isValid = false;
                    $('#AduName').after('<span class="error-message" style="color:red">Sila pilih pelajar*</span>');
                }

				if ($('#aduanDibuat').val().trim() === '') {
					isValid = false;
					$('#aduanDibuat').after('<span class="error-message" style="color:red">Sila isi aduan yang ingin dikenakan*</span>');
				}

				if ($('#jenisAduan').val().trim() === '') {
					isValid = false;
					$('#jenisAduan').after('<span class="error-message" style="color:red">Sila pilih jenis aduan*</span>');
				}

				if (!isValid) {
					return;
				}
				
				else {
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
						if (result.isConfirmed) {
							form.submit(); // Submit the form
						}
					});
				}

			});
		});
</script>

</body>

</html>