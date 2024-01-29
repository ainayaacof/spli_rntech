<?php
session_start();
if (isset($_SESSION['name']) == '') {
	header("Location: ../../login.php");
}

include "../../conn.php";

$sql = "SELECT * FROM `hr` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$id_edit = $row['id'];
		$name = $row['name'];
		$email = $row['email'];
		$phone_num = $row['phone_num'];
		$password = $row['password'];
		$profile_pic =$row['profile_pic'];
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RNTECH | Profil</title>

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
							<h1 class="m-0">Profil Pengguna</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard/dashboard_hr.php">Laman Utama</a></li>
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
									<h3 class="card-title">Profil Pengguna</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<!-- <form id="form-edit" action="profile_edit_save.php" method="post" enctype="multipart/form-data" class="p-4"> -->
									<form id="form-edit" action="profile_edit_save.php?id=<?php echo $_SESSION['id']; ?>" method="post" enctype="multipart/form-data" class="p-4">

										
												<div class="col-md-12">
													<div class="mb-3 text-center">
														<?php if(isset($profile_pic) && !empty($profile_pic)) { ?>
															<div class="mt-2">
																<img src="../../upload/profile_pic/<?php echo $profile_pic; ?>" alt="Profile Picture" class="img-fluid img-thumbnail" style="max-width: 150px;">
															</div>
														<?php } else { ?>
															<div class="mt-2">
																<img src="../../../assets/img/profile.png" alt="Default Profile Picture" class="img-fluid img-thumbnail" style="max-width: 160px;">
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
															<span class="input-group-text"><i class="bi bi-person-fill"></i></span>
															<input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" <?php echo isset($_GET['edit']) ? '' : 'readonly' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="email" class="form-label"> Emel Pengguna:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
															<input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" <?php echo isset($_GET['edit']) ? '' : 'readonly' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="password" class="form-label">Katalaluan:</label>
														<div class="input-group">
															<span class="input-group-text" id="togglePassword">
																<i class="fas fa-eye"></i>
															</span>
															<input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>" <?php echo isset($_GET['edit']) ? '' : 'readonly' ?>>
														</div>
													</div>

													<div class="mb-3">
														<label for="phone_num" class="form-label">Nombor Telefon:</label>
														<div class="input-group">
															<span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
															<input type="tel" class="form-control" id="phone_num" name="phone_num" value="<?php echo $phone_num ?>" <?php echo isset($_GET['edit']) ? '' : 'readonly' ?>>
														</div>
													</div>

													<div class="text-center d-flex justify-content-end">
														<?php if (isset($_GET['edit'])) { ?>
															<button type="submit" class="btn btn-primary" id="simpanButton">Simpan</button>
															<input type="hidden" id="id_edit" name="id_edit" value="<?php echo $id_edit ?>">
															<a href="javascript:history.back()" class="btn btn-secondary mx-2">Kembali</a>
														<?php } else { ?>
															<a href="?edit=true" class="btn btn-primary" id="kemaskiniButton">Kemaskini</a>
														<?php } ?>
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
	<script src="../Profil/profil.js"></script>

</body>
<script>
  // Function to trigger SweetAlert for confirmation
  function confirmSave() {
    Swal.fire({
      title: 'Anda Pasti?',
	  text: 'Untuk Kemaskini Data',
      showCancelButton: true,
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        // If user clicks 'Yes', submit the form
        document.getElementById('form-edit').submit();
      }
    });
  }

  // Function to show success message after updating data
  function showSuccessMessage() {
    swal(
		'!',
		'Your file has been deleted.',
		'success'
	);
  }
  
  // Adding event listener when the 'Simpan' button is clicked
  document.getElementById('simpanButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission
    confirmSave(); // Show confirmation before submitting
  });
</script>


</html>