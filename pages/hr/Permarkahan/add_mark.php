<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Tambah Permarkahan </title>

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
                            <h1 class="m-0">Tambah Permarkahan </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Tambah Kategori Permarkahan </li>
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
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Kategori Permarkahan</h3>
                                </div>
                                <form class="form-horizontal" action="saveMarkah.php" method="POST">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="category" class="col-sm-2 col-form-label">Keterangan</label>
                                            <div class="col-sm-10">
                                                <!-- Added 'required' attribute -->
                                                <input type="text" class="form-control" id="category" name="category" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDate" class="col-sm-2 col-form-label">Tarikh Kuatkuasa</label>
                                            <div class="col-sm-10">
                                                <!-- Added 'required' attribute -->
                                                <input type="date" class="form-control" id="inputDate" name="inputDate" required>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table" id="criteriaTable">
                                                <thead>
                                                    <tr>
                                                        <th>Bil</th>
                                                        <th>Kriteria</th>
                                                        <th>Markah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><input type="text" class="form-control" name="kriteria[]"></td>
                                                        <td><input type="text" class="form-control" name="markah[]"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button type="button" class="btn btn-success" id="addRow">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="javascript:history.go(-1);" class="btn btn-secondary ml-2 float-right">Kembali</a>
                                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                    </div>
                                </form>
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

    <script>
        $(document).ready(function() {
            // Add Row button functionality
            $("#addRow").on("click", function() {
                var table = $("#criteriaTable tbody");
                var rowCount = table.find("tr").length;

                var newRow = "<tr>" +
                    "<td>" + (rowCount + 1) + "</td>" +
                    "<td><input type='text' class='form-control' name='kriteria[]'></td>" +
                    "<td><input type='text' class='form-control' name='markah[]'></td>" +
                    "</tr>";

                table.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Handling form submission with SweetAlert
            $('form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda Pasti?',
                    text: 'Anda Pasti untuk menyimpan data!',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with form submission using AJAX
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: 'Simpan!',
                                    text: 'Data berjaya disimpan.',
                                    icon: 'success'
                                }).then(() => {
                                    // Optionally, redirect or perform additional actions after saving
                                    window.location.href = 'list_mark.php';
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Ralat!',
                                    text: 'Data tidak berjaya disimpan.',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>