<?php
session_start();

include "../../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPLI RN TECH | Senarai Pelajar</title>

    <?php include "../includes/styles.php"; ?>
    <link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
    <script src="sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



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
                            <h1 class="m-0">Tambah Pengguna</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard_hr.php">Laman Utama</a></li>
                                <li class="breadcrumb-item active">Tambah Pengguna </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="card card-navy">
                                    <div class="card-header">
                                        <h3 class="card-title">Tambah Pengguna Sistem</h3>
                                    </div>
                                    <form action="save_user.php" method="POST" id="userForm">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="name">Nama :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone_num">No. Telefon :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="phone_num" name="phone_num" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Katalaluan :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    </div>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Kategori :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-list"></i></span>
                                                    </div>
                                                    <select class="form-control" id="category" name="category">
                                                        <option value="#">-- Pilih Kategori Pengguna --</option>
                                                        <option value="Pelajar">Pelajar</option>
                                                        <option value="Penyelia">Penyelia</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group" id="alamatField" style="display: none;">
                                                <label>Alamat :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="address" placeholder="address">
                                                </div>
                                            </div>

                                            <div class="form-group" id="penyeliaField" style="display: none;">
                                                <label>Penyelia:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                                    </div>
                                                    <select class="form-control" name="sv_id">
                                                        <option value="#">-- Pilih Penyelia --</option>
                                                        <?php
                                                        $sql = "SELECT sv_id, name FROM supervisor";
                                                        $result = $conn->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<option value='" . $row['sv_id'] . "'>" . $row['name'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group" id="jawatanField" style="display: none;">
                                                <label>Jawatan :</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="position" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-secondary mr-2" onclick="history.go(-1)">Kembali</button>
                                                <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
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
    <script type="text/javascript" src="../../../plugins/sweetalert2/sweetalert2.min.js"></script>


    <script>
        document.getElementById('category').addEventListener('change', function() {
            var category = this.value;
            var jawatanField = document.getElementById('jawatanField');
            var alamatField = document.getElementById('alamatField');
            var penyeliaField = document.getElementById('penyeliaField');


            // Hide both fields by default
            jawatanField.style.display = 'none';
            alamatField.style.display = 'none';
            penyeliaField.style.display = 'none';

            // Show the relevant field based on the selected category
            if (category === 'Pelajar') {
                alamatField.style.display = 'block'; // Show Alamat field for Pelajar
                penyeliaField.style.display = 'block'; // Show Alamat field for Pelajar

            } else if (category === 'Penyelia') {
                jawatanField.style.display = 'block'; // Show Jawatan field for Penyelia
            }
        });

        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);

            fetch('save_user.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    Swal.fire({
                        title: 'Data Berjaya Disimpan!',
                        icon: 'success'
                    }).then(function() {
                        window.location = 'list_user.php';
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

</body>

</html>