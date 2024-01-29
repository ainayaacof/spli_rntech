<?php
session_start();
if (isset($_SESSION['name']) == '') {
	header("Location: ../login.php");
}

include "../../conn.php";

if (isset($_GET['id'])) {
	$user_id = $_GET['id'];

	// Query to fetch student data by ID
	$query = "SELECT * FROM `supervisor` WHERE `id` = $user_id";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0) {
		$user_data = mysqli_fetch_assoc($result);
		// Retrieve user data for displaying in the form fields
		$name = $user_data['name'];
		$email = $user_data['email'];
		$phone_num = $user_data['phone_num'];
		$position = $user_data['position'];
		$status = $user_data['status'];
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Maklumat Pengguna</title>

	<?php include "../includes/styles.php"; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Loading indicator -->
		<!-- <div class="preloader flex-column justify-content-center align-items-center">
  <img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
</div> -->

		<?php
		include("../includes/navbar.php");
		include("../includes/sidebar.php");
		?>

		<div class="content-wrapper">
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Maklumat Pengguna</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Maklumat Pengguna</li>
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
									<h4 class="card-title">Maklumat Penyelia</h4>
								</div>
								<div class="card-body">
									<form id="form-edit" action="update_sv.php" method="post" enctype="multipart/form-data" class="p-4">
										<div class="container">
											<div class="row">
												<div class="col-md-12">
													<div class="mb-3">
														<label for="name" class="form-label">Nama:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-person-circle"></i></span>
															<input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="email" class="form-label">Emel Pengguna:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-envelope"></i></span>
															<input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="address" class="form-label">Jawatan:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-house"></i></span>
															<input type="text" class="form-control" id="position" name="position" value="<?php echo $position ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="phone_num" class="form-label">Nombor Telefon:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-phone"></i></span>
															<input type="tel" class="form-control" id="phone_num" name="phone_num" value="<?php echo $phone_num ?>" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="status" class="form-label">Status:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-phone"></i></span>
															<select class="form-control" id="status" name="status" <?php echo isset($_GET['edit']) ? '' : 'disabled' ?>>
																<?php
																$status_options = array('Aktif', 'Tidak Aktif');
																foreach ($status_options as $option) {
																	$selected = ($status === $option) ? 'selected' : '';
																	echo "<option value='$option' $selected>$option</option>";
																}
																?>
															</select>
														</div>
													</div>

												</div>
											</div>
										</div>

										<div class="text-right"> <!-- Changed class from "text-center" to "text-right" -->
											<?php if (isset($_GET['edit'])) { ?>
												<button type="button" id="submitEditButton" class="btn btn-primary">Simpan</button>
												<input type="hidden" id="id_edit" name="id_edit" value="<?php echo $user_id ?>">
												<a href="javascript:history.back()" class="btn btn-secondary mx-2">Kembali</a>
												<!-- Add the additional back button before the "Kemaskini" button -->
											<?php } else { ?>
												<a href="?edit=true&id=<?php echo $user_id; ?>" class="btn btn-primary">Kemaskini</a>
												<a href="list_user.php?id=<?php echo $user_id; ?>" class="btn btn-secondary">Kembali</a>
											<?php } ?>
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


	<?php include "../includes/scripts.php"; ?>
	<script src="../pengguna/pengguna.js"></script>

</body>

</html>