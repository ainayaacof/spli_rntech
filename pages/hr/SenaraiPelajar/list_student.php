<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Senarai Pelajar</title>

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
							<h1 class="m-0">Senarai Pelajar</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard/dashboard_hr.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Senarai Pelajar</li>
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
											<a class="nav-link active" id="aktif-tab" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="true">Aktif</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="tidak-aktif-tab" data-toggle="pill" href="#tidak-aktif" role="tab" aria-controls="tidak-aktif" aria-selected="false">Senarai Terdahulu</a>
										</li>
									</ul>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-two-tabContent">
										<div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
											<?php
											// $queryAktif = "SELECT * FROM `student` WHERE `status`='Aktif'";
											$queryAktif = "SELECT student.*, supervisor.name AS supervisor_name
										FROM student
										LEFT JOIN supervisor ON student.sv_id = supervisor.sv_id
										WHERE student.status = 'Aktif'";

											$resultAktif = mysqli_query($conn, $queryAktif);
											?>
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>Bil</th>
														<th>ID</th>
														<th>Nama</th>
														<th>No. Telefon</th>
														<th>E-mel</th>
														<th>Penyelia Industri</th>
														<th width="11%" style="text-align: center;"> Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$bil = 1; // Initialize the counter
													if (mysqli_num_rows($resultAktif) > 0) {
														while ($myrowAktif = mysqli_fetch_array($resultAktif)) {
													?>
															<tr>
																<td><?php echo $bil; ?></td>
																<td><?php echo $myrowAktif['student_id']; ?></td>
																<td><?php echo $myrowAktif['name']; ?></td>
																<td><?php echo $myrowAktif['phone_num']; ?></td>
																<td><?php echo $myrowAktif['email']; ?></td>
																<td><?php echo empty($myrowAktif['supervisor_name']) ? 'Tiada Penyelia Industri' : $myrowAktif['supervisor_name']; ?></td>
																<td style="text-align: center;">
																	<a href="viewlist_studentactive.php?id=<?php echo $myrowAktif['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat"><i class="fas fa-search"></i></a>
																	<a href="nonactive_student.php?student_id=<?php echo $myrowAktif['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Tidak Aktif" id="btnnonactive"><i class="fas fa-times"></i></a>
																	<a href="padam_student.php?student_id=<?php echo $myrowAktif['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Padam" id="btnpadam"><i class="fas fa-trash-alt"></i></a>
																</td>


															</tr>
														<?php
															$bil++; // Increment the counter for the next row
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
											</table>

										</div>
										<div class="tab-pane fade" id="tidak-aktif" role="tabpanel" aria-labelledby="tidak-aktif-tab">
											<?php
											// $queryTidakAktif = "SELECT * FROM `student` WHERE `status`='Tidak Aktif'";
											$queryTidakAktif = "SELECT student.*, supervisor.name AS supervisor_name
												FROM student
												LEFT JOIN supervisor ON student.sv_id = supervisor.sv_id
												WHERE student.status = 'Tidak Aktif'";

											$resultTidakAktif = mysqli_query($conn, $queryTidakAktif);
											?>
											<table id="example2" class="table table-bordered table-striped">
												<thead>
													<tr>
													<th>Bil</th>
														<th>ID</th>
														<th>Nama</th>
														<th>No. Telefon</th>
														<th>E-mel</th>
														<th>Penyelia Industri</th>
														<th width="11%" style="text-align: center;"> Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$bil = 1; // Initialize the counter
													if (mysqli_num_rows($resultTidakAktif) > 0) {
														while ($myrowTidakAktif = mysqli_fetch_array($resultTidakAktif)) {
													?>
															<tr>
																<td><?php echo $bil; ?></td>
																<td><?php echo $myrowTidakAktif['student_id']; ?></td>
																<td><?php echo $myrowTidakAktif['name']; ?></td>
																<td><?php echo $myrowTidakAktif['phone_num']; ?></td>
																<td><?php echo $myrowTidakAktif['email']; ?></td>
																<td><?php echo empty($myrowTidakAktif['supervisor_name']) ? 'Tiada Penyelia Industri' : $myrowTidakAktif['supervisor_name']; ?></td>

																<td style="text-align: center;">
																	<a href="viewlist_studentnonactive.php?id=<?php echo $myrowTidakAktif['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Lihat"><i class="fas fa-search"></i></a>
																	<a href="active_student.php?student_id=<?php echo $myrowTidakAktif['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Aktif" id="btnaktif"><i class="fas fa-check"></i></a>
																    <a href="padam_student.php?student_id=<?php echo $myrowTidakAktif['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Padam" id="btnpadamtidakaktif"><i class="fas fa-trash-alt"></i></a>

																</td>

															</tr>
														<?php
															$bil++; // Increment the counter for the next row
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
	<script src="../SenaraiPelajar/pelajar.js"></script>



<script>

// Function to handle deletion
$('#btnpadam').click(function(e) {
	e.preventDefault();
	var padamURL = $(this).attr('href');

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
				url: padamURL, // Replace this URL with your delete endpoint
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
</script>

<script>
$('#btnpadamtidakaktif').click(function(e) {
	e.preventDefault();
	var padamtidakaktifURL = $(this).attr('href');

	Swal.fire({
		title: 'Adakah anda ingin teruskan?',
		text: 'Maklumat ini akan dinyahaktifkan!',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, dinyahaktif!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: 'GET',
				url: padamtidakaktifURL, // Replace this URL with your delete endpoint
				success: function(response) {
					Swal.fire({
						title: 'Berjaya dinyahaktifkan!',
						text: 'Maklumat telah berjaya dinyahaktifkan.',
						icon: 'success'
					}).then(() => {
						location.reload(); // Refresh the page after successful deletion
					});
				},
				error: function() {
					Swal.fire({
						title: 'Ralat!',
						text: 'Gagal hapus maklumat.',
						icon: 'error'
					});
				}
			});
		}
	});
});
</script>

<script>
$('#btnaktif').click(function(e) {
	e.preventDefault();
	var aktiffURL = $(this).attr('href');

	Swal.fire({
		title: 'Adakah anda pasti?',
		text: 'Data akan diaktifkan!',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Aktifkan!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: 'GET',
				url: aktiffURL, // Replace this URL with your delete endpoint
				success: function(response) {
					Swal.fire({
						title: 'Berjaya diaktifkan!',
						text: 'Maklumat telah berjaya diaktifkan.',
						icon: 'success'
					}).then(() => {
						location.reload(); // Refresh the page after successful deletion
					});
				},
				error: function() {
					Swal.fire({
						title: 'Ralat!',
						text: 'Gagal  aktifkan maklumat.',
						icon: 'error'
					});
				}
			});
		}
	});
});
</script>

</body>

</html>