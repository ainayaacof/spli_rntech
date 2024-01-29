<?php
// Start or resume the session
session_start();

include "../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RNTECH | Task</title>

	<!-- SWEEY ALERT -->
	<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<script src="../../plugins/jquery/jquery.min.js"></script>
	<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../dist/js/adminlte.min.js"></script>
	<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="../../dist/js/demo.js"></script>

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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

</head>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Loading indicator -->
		<!-- <div class="preloader flex-column justify-content-center align-items-center">
			<img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
		</div> -->
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
							<h1 class="m-0">Maklumbalas</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Tugasan Harian</li>
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
							<h3 class="card-title">Maklumat Aktiviti Tugasan</h3>
						</div>
						<?php
						
						$student_id = $_REQUEST['student_id'];
						if (isset($student_id)) {
							$id = $_REQUEST['unique_id'];
							$query = "SELECT * FROM task_activity WHERE student_id = '" . $student_id . "' AND id = '" . $id . "'";
							$result = mysqli_query($conn, $query);
							$num_rows = mysqli_num_rows($result);
							while ($row = mysqli_fetch_array($result)) {
						?>
								<div class="card-body">
									<form id = "formupdate" method='post' action='updateTask_svDB.php?unique_id=<?php echo $id; ?>&student_id=<?php echo $student_id ?>' enctype="multipart/form-data">
										<div class="form-group">
											<div class="mb-3">
												<label for="week">Minggu</label>
												<input type="text" class="form-control" name="unique_week" value="<?php echo $row["week"]; ?>" readonly>
											</div>

											<div class="mb-3">
												<label for="description">Keterangan</label>
												<textarea class="form-control" name="description" readonly style="height: 150px;"><?php echo $row["task_description"]; ?></textarea>
											</div>

											<div class="mb-3">
												<label for="date">Tarikh</label>
												<input type="text" class="form-control" name="date" value="<?php echo date("d/m/Y", strtotime($row["task_date"])) ?>" readonly>
											</div>

											<div class="mb-3">
												<label for="time">Jumlah Masa</label>
												<input type="text" class="form-control" name="time" value="<?php echo $row["total_time"]; ?>" readonly>
											</div>

											<div class="mb-3">
												<label for="comment">Maklumbalas</label><label style="color:red">*</label>
												<input type="text" class="form-control" id="id" name="commentTask" value="<?php echo $row['comment']; ?>" required>
											</div>
											<div cclass="mb-3" id = "levelTask">
												<label >Peringkat</label><label style="color:red">*</label>
												<p class="padding-left:95px;">
													<input type="radio" name="levelTask" id="options" class="options" value="Sangat Tidak Memuaskan" required><label >&emsp;Sangat Tidak Memuaskan&emsp;&emsp; </label>
													<input type="radio" name="levelTask" id="options" class="options" value="Tidak Memuaskan" required><label>&emsp;Tidak Memuaskan&emsp;&emsp;</label>
													<input type="radio" name="levelTask" id="options" class="options" value="Memuaskan" required><label>&emsp;Memuaskan&emsp;&emsp;</label>
													<input type="radio" name="levelTask" id="options" class="options" value="Sangat Memuaskan" required><label>&emsp;Sangat Memuaskan&emsp;&emsp;</label>
												</p>
											</div>
											<div  class="d-flex justify-content-end">
											<button type="submit" id="btnUpdate" class="btn btn-primary" style="margin:5px;">Simpan</button>
											<button class="btn btn-secondary" style="margin:5px;"><a href="studentActivityView_sv.php?student_id=<?php echo $student_id ?>&unique_week=<?php echo $row['week']; ?>" style="color:white">Kembali</a></button>
											
											</div>
										</div>
									</form>
								</div>
						<?php
							}
						}
						?>
					</div><!-- /.card -->
				</div><!-- /.container-fluid -->
			</section><!-- Section -->


			<br><br>
		</div>
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<?php
		include("includes/footer.php");
		?>


	</div>
<!-- Add this script in the head section or include it in a separate external script file -->
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include SweetAlert 2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<!-- ... your existing HTML code ... -->

<script>
$(document).ready(function () {
    // Attach the form submission handling to the "Save" button click event
    $('#btnUpdate').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form'); // Get the form element

        // Check for required fields
        var requiredFields = form.find('[required]');
        var isValid = true;
		var isValidRadio = false;

        // Remove any existing error messages "Sila isi ruangan ini"
        form.find('.error-message').remove();

        var errorMessages = {
            'commentTask': 'Maklumbalas is required',
            'levelTask': 'Peringkat is required'
            // Add more fields as needed
        };

        requiredFields.each(function () {
            var fieldName = $(this).attr('name');
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).after('<span class="error-message" style="color:red">Sila isi di ruangan kosong*</span>');
            }
        });

        // if($('input[type=radio][name=levelTask]:checked').length == 0)
		// {
		// 	$(this).after('<span class="error-message" style="color:red">ssss*</span>');
		// 	return false;
		// }


        $('.options').each(function() {
			if ($(this).prop("checked")) {
				isValidRadio = true;
				
			}
		});

		// Check if no radio button is checked
        if (!isValidRadio) {
            // Display error message for radio button
            $('#levelTask').after('<span class="error-message" style="color:red">Sila pilih salah satu*</span>');
        }


        if (!isValid || !isValidRadio) {
            return;
        } else {
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
                    $('#formupdate').submit(); // Submit the form
                }
            });
        }
    });
});


</script>



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