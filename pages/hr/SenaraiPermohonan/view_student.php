<?php
session_start();
if (isset($_SESSION['name']) == '') {
	header("Location: ../../login.php");
}

include "../../conn.php";

if (isset($_GET['id'])) {
	$user_id = $_GET['id'];

	// Query to fetch student data by ID
	$query = "SELECT * FROM `student` WHERE `id` = '" . $user_id . "'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0) {
		$user_data = mysqli_fetch_assoc($result);
		// Retrieve user data for displaying in the form fields
		$name = $user_data['name'];
		$email = $user_data['email'];
		$phone_num = $user_data['phone_num'];
		$address = $user_data['address'];
		$supervisor_id = $user_data['sv_id'];
		$status = $user_data['status'];
	}

	$query_supervisor = "SELECT * FROM `supervisor` WHERE `sv_id` = '" . $supervisor_id . "'";
	$result_supervisor = mysqli_query($conn, $query_supervisor);

	if (mysqli_num_rows($result_supervisor) > 0) {
		$supervisor_data = mysqli_fetch_assoc($result_supervisor);
		$supervisor_name = $supervisor_data['name'];
	} else {
		$supervisor_name = "Tiada Penyelia Industri"; // Set default value if supervisor not found
	}

	$query_university = "SELECT * FROM `application_intern` WHERE `student_id` = '" . $user_id . "'";
	$result_university = mysqli_query($conn, $query_university);

	if (mysqli_num_rows($result_university) > 0) {
		$university_data = mysqli_fetch_assoc($result_university);
		$uni_name = $university_data['uni_name'];
		$uni_phone = $university_data['uni_phone'];
		$course = $university_data['course'];
		$resume = $university_data['resume'];
        $uni_letter = $university_data['uni_letter'];
		$last_intern = $university_data['last_intern'];
		$start_intern = $university_data['start_intern'];
        $tempoh_intern = $university_data['tempoh_intern'];
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Maklumat Pengguna</title>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Maklumat Pelajar</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Maklumat Pelajar</li>
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
									<h4 class="card-title">Maklumat Pelajar</h4>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<form id="formedit" action="update_studentactive.php?student_id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data" class="p-4">
										<div class="container" style="max-width: 3000px;">
											<div class="row">
												<div class="col-md-6">
													<div class="mb-3">
														<label for="name" class="form-label">Nama:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-person-circle"></i></span>
															<input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="email" class="form-label">Emel Pengguna:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-envelope"></i></span>
															<input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="address" class="form-label">Alamat:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-house"></i></span>
															<input type="address" class="form-control" id="address" name="address" value="<?php echo $address ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="phone_num" class="form-label">Nombor Telefon:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-phone"></i></span>
															<input type="tel" class="form-control" id="phone_num" name="phone_num" value="<?php echo $phone_num ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="supervisor_name" class="form-label">Nama Penyelia:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-person-check"></i></span>
															<input type="text" class="form-control" id="supervisor_name" name="supervisor_name" value="<?php echo $supervisor_name ?>" readonly>
														</div>
													</div>

                                                    <div class="mb-3">
														<label for="tempoh_LI" class="form-label">Tempoh Latihan Industri:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-person-check"></i></span>
															<input type="text" class="form-control" id="tempoh_intern" name="tempoh_intern" value="<?php echo $tempoh_intern . ' bulan'; ?>" readonly>
														</div>
													</div>
												</div>


												<div class="col-md-6">
													<!-- University details from application_intern table -->
													<div class="mb-3">
														<label for="uni_name" class="form-label">Nama Universiti:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-building"></i></span>
															<input type="text" class="form-control" id="uni_name" name="uni_name" value="<?php echo $uni_name ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="uni_phone" class="form-label">Nombor Telefon Universiti:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
															<input type="tel" class="form-control" id="uni_phone" name="uni_phone" value="<?php echo $uni_phone ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="course" class="form-label">Kursus:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-book-fill"></i></span>
															<input type="text" class="form-control" id="course" name="course" value="<?php echo $course ?>" readonly>
														</div>
													</div>

													<div class="mb-3">
														<label for="resume" class="form-label">Resume:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
															<input type="text" class="form-control" id="resume" name="resume" value="<?php echo $resume ?>" readonly>
															<?php
															// Check if $resume is not empty
															if (!empty($resume)) {
																// Display button with custom color and a download icon for downloading the resume
																echo '<a href="../../upload/permohonanfile/' . $resume . '" target="_blank" class="btn" style="background-color: #ced4da;"><i class="bi bi-download"></i></a>';
															}
															?>
														</div>
													</div>

                                                    <div class="mb-3">
														<label for="resume" class="form-label">Surat Universiti:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-file-earmark-text-fill"></i></span>
															<input type="text" class="form-control" id="uni_letter" name="uni_letter" value="<?php echo $uni_letter ?>" readonly>
															<?php
															// Check if $resume is not empty
															if (!empty($resume)) {
																// Display button with custom color and a download icon for downloading the resume
																echo '<a href="../../upload/permohonanfile/' . $uni_letter . '" target="_blank" class="btn" style="background-color: #ced4da;"><i class="bi bi-download"></i></a>';
															}
															?>
														</div>
													</div>

													<div class="col-md-12">
														<div class="row">
															<!-- University details and date inputs -->
															<div class="col-md-6">
																<label for="start_intern" class="form-label">Mula Latihan Industri:</label>
																<div class="input-group">
																	<span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
																	<input type="date" class="form-control" id="start_intern" name="start_intern" value="<?php echo date('Y-m-d', strtotime($start_intern)); ?>" readonly>

																</div>
															</div>
															<div class="col-md-6">
																<label for="last_intern" class="form-label">Tamat Latihan Industri:</label>
																<div class="input-group">
																	<span class="input-group-text"><i class="bi bi-calendar-check-fill"></i></span>
																	<input type="date" class="form-control" id="last_intern" name="last_intern" value="<?php echo date('Y-m-d', strtotime($last_intern)); ?>" min="<?php echo date('Y-m-d', strtotime($start_intern_formatted)); ?>" readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-12 text-right"> <!-- Changed class to "text-right" --><br>
														<a href="javascript:history.back()" class="btn btn-secondary mx-2">Kembali</a>
														
												</div>
											</div>
										</div>
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
	


</body>

</html>