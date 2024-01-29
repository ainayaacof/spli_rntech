<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SPLI RNTECH | Senarai Permarkahan</title>

  <?php include "../includes/styles.php"; ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

<!-- Loading indicator -->
<div class="preloader flex-column justify-content-center align-items-center">
      <img src="/splirntech/assets/img/loading.png" alt="Loading..." class="spinning-image">
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
              <h1 class="m-0">Senarai Hebahan Latihan Industri</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                <li class="breadcrumb-item active">Senarai Hebahan</li>
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
                  <h3 class="card-title">Hebahan Latihan Industri</h3>
                  <a href="hebahan_li.php" class="btn btn-navy btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Rekod Baru">
                    <i class="fas fa-plus"></i>
                    <span class="ml-1">Rekod Baru</span>
                  </a>
                </div>
                <div class="card-body">
					<?php
						$queryhebahan = "SELECT * FROM `intern_post`";
						$resulthebahan = mysqli_query($conn, $queryhebahan);
					?>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th width="5%">Bil.</th>
                          <th>Tajuk</th>
                          <th>Keterangan</th>
                          <th>Tarikh Akhir Permohonan </th>
                          <th width="10%" style="text-align: center;"> Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bil = 1; // Initialize the counter
                        if (mysqli_num_rows($resulthebahan) > 0) {
                          while ($myrowhebahan = mysqli_fetch_array($resulthebahan)) {
                        ?>
                                  <tr >
                                      <td><?php echo $bil; ?></td>
                                      <td><?php echo $myrowhebahan['title']; ?></td>
                                      <td><?php echo $myrowhebahan['description']; ?></td>
                                      <td><?php echo date('d/m/Y', strtotime($myrowhebahan['date_to'])); ?></td>
                                      <td style="text-align: center;">
                                          <a href="update_hebahan.php?id=<?php echo $myrowhebahan['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm"  style="margin:5px;" data-toggle="tooltip" data-placement="top" title="View" ><i style="font-size:20px" class="fas">&#xf044; </i></a>
                                          <a href="padam_hebahan.php?id=<?php echo $myrowhebahan['id']; ?>&notify=1" class="btn btn-outline-primary btn-sm"  style="margin:5px;" data-toggle="tooltip" data-placement="top" title="Padam" id="btnpadam"><i style="font-size:20px" class="fas fa-trash-alt"></i></a>
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
      </section>

    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>
  <?php include "../includes/scripts.php"; ?>
  <script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="js/list_mark.js"></script>

  <script>
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




</body>

</html>