<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RNTECH | Aduan Maklum Balas</title>

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
							<h1 class="m-0">Aduan Maklum Balas</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Aduan Maklum Balas</li>
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
											<a class="nav-link active" id="aktif-tab" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="true">Aduan Baru</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="terdahulu-tab" data-toggle="pill" href="#terdahulu" role="tab" aria-controls="terdahulu" aria-selected="false">Senarai Terdahulu</a>
										</li>
									</ul>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-two-tabContent">
										<div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="aktif-tab">
											<?php
											// Query for Aduan Baru
											$queryAktif = "SELECT * FROM `feedback` WHERE `status`='Baru'";
											$resultAktif = mysqli_query($conn, $queryAktif);
											?>
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<!-- Table header for Aduan Baru -->
														<th width="5%">Bil</th>
														<th width="30%">Pengadu</th>
														<th width="20%">Berkenaan</th>
														<th>Aduan</th>
														<th>Tarikh</th>
														<th width="14%" style="text-align: center;">Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$counter = 1; // Initialize counter for row numbers
													if (mysqli_num_rows($resultAktif) > 0) {
														while ($myrowAktif = mysqli_fetch_array($resultAktif)) {
													?>
															<tr>
																<th><?php echo $counter; ?></th>
																<?php
																$pekerja_id = $myrowAktif['pekerja_id'];

																// Check if the pekerja_id matches with student_id in the student table
																$student_query = "SELECT name FROM student WHERE student_id = '$pekerja_id'";
																$student_result = mysqli_query($conn, $student_query);

																// Check if the pekerja_id matches with sv_id in the supervisor table if not found in student table
																if (mysqli_num_rows($student_result) > 0) {
																	$row = mysqli_fetch_assoc($student_result);
																	$name = $row['name'];
																} else {
																	$supervisor_query = "SELECT name FROM supervisor WHERE sv_id = '$pekerja_id'";
																	$supervisor_result = mysqli_query($conn, $supervisor_query);

																	if (mysqli_num_rows($supervisor_result) > 0) {
																		$row = mysqli_fetch_assoc($supervisor_result);
																		$name = $row['name'];
																	} else {
																		$name = "Unknown"; // If no match found in both tables
																	}
																}
																?>
																<td><?php echo $name; ?></td>
																<td><?php echo $myrowAktif['person_name']; ?></td>
																<td><?php echo $myrowAktif['description']; ?></td>
																<td><?php echo date('d/m/Y', strtotime($myrowAktif['date'])); ?></td>
																<td>
																	<center>
																		<a href="#" class="btn btn-outline-primary btn-sm view-complaint" data-id="<?php echo $myrowAktif['id']; ?>" data-toggle="tooltip" data-placement="top" title="Sembunyi Aduan"><i class="far fa-eye-slash"></i></a>
																		<button class="btn btn-outline-primary btn-sm view-button" data-toggle="modal" data-target="#modalMaklumatAduan"><i class="fas fa-list"></i></button>
																	</center>
																</td>
															</tr>
														<?php
															$counter++; // Increment the counter for the next row
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
										<div class="tab-pane fade" id="terdahulu" role="tabpanel" aria-labelledby="terdahulu-tab">
											<?php
											// Query for Senarai Terdahulu
											$queryTerdahulu = "SELECT * FROM `feedback` WHERE `status`='Lihat'";
											$resultTerdahulu = mysqli_query($conn, $queryTerdahulu);
											?>
											<table id="example2" class="table table-bordered table-striped">
												<thead>
													<tr>
														<!-- Table header for Senarai Terdahulu -->
														<th>Bil</th>
														<th width="30%">Pengadu</th>
														<th>Berkenaan</th>
														<th>Aduan</th>
														<th>Tarikh</th>
														<th width="10%" style="text-align: center;">Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$counter = 1; // Initialize counter for row numbers
													if (mysqli_num_rows($resultTerdahulu) > 0) {
														while ($myrowAktif = mysqli_fetch_array($resultTerdahulu)) {
													?>
															<tr>
																<th><?php echo $counter; ?></th>
																<?php
																$pekerja_id = $myrowAktif['pekerja_id'];

																// Check if the pekerja_id matches with student_id in the student table
																$student_query = "SELECT name FROM student WHERE student_id = '$pekerja_id'";
																$student_result = mysqli_query($conn, $student_query);

																// Check if the pekerja_id matches with sv_id in the supervisor table if not found in student table
																if (mysqli_num_rows($student_result) > 0) {
																	$row = mysqli_fetch_assoc($student_result);
																	$name = $row['name'];
																} else {
																	$supervisor_query = "SELECT name FROM supervisor WHERE sv_id = '$pekerja_id'";
																	$supervisor_result = mysqli_query($conn, $supervisor_query);

																	if (mysqli_num_rows($supervisor_result) > 0) {
																		$row = mysqli_fetch_assoc($supervisor_result);
																		$name = $row['name'];
																	} else {
																		$name = "Unknown"; // If no match found in both tables
																	}
																}
																?>
																<td><?php echo $name; ?></td>
																<td><?php echo $myrowAktif['person_name']; ?></td>
																<td><?php echo $myrowAktif['description']; ?></td>
																<td><?php echo date('d/m/Y', strtotime($myrowAktif['date'])); ?></td>
																<td>
																	<center>
																		<button class="btn btn-outline-primary btn-sm view-button" data-toggle="modal" data-target="#modalMaklumatAduan">
																			<i class="fas fa-list"></i>
																		</button>
																		<a href="#" class="btn btn-outline-primary btn-sm delete-complaint" data-id="<?php echo $myrowAktif['id']; ?>" style="margin:5px;" data-toggle="tooltip" data-placement="top" title="Padam"><i class="fa">&#xf1f8;</i></a>
																	</center>
																</td>
															</tr>
														<?php
															$counter++; // Increment the counter for the next row
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

		<div class="modal fade" id="modalMaklumatAduan" tabindex="-1" role="dialog" aria-labelledby="modalMaklumatAduanLabel" aria-hidden="true">
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
								<label for="pengadu">Pengadu:</label>
								<input type="text" class="form-control" id="pengadu" readonly>
							</div>
							<div class="form-group">
								<label for="berkenaan">Berkenaan:</label>
								<input type="text" class="form-control" id="berkenaan" readonly>
							</div>
							<div class="form-group">
								<label for="aduan">Aduan:</label>
								<textarea class="form-control" id="aduan" rows="3" readonly></textarea>
							</div>
							<div class="form-group">
								<label for="tarikh">Tarikh Aduan:</label>
								<input type="text" class="form-control" id="tarikh" readonly>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
	<script src="../../../.plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="../../../plugins/jszip/jszip.min.js"></script>
	<script src="../../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="../../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script src="../../../dist/js/adminlte.min.js"></script>
	<!-- Page specific script -->
	<script>
		$(function() {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["excel", "pdf"]
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
	</script>

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
		// JavaScript to handle modal content update
		$(document).ready(function() {
			$('.view-button').click(function() {
				// Fetch the aduan details from the appropriate row
				var pengadu = $(this).closest('tr').find('td:nth-child(2)').text();
				var berkenaan = $(this).closest('tr').find('td:nth-child(3)').text();
				var aduan = $(this).closest('tr').find('td:nth-child(4)').text();
				var tarikh = $(this).closest('tr').find('td:nth-child(5)').text();

				// Set the fetched details into the modal form fields
				$('#pengadu').val(pengadu);
				$('#berkenaan').val(berkenaan);
				$('#aduan').val(aduan);
				$('#tarikh').val(tarikh);

				// Show the modal
				$('#modalMaklumatAduan').modal('show');
			});
		});
	</script>

	<script>
		// Add an event listener to the class of the view complaint button
		document.querySelectorAll('.view-complaint').forEach(item => {
			item.addEventListener('click', event => {
				event.preventDefault(); // Prevent the default action of the link

				const complaintId = event.currentTarget.dataset.id; // Get the complaint ID

				// Show a confirmation Swal before viewing the complaint
				Swal.fire({
					title: 'Lihat aduan?',
					text: 'Aduan ini akan ditandakan sebagai sudah dilihat.',
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, lihat!',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						// Redirect to lihat_aduan.php with the complaint ID as a query parameter
						window.location.href = `lihat_aduan.php?id=${complaintId}&notify=1`;
					}
				});
			});
		});
	</script>

	<script>
		// Add an event listener to the class of the delete complaint button
		document.querySelectorAll('.delete-complaint').forEach(item => {
			item.addEventListener('click', event => {
				event.preventDefault(); // Prevent the default action of the link

				const complaintId = event.currentTarget.dataset.id; // Get the complaint ID

				// Show a confirmation Swal before deleting the complaint
				Swal.fire({
					title: 'Padam aduan?',
					text: 'Aduan ini akan dipadamkan secara kekal.',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'Ya, padam!',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						// Redirect to padam_aduan.php with the complaint ID as a query parameter
						window.location.href = `padam_aduan.php?id=${complaintId}&notify=1`;
					}
				});
			});
		});
	</script>

</body>

</html>