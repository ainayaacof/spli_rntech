<?php
$post_id = $_GET['post_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PERMOHONAN</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- SWEEY ALERT -->
	<link rel="stylesheet" href="../../plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

	<script type="text/javascript" src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
	<script src="../../dist/js/demo.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body class="hold-transition register-page">
<div class="register-box" >
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h3"><b>Permohonan Latihan Industri</b></a>
    </div>
    <div class="card-body">
    <!-- Replace the relevant sections in the first code with the input fields from the second code -->

<form id="formMohon" action="mohonLI_db.php?post_id=<?php echo $post_id;?>" method="post" enctype="multipart/form-data" class="p-4">
    <div class="container">
            <div class="row">
                    <div class="col-md-6">
                        <!-- Input fields from the registration form -->
                        <div class="mb-3">

                        <?php
                            date_default_timezone_set('Asia/Kuala_Lumpur');
                            $Date = gmdate('Y-m-d'); 
                            $currenttime = date('h:ia');
                        ?>


                        <!-- <h4>Sila isikan butiran dibawah</h4> -->
                        <!-- <label for="name" class="form-label">Sila isikan butiran dibawah untuk permohonan latihan industri di RN Technologies Sdn.Bhd.</label> -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Tarikh Mohon Latihan Industri:</label>
                                <input type="date" class="form-control" id="dateApply" name="dateApply" value="<?php echo $Date; ?>" readonly>
                        </div>
                        <div>
                            <div class="mb-3">
                            <label for="time" class="form-label">Masa Mohon Latihan Industri:</label>
                                <input class="form-control" id="timeApply" name="timeApply" value ="<?php echo $currenttime; ?>" placeholder="<?php echo $currenttime; ?>" readonly>
                        </div>
                            
                        </div>  
                        <label for="name" class="form-label">Nama Penuh:</label>
                                <!-- <span class="input-group-text"><i class="bi bi-person-circle"></i></span> -->
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Penuh" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Emel Pengguna:</label>
                            <!-- <span class="input-group-text"><i class="bi bi-envelope"></i></span> -->
                                <input type="email" class="form-control" id="email" name="email" placeholder="Emel Pengguna" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat:</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Alamat" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone_num" class="form-label">Nombor Telefon:</label>
                                <input type="tel" class="form-control" id="phone_num" name="phone_num" placeholder="Nombor Telefon" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Continue adding the input fields from the registration form -->
                        <div class="mb-3">
                            <label for="universiti" class="form-label">Universiti:</label>
                                <input type="text" class="form-control" id="universiti" name="universiti" placeholder="Universiti" required>
                        </div>

                        <div class="mb-3">
                            <label for="no_Uni" class="form-label">Nombor Telefon Universiti:</label>
                                <input type="phoneNumU" class="form-control" id="phoneNumU" name="phoneNumU" placeholder="Nombor Telefon Universiti" required>
                        </div>

                        <div class="mb-3">
                            <label for="course" class="form-label">Kursus:</label>
                                <input type="course" class="form-control" id="course" name="course" placeholder="Kursus" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Tarikh Mula Latihan Industri:</label>
                                <input type="date" class="form-control" id="dateStart" name="dateStart" placeholder="Tarikh Mula Latihan Industri" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Tarikh Akhir Latihan Industri:</label>
                                <input type="date" class="form-control" id="dateEnd" name="dateEnd" placeholder="Tarikh Akhir Latihan Industri" required>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <form action="mohonLI.php?post_id=<?php echo $post_id;?>" method="post" enctype="multipart/form-data">

                                    <!-- FILE ATTACHMENT FOR RESUME -->
                                    <div class="col-md-6">
                                        <label class="form-label">Resume:</label> <!-- RESUME -->
                                        <div>
                                            <input type="file" name="resumeFile" id="resumeFile">
                                        </div>
                                    </div>

                                    <!-- FILE ATTACHMENT FOR UNIVERSITY LETTER -->
                                    <div class="col-md-6">
                                        <label class="form-label">Surat Universiti:</label> <!-- UNIVERSITY LETTER -->
                                        <div>
                                            <input type="file" name="uniFile" id="uniFile">
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- END OF ROW -->
                        </div>
                        
                    </div> <!-- END OF class="col-md-6" -->

                    <div class="d-flex justify-content-end">
                        <button type="submit" id="hantarSubmit" class="btn btn-primary" style="margin-right:5px;">Hantar</button>
                        <button type="button" id="btnClear" class="btn btn-secondary"><a href="../index.php" style="text-decoration: none; color:white;">Kembali</button>
                    </div>

                <!-- Continue adding any additional input fields from the registration form -->
            </div> <!-- END OF ROW -->
    </div>

            <!-- Include the rest of your form code as it is -->
</form><br>

    </div>
  </div><!-- /.card -->
</div>

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function () {

    // Attach the form submission handling to the "Save" button click event
    $('#hantarSubmit').on('click', function (e) {
        e.preventDefault();
        var form = $('#formMohon'); // Get the form element

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

        if ($('#resumeFile').val().trim() === '') {
            isValid = false;
            $('#resumeFile').after('<span class="error-message" style="color:red">Sila masukkan Lampiran*</span>');
        }

        if ($('#uniFile').val().trim() === '') {
            isValid = false;
            $('#uniFile').after('<span class="error-message" style="color:red">Sila masukkan Lampiran*</span>');
        }

        if (!isValid) {
            return;
        }
        
        else {
            // Proceed with the SweetAlert confirmation
            Swal.fire({
                title: 'Anda pasti mahu simpan?',
                text: 'Permohonan anda akan dihantar!',
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

<style>
    .register-box {
        width: 80%; 
        min-height: 500px; 
        margin: auto; 
        margin-top: 50px; 
    }
</style>

     

</body>
</html>
