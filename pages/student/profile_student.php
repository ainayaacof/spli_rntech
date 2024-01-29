<?php
session_start();
if (isset($_SESSION['name']) == '') {
	header("Location: ../login.php");
}

include "../conn.php";

$sql = "SELECT * FROM `student` WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$id_edit = $row['student_id'];
		$name = $row['name'];
		$email = $row['email'];
		$phone_num = $row['phone_num'];
		$password = $row['password'];
		$profile_pic = $row['profile_pic'];
		$slip_ic = $row['slip_ic'];
		$bank_slip = $row['bank_slip'];
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Profil Pengguna</title>

	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
	<link rel="stylesheet" href="../../dist/css/alt/splicss.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

	<!-- Sweet Alert -->
	<link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<script src="../plugins/jquery/jquery.min.js"></script>
	<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../dist/js/adminlte.min.js"></script>
	<script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="../dist/js/demo.js"></script>



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

		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Profil Pengguna</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="dashboard_student.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Profil Pengguna</li>
							</ol>
						</div>
					</div>
				</div>
			</div>

			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card card-navy">
								<div class="card-header">
									<h3 class="card-title">Maklumat Profil Pelajar</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<form id="form-edit" action="update_profile.php" method="post" enctype="multipart/form-data" class="p-4">

													<div class="mb-3 text-center">
														<?php if(isset($profile_pic) && !empty($profile_pic)) { ?>
															<div class="mt-2">
																<img src="../upload/profile_pic/<?php echo $profile_pic; ?>" alt="Profile Picture" class="img-fluid img-thumbnail" style="max-width: 150px;">
															</div>
														<?php } else { ?>
															<div class="mt-2">
																<img src="../../assets/img/profile.png" alt="Default Profile Picture" class="img-fluid img-thumbnail" style="max-width: 160px;">
															</div>
														<?php } ?>
														<?php if (isset($_GET['edit'])) { ?>
															<div class="mt-3">
																<label for="new_profile_pic" class="form-label">Muat Naik Gambar Profil:</label>
																<input type="file" class="form-control" id="new_profile_pic" name="new_profile_pic">
															</div>
														<?php } ?>
													</div>
													
													<div class="mb-3">
														<label for="name" class="form-label"> Nama:</label>
														<div class="input-group">
															<span class="input-group-text"><i
																	class="bi bi-person-fill"></i></span>
															<input type="text" class="form-control" id="name"
																name="name" value="<?php echo $name ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="email" class="form-label"> Emel Pengguna:</label>
														<div class="input-group">
															<span class="input-group-text"><i
																	class="bi bi-envelope-fill"></i></span>
															<input type="email" class="form-control" id="email"
																name="email" value="<?php echo $email ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="password" class="form-label">Katalaluan:</label>
														<div class="input-group">
															<span class="input-group-text" id="togglePassword">
																<i class="fas fa-eye"></i>
															</span>
															<input type="password" class="form-control" id="password"
																name="password" value="<?php echo $password ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="phone_num" class="form-label">Nombor Telefon:</label>
														<div class="input-group">
															<span class="input-group-text"><i
																	class="bi bi-telephone-fill"></i></span>
															<input type="tel" class="form-control" id="phone_num"
																name="phone_num" value="<?php echo $phone_num ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>
													
													<div class="mb-3">
														<label for="phone_num" class="form-label">Salinan No. Kad Pengenalan:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
															<input type="text" class="form-control" value="<?php echo $slip_ic; ?>" readonly>
															<input type="file" class="form-control" id="icFileUpload" name="icFile" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="phone_num" class="form-label">Salinan Bank Akaun:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="fas fa-file-pdf"></i></span>
															<input type="text" class="form-control" value="<?php echo $bank_slip; ?>" readonly>
															<input type="file" class="form-control" id="bankFileUpload" name="bankFile" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<?php if (isset($_GET['edit'])) { ?>
														<div style="text-align: right; margin-right:0px;">
															<button type="submit" id="btnSimpan" class="btn btn-primary">Simpan</button>
															<input type="hidden" id="id_edit" name="id_edit" value="<?php echo $id_edit ?>">
															<a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
														</div>
													<?php } else { ?>
														<div style="text-align: right; margin-right:0px;">
															<a href="?edit=true" class="btn btn-primary">kemaskinilah</a>
														</div>
													<?php } ?>
									</form>
								</div>
								<!-- /.card-body -->
							</div>
						</div>
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

	<script>
		function enableEdit() {
			var inputs = document.getElementsByTagName("input");
			for (var i = 0; i < inputs.length; i++) {
				inputs[i].removeAttribute("disabled");
			}
			document.getElementById("editButton").style.display = "none";
			document.getElementById("saveButton").style.display = "inline-block";
		}
	</script>
	<script>
		function enableEdit() {
			var inputs = document.getElementsByTagName("input");
			for (var i = 0; i < inputs.length; i++) {
				inputs[i].removeAttribute("disabled");
			}
			document.getElementById("editButton").style.display = "none";
			document.getElementById("saveButton").style.display = "inline-block";

			// Set the id_edit value in the form
			var idEditField = document.getElementById("id_edit");
			var idEditValue = /* Logic to get or set the id_edit value */
				idEditField.value = idEditValue;
		}
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const passwordField = document.getElementById("password");
			const togglePassword = document.getElementById("togglePassword");

			if (passwordField && togglePassword) {
				togglePassword.addEventListener("click", function () {
					const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
					passwordField.setAttribute("type", type);
					this.querySelector("i").classList.toggle("bi-eye");
					this.querySelector("i").classList.toggle("bi-eye-slash");
				});
			}
		});
	</script>
	<script>
		$(document).ready(function () {

			// Attach the form submission handling to the "Save" button click event
			$('#btnSimpan').on('click', function (e) {
				e.preventDefault();
				var form = $('#form-edit'); // Get the form element

				// Check for required fields
				var requiredFields = form.find('[required]');
				var isValid = true;

				// Remove any existing error messages
				form.find('.error-message').remove();

				requiredFields.each(function () {
					if ($(this).val().trim() === '') {
						isValid = false;
						$(this).after('<span class="error-message" style="color:red">Sila isi ruangan ini*</span>');
					}
				});

				if ($('#icFile').val().trim() === '') {
					isValid = false;
					$('#icFile').after('<span class="error-message" style="color:red">Sila masukkan Lampiran*</span>');
				}

				if ($('#bankFile').val().trim() === '') {
					isValid = false;
					$('#bankFile').after('<span class="error-message" style="color:red">Sila masukkan Lampiran*</span>');
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

</body>

</html>