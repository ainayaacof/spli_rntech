<?php
// Include necessary files and start the session if needed
session_start();
include "../../conn.php";

// Check if the ID is provided via GET parameter
if (isset($_GET['id'])) {
    $hebahan_id = $_GET['id'];

    // Query to fetch leave application details based on the provided ID
    $queryhebahan = "SELECT * FROM `intern_post` WHERE id= '" . $hebahan_id . "'";
    $resulthebahan = mysqli_query($conn, $queryhebahan);

    if ($resulthebahan && mysqli_num_rows($resulthebahan) > 0) {
        $postDetails = mysqli_fetch_assoc($resulthebahan);

        // Assign retrieved data to variables
        $hebahan_id = $postDetails['id'];
        $title = $postDetails['title'];
        $description = $postDetails['description'];
        $date_to = $postDetails['date_to'];
    } else {
        // No leave application found with the provided ID
        echo "No data found";
        exit();
    }
} else {
    // Redirect if ID is not provided
    header("Location: hebahan_list.php");
    exit();
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
                            <h1 class="m-0">Maklumat Permohonan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Kemaskini : Hebahan Latihan Industri</li>
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
                                    <h4 class="card-title mb-0">Hebahan LI</h4>
                                </div>
                                <div class="card-body">
                                    <form id="editForm"  method="post" action="edit_hebahan.php?id=<?php echo $hebahan_id; ?>">
                                        <input type="hidden" name="hebahan_id" value="<?php echo $id; ?>">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="width: 15%;">Tajuk</th>
                                                    <td><input type="text" class="form-control" name="title" value="<?php echo $title; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Keterangan</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="description" value="<?php echo $description; ?>">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">Tarikh Akhir Permohonan</th>
                                                    <td>
                                                        <input type="date" class="form-control" name="date_to" value="<?php echo $date_to; ?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right mt-3">
                                            <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                                            <button type="submit" class="btn btn-primary" id="btnkemaskini" >Simpan</button>
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

    <script>
  $('#btnkemaskini').click(function(e) {
	e.preventDefault();
    var form = $(this).parents('form'); // Get the form element

	Swal.fire({
		title: 'Adakah anda pasti?',
		text: 'Data akan dikemaskini dari sistem!',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Kemaskini!',
		cancelButtonText: 'Batal'
	}).then((result) => {
		// Check if the user clicked "Ya, simpan!"
        if (result.isConfirmed) {
					$('#editForm').submit(); // Submit the form
        };
    });
});
</script>
</body>

</html>