<?php
// Start or resume the session
session_start();

include "../../conn.php";
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RN TECH | ADUAN</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.css">
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
</head>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
   <!-- Loading indicator -->
<!-- <div class="preloader flex-column justify-content-center align-items-center">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div> -->
  <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <?php
      include ("../includes/navbar.php");
      ?>

  <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <?php
      include ("../includes/mainsidebar.php");
      ?>

  <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
              <li class="breadcrumb-item active">Aduan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <!-- Main content -->
    <section class="content">
		<div class="container-fluid">
			<div class="card card-warning">
				<div class="card-header">
					<h3 class="card-title">ADUAN BARU</h3>
				</div>

				<!-- form start -->
				<?php
					// Fetch student names from the database
					$query = "SELECT student.id AS studID, student.name AS studName, supervisor.name AS svName FROM student JOIN supervisor";
					$result = $conn->query($query);

					// Check if there are rows returned
					if ($result->num_rows > 0) {
						// Store student names in an array
						$students = array();
						while ($row = $result->fetch_assoc()) {
							$students[] = $row['studName'];
							$svname = $row['svName'];
						}
					} else {
						// Handle the case when no students are found
						echo "No students found in the database.";
					}  
				?>

				<div class="card-body">
					<form method='post' action='addFeedback_svDB.php'>
						<div class="form-group">
							<label for="pengadu">Pengadu</label>
							<input class="form-control" name="pengadu" id="pengadu" value="<?php echo $svname; ?>" readonly>
						</div>

						<div class="form-group">
							<label for="studentName">Nama Pelajar</label>
							<select class="form-control" name="studentName" id="studentName">
								<?php
								// Populate dropdown with student names
								foreach ($students as $student) {
									echo "<option value=\"$student\">$student</option>";
								}
								?>
							</select>
						</div>

						<div class="form-group">
							<label for="aduan">Aduan</label>
							<input class="form-control" name="aduan" id="aduan" placeholder="Aduan yang ingin dikenakan">
						</div>

						<div class="form-group">
							<label for="date">Tarikh Aduan</label>
							<input type="date" class="form-control" name="date" id="date" placeholder="Tarikh aduan dibuat">
						</div>

						<div class="form-group">
							<label for="time">Masa Aduan</label>
							<input type="time" class="form-control" name="time" id="time" placeholder="Masa aduan dibuat">
						</div>

						<div class="form-group">
							<label for="type">Jenis Aduan</label>
							<input type="text" class="form-control" name="type" id="type" placeholder="Jenis Aduan">
						</div>

						<input type='submit' name='submit' value='SUBMIT' class='btn btn-danger' onclick='return confirmUpdate()'>
					</form>
				</div>
				<!-- /.card-body -->    
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="card card-navy">
				<div class="card-header">
					<h3 class="card-title">SEJARAH ADUAN</h3>
				</div>

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Student Name</th>
									<th>Aduan</th>
									<th>Tarikh Aduan</th>
									<th>Masa Aduan</th>
									<th>Jenis Aduan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = "SELECT feedback.person_by AS person, feedback.description AS description, feedback.date AS date,
									feedback.time AS time, feedback.feedback_type AS type, feedback.status AS status
									FROM feedback
									INNER JOIN supervisor ON feedback.make_by = supervisor.name
									WHERE supervisor.id ='" . $id . "'";
								$result = mysqli_query($conn, $query);
								$num_rows = mysqli_num_rows($result);

								if ($num_rows > 0) {
									while ($row = mysqli_fetch_array($result)) {
										echo "<tr>";
										echo "<td>" . $row["person"] . "</td>";
										echo "<td>" . $row["description"] . "</td>";
										echo "<td>" . $row["date"] . "</td>";
										echo "<td>" . $row["time"] . "</td>";
										echo "<td>" . $row["type"] . "</td>";
										echo "<td>" . $row["status"] . "</td>";
										echo "</tr>";
									}
								} else {
									echo '<tr><td colspan="6">Tiada Rekod</td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<br><br>
    
  </div>
  
  

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<?php
      include ("../includes/footer.php");
      ?>

<script src="../../../plugins/jquery/jquery.min.js"></script>
<script src="../../../plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../plugins/chart.js/Chart.min.js"></script>
<script src="../../../plugins/sparklines/sparkline.js"></script>
<script src="../../../plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="../../../plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="../../../plugins/moment/moment.min.js"></script>
<script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
<script src="../../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../../plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../../../dist/js/adminlte.js"></script>
<script src="../../../dist/js/demo.js"></script>
<script src="../../../dist/js/pages/dashboard.js"></script>
</body>
</html>