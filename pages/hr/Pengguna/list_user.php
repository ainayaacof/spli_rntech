<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Senarai Pengguna</title>

	<?php include "../includes/styles.php"; ?>

	

</head>
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
							<h1 class="m-0">Senarai Pengguna</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Senarai Pengguna Sistem</li>
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
							<div class="card card-navy">
								<div class="card-header">
									<h3 class="card-title">Senarai Pengguna Sistem</h3>
									<a href="add_user.php" class="btn btn-navy btn-sm float-right">
										<i class="fas fa-plus" style="margin-right: 5px;"></i>Rekod Baru
									</a>

								</div>
								<!-- /.card-header -->
								<div class="card-body">

									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Bil</th>
												<th>Nama Pengguna</th>
												<th>Emel</th>
												<th>Kategori</th>
												<th>Status</th>
												<th width="12%">Tindakan</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$bil = 1;

											// Query for active students
											$query_student = "SELECT * FROM `student` WHERE status IN ('Aktif', 'Tidak Aktif')";
											$result_student = mysqli_query($conn, $query_student);
											while ($student_row = mysqli_fetch_array($result_student)) {
												$status = $student_row['status'];
												$status_color = ($status === 'Aktif') ? 'lightgreen' : 'lightcoral';
											?>
												<tr>
													<td><?php echo $bil++; ?></td>
													<td><?php echo $student_row['name']; ?></td>
													<td><?php echo $student_row['email']; ?></td>
													<td>Pelajar</td>
													<td style="background-color: <?php echo $status_color; ?>"><?php echo $status; ?></td>
													<td>
														<center>
															<a href="#changePasswordModal" class="btn btn-outline-primary btn-sm change-password" data-toggle="modal" data-user-id="<?php echo $student_row['id']; ?>" data-user-type="student" data-toggle="tooltip" data-placement="top" title="Tukar Kata Laluan">
																<i class="fas fa-user-lock"></i>
															</a>
															<a href="padamUser.php?id=<?php echo $student_row['id']; ?>&notify=1&category=student" class="btn btn-outline-primary btn-sm  btnpadamsv" data-toggle="tooltip" data-placement="top" title="Padam Pengguna">
																<i class="fas fa-trash-alt"></i>
															</a>
															<a href="view_user_student.php?id=<?php echo $student_row['student_id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Maklumat Pengguna">
																<i class="fas fa-eye"></i>
															</a>
														</center>
													</td>
												</tr>
											<?php
											}

											// Query for active supervisors
											$query_supervisor = "SELECT * FROM `supervisor` WHERE status IN ('Aktif', 'Tidak Aktif')";
											$result_supervisor = mysqli_query($conn, $query_supervisor);
											while ($supervisor_row = mysqli_fetch_array($result_supervisor)) {
												$status = $supervisor_row['status'];
												$status_color = ($status === 'Aktif') ? 'lightgreen' : 'lightcoral';
											?>
												<tr>
													<td><?php echo $bil++; ?></td>
													<td><?php echo $supervisor_row['name']; ?></td>
													<td><?php echo $supervisor_row['email']; ?></td>
													<td>Penyelia</td>
													<td style="background-color: <?php echo $status_color; ?>"><?php echo $status; ?></td>
													<td style="text-align: center;">
															<a href="#changePasswordModal" class="btn btn-outline-primary btn-sm change-password" data-toggle="modal" data-user-id="<?php echo $supervisor_row['id']; ?>" data-user-type="supervisor" data-toggle="tooltip" data-placement="top" title="Tukar Kata Laluan"><i class="fas fa-user-lock"></i></a>
															<a href="padamUser.php?id=<?php echo $supervisor_row['id']; ?>&notify=1&category=supervisor" class="btn btn-outline-primary btn-sm btnpadamsv" data-toggle="tooltip" data-placement="top" title="Padam Pengguna"><i class="fas fa-trash-alt"></i></a>
															<a href="view_user_sv.php?id=<?php echo $supervisor_row['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Maklumat Pengguna"><i class="fas fa-eye"></i></a>
													</td>
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
			</section>



			<!-- Modal for password change -->
			<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="changePasswordModalLabel">Tukar Kata Laluan</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- Form to change password -->
							<form id="changePasswordForm" method="post" action="changePassword.php">
								<!-- Hidden fields for user ID and user type -->
								<input type="hidden" id="userId" name="userId">
								<input type="hidden" id="userType" name="userType">

								<!-- Other form elements -->
								<div class="form-group">
									<label for="newPassword">Katalaluan Baru</label>
									<input type="password" class="form-control" id="newPassword" name="newPassword" required>
								</div>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</form>
						</div>
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
	<script src="../../../plugins/jszip/jszip.min.js"></script>
	<script src="../../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="../../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script src="../../../dist/js/adminlte.min.js"></script>
	<script src="../Pengguna/pengguna.js"></script>
	<link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
	<script src="sweetalert2/dist/sweetalert2.min.js"></script>

			<!-- SWEEY ALERT -->
	<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="../../dist/js/demo.js"></script>



	<script>

// Function to handle deletion
$('.btnpadamsv').click(function(e) {
    e.preventDefault();
    var padamsvURL = $(this).attr('href');

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
                url: padamsvURL, // Replace this URL with your delete endpoint
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
		$(document).ready(function() {
			// Function to show change password modal
			$('.btn-success').click(function(e) {
				e.preventDefault();
				var userId = $(this).closest('tr').find('td:first').text(); // Assuming ID is in the first column
				$('#userId').val(userId);
				$('#changePasswordModal').modal('show');
			});

			// Function to handle password change
			$('#changePasswordForm').submit(function(e) {
				e.preventDefault();
				var formData = $(this).serialize();
				$.ajax({
					type: 'POST',
					url: 'changePassword.php', // Change this URL to your password change endpoint
					data: formData,
					success: function(response) {
						$('#changePasswordModal').modal('hide');
						Swal.fire({
							title: 'Kata Laluan Berjaya Ditukar!',
							icon: 'success'
						});
					},
					error: function() {
						Swal.fire({
							title: 'Ralat!',
							text: 'Gagal menukar kata laluan.',
							icon: 'error'
						});
					}
				});
			});

			// Function to handle deletion
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

			// Other scripts and functionalities...
		});
	</script>



</body>

</html>