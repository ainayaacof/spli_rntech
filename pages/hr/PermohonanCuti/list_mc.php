<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Senarai Permohonan Cuti</title>

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
							<h1 class="m-0">Senarai Permohonan Cuti</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Senarai Permohonan Cuti</li>
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
											<a class="nav-link active" id="baru-tab" data-toggle="pill" href="#baru" role="tab" aria-controls="baru" aria-selected="true">Baru</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="lulus-tab" data-toggle="pill" href="#lulus" role="tab" aria-controls="lulus" aria-selected="false">Lulus</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="terdahulu-tab" data-toggle="pill" href="#terdahulu" role="tab" aria-controls="terdahulu" aria-selected="false">Senarai Terdahulu</a>
										</li>
									</ul>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-two-tabContent">
										<div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="baru-tab">
											<?php
											$queryBaru = "SELECT la.id, la.student_id, la.date_apply, la.date_leave,  la.date_end, la.reason, s.name, s.student_id AS studID
												  FROM `leave_app` la 
												  JOIN `student` s ON la.student_id = s.student_id 
												  WHERE la.`status`='Baru'";
											$resultBaru = mysqli_query($conn, $queryBaru);

											// Initialize a counter for row numbering
											$rowNumber1 = 1;
											?>
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th width="5%">Bil</th>
														<th width="20%">Nama</th>
														<th width="15%">Tarikh Mohon</th>
														<th width="20%">Tarikh Cuti</th>
														<th width="20%">Sebab</th>
														<th width="13%" style="text-align: center;">Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if (mysqli_num_rows($resultBaru) > 0) {
														while ($myrowBaru = mysqli_fetch_array($resultBaru)) {
													?>
															<tr>
																<td><?php echo $rowNumber1; ?></td>
																<td><?php echo $myrowBaru['name']; ?></td>
																<td><?php echo date('d/m/Y', strtotime($myrowBaru['date_apply'])); ?></td>
																<td>
																	<?php
																	$date_leave = date('d/m/Y', strtotime($myrowBaru['date_leave']));
																	$date_end = $myrowBaru['date_end'] !== null ? date('d/m/Y', strtotime($myrowBaru['date_end'])) : null;

																	echo $date_leave;

																	if ($date_end !== null) {
																		echo ' hingga ' . $date_end;
																	}
																	?>
																</td>
																<td><?php echo $myrowBaru['reason']; ?></td>
																<td>
																	<a href="terimaCuti.php?id=<?php echo $myrowBaru['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Terima"><i class="fas fa-check"></i></a>
																	<a href="tolakCuti.php?id=<?php echo $myrowBaru['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Tolak"><i class="fas fa-times"></i></a>
																	<a href="padamCuti.php?id=<?php echo $myrowBaru['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Padam"><i class="fas fa-trash-alt"></i></a>
																	<a href="viewCuti.php?id=<?php echo $myrowBaru['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Maklumat"><i class="fas fa-eye"></i></a>
																</td>

															</tr>
														<?php
															$rowNumber1++;
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

										<div class="tab-pane fade" id="lulus" role="tabpanel" aria-labelledby="lulus-tab">
											<?php
											$queryLulus = "SELECT la.id, la.student_id, la.date_apply, la.date_leave, la.date_end, la.reason, s.name, s.student_id AS studID 
												   FROM `leave_app` la 
												   JOIN `student` s ON la.student_id = s.student_id 
												   WHERE la.`status` = 'Lulus' AND la.`date_leave` > CURDATE()";
											$resultLulus = mysqli_query($conn, $queryLulus);

											// Initialize a counter for row numbering
											$rowNumber2 = 1;
											?>
											<table id="example2" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th width="5%">Bil</th>
														<th width="20%">Nama</th>
														<th width="15%">Tarikh Mohon</th>
														<th width="20%">Tarikh Cuti</th>
														<th width="20%">Sebab</th>
														<th width="10%" style="text-align: center;">Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if (mysqli_num_rows($resultLulus) > 0) {
														while ($myrowLulus = mysqli_fetch_array($resultLulus)) {
													?>
															<tr>
																<td><?php echo $rowNumber2; ?></td>
																<td><?php echo $myrowLulus['name']; ?></td>
																<td><?php echo date('d/m/Y', strtotime($myrowLulus['date_apply'])); ?></td>
																<td>
																	<?php
																	$date_leave = date('d/m/Y', strtotime($myrowLulus['date_leave']));
																	$date_end = $myrowLulus['date_end'] !== null ? date('d/m/Y', strtotime($myrowLulus['date_end'])) : null;

																	echo $date_leave;

																	if ($date_end !== null) {
																		echo ' hingga ' . $date_end;
																	}
																	?>
																</td>
																<td><?php echo $myrowLulus['reason']; ?></td>
																<td>
																	<a href="editCuti.php?id=<?php echo $myrowLulus['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
																	<a href="padamCuti.php?id=<?php echo $myrowLulus['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Padam"><i class="fas fa-trash-alt"></i></a>
																	<a href="viewCuti.php?id=<?php echo $myrowLulus['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Maklumat"><i class="fas fa-eye"></i></a>
																</td>

															</tr>
														<?php
															$rowNumber2++;
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
											<!-- Add Button -->
											<div class="mb-3">
												<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addDataModal">
													<i class="fas fa-plus"></i>
												</button>
											</div>
											<?php
											$queryTerdahulu = "SELECT la.id, la.student_id, la.date_apply, la.date_leave, la.date_end, la.reason, s.name, s.student_id AS studID
													   FROM `leave_app` la 
													   JOIN `student` s ON la.student_id = s.student_id 
													   WHERE la.`status` = 'Lulus' AND la.`date_leave` < CURDATE()";
											$resultTerdahulu = mysqli_query($conn, $queryTerdahulu);

											$rowNumber = 1;
											?>
											<table id="example3" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th width="5%">Bil</th>
														<th width="20%">Nama</th>
														<th width="15%">Tarikh Mohon</th>
														<th width="20%">Tarikh Cuti</th>
														<th width="20%">Sebab</th>
														<th width="10%" style="text-align: center;">Tindakan</th>
													</tr>
												</thead>
												<tbody>
													<?php
													if (mysqli_num_rows($resultTerdahulu) > 0) {
														while ($myrowTerdahulu = mysqli_fetch_array($resultTerdahulu)) {
													?>
															<tr>
																<td><?php echo $rowNumber; ?></td>
																<td><?php echo $myrowTerdahulu['name']; ?></td>
																<td><?php echo date('d/m/Y', strtotime($myrowTerdahulu['date_apply'])); ?></td>
																<td>
																	<?php
																	$date_leave = date('d/m/Y', strtotime($myrowTerdahulu['date_leave']));
																	$date_end = $myrowTerdahulu['date_end'] !== null ? date('d/m/Y', strtotime($myrowTerdahulu['date_end'])) : null;

																	echo $date_leave;

																	if ($date_end !== null) {
																		echo ' hingga ' . $date_end;
																	}
																	?>
																</td>
																<td><?php echo $myrowTerdahulu['reason']; ?></td>
																<td>
																	<a href="editCuti.php?id=<?php echo $myrowTerdahulu['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt"></i></a>
																	<a href="padamCuti.php?id=<?php echo $myrowTerdahulu['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Padam"><i class="fas fa-trash-alt"></i></a>
																	<a href="viewCuti.php?id=<?php echo $myrowTerdahulu['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Maklumat"><i class="fas fa-eye"></i></a>


																</td>
															</tr>
														<?php
															$rowNumber++;
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


									</div> <!--TEST-->
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal for adding new data -->
				<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<!-- Modal Header -->
							<div class="modal-header">
								<h5 class="modal-title" id="addDataModalLabel">Maklumat Cuti</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<!-- Modal Body - Form for adding new data -->
							<div class="modal-body">
								<form id="form-edit" action="save_cuti.php" method="post" enctype="multipart/form-data">
									<div class="container">
										<div class="form-group">
											<label for="nama">Nama</label>
											<select class="form-control" id="nama" name="nama">
												<option value="">Pilih Nama Pelajar</option>

												<?php
												// Assuming $conn is your database connection
												$queryStudents = "SELECT student_id, name FROM student WHERE status = 'Aktif'";
												$resultStudents = mysqli_query($conn, $queryStudents);

												if (mysqli_num_rows($resultStudents) > 0) {
													while ($rowStudent = mysqli_fetch_assoc($resultStudents)) {
														echo "<option value='" . $rowStudent['student_id'] . "'>" . $rowStudent['name'] . "</option>";
													}
												}
												?>
											</select>
											<label for="tarikh_mohon">Tarikh Mohon</label>
											<?php
											$Date = gmdate('Y-m-d');
											?>
											<input type="date" class="form-control" id="tarikh_mohon" name="tarikh_mohon" value="<?php echo $Date; ?>" readonly>

											<label for="tarikh_cuti_dari">Tarikh Cuti Dari</label>
											<input type="date" class="form-control" id="tarikh_cuti_dari" name="tarikh_cuti_dari" placeholder="">

											<label for="tarikh_cuti_hingga">Tarikh Cuti Hingga</label>
											<input type="date" class="form-control" id="tarikh_cuti_hingga" name="tarikh_cuti_hingga" placeholder="">

											<label for="sebab">Sebab</label>
											<input type="text" class="form-control" id="sebab" name="sebab">

											<td>
											<td>
												<label for="pdf" class="form-label">Lampiran:</label>
												<br>
												<form action="list_mc.php" method="post" enctype="multipart/form-data">
													<input type="file" name="pdfFile" id="pdfFile">
													<br>
												</form>
											</td><br>
											</td>
											<input type="submit" class="btn btn-primary btn-block" value="Simpan" name="submit">
										</div>
									</div>
								</form>
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
	<?php include "../includes/scripts.php"; ?>
	<script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../PermohonanCuti/cuti.js"></script>

</body>

</html>