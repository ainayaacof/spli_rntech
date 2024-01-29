<?php
// Start or resume the session
session_start();

include "../conn.php";
$_POST['id'] = $_SESSION['id'];
$id = $_POST['id'];
?>
<?php

//get data from the table
$i = 1;
$student_id = $_REQUEST['student_id'];
$week = $_REQUEST['unique_week'];
$query = "SELECT * FROM task_activity WHERE student_id = '" . $student_id . "' and week = '" . $week . "' ";
$result = $conn->query($query);
$data = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LAPORAN PRESTASI PELAJAR</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/alt/splicss.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <section class="content">
    <div style="margin:20px">
      <div class="card-header">
        <h3 style="text-align:center">Laporan Prestasi Pelajar</h3>
        <h4 style="text-align:center">Tugasan Pelajar : Minggu <?php echo $week; ?></h4>
      </div>
      <p></p>
      <h4>Maklumat Pelajar</h4>
      <!-- card -->
      <?php
      $student_id = $_REQUEST['student_id'];
      $query = "SELECT * FROM student WHERE student_id = '" . $student_id . "'";
      $result = mysqli_query($conn, $query);
      $num_rows = mysqli_num_rows($result);

      // get data from spli_db (supervisor table)
      while ($row = mysqli_fetch_array($result)) {
      ?>
        <table>
          <tr>
            <div class="form-group">
              <td style="width:200px"><label>Nama Pelajar</label></td>
              <td>: <?php echo  $row["name"]; ?></td>
            </div>
          </tr>
          <tr>
            <div class="form-group">
              <td style="width:200px"><label>Nombor Telefon</label></td>
              <td>: <?php echo  $row["phone_num"]; ?></td>
            </div>
          </tr>
          <tr>
            <div class="form-group">
              <td style="width:200px"><label>Email</label></td>
              <td>: <?php echo  $row["email"]; ?></td>
            </div>
          </tr>
          <tr>
            <div class="form-group">
              <td style="width:200px"><label>Alamat</label></td>
              <td>: <?php echo  $row["address"];
                  } ?></td>
            </div>
          </tr>
        </table>

        <p></p>
        <p></p>
        <div class="card-body">
          <table border="solid">
            <thead>
              <tr style="text-align:center">
                <th style="width:50px">Bil.</th>
                <th style="width:400px">Tugasan</th>
                <th style="width:170px">Tarikh</th>
                <th style="width:300px">Maklumbalas</th>
                <!-- Add more columns as needed -->
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $row) : ?>
                <tr>
                  <td>
                    <center><?php echo $i++; ?></center>
                  </td>
                  <td style="padding-left:30px"><?php $description = $row["task_description"];
                                                //split
                                                $sentences = preg_split('/(?=[0-9]\.)/', $description);
                                                foreach ($sentences as $sentence) {
                                                  echo $sentence . "<p>";
                                                } ?></td>
                  <td>
                    <center><?php echo $row['task_date']; ?></center>
                  </td>
                  <td style="padding-left:30px"><?php echo $row['comment']; ?></td>
                  <!-- Add more cells as needed -->
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <p></p>

        <label>Tandatangan Penyelia:</label>
        <br>
        <br><b>____________________________</b><br><br>
        <?php
        $query = "SELECT * FROM supervisor WHERE id = '" . $id . "'";
        $result = mysqli_query($conn, $query);
        $num_rows = mysqli_num_rows($result);

        // get data from spli_db (supervisor table)
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <table>
            <tr>
              <td style="width:200px"><label>Nama Penyelia</label></td>
              <td>: <?php echo $row['name']; ?></td>
            </tr>
            <tr>
              <td style="width:200px"><label>Jawatan</label></td>
              <td>: <?php echo $row['position'];
                  } ?></td>
            </tr>
            <tr>
              <td style="width:200px"><label>Nama Syarikat</label></td>
              <td>: RN Technologies Sdn. Bhd.</td>
            </tr>
          </table>
    </div>


    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script>
      // Use html2pdf to generate PDF
      var element = document.body; // Choose the element that you want to print as PDF
      html2pdf(element);
    </script>

  </section>
</body>

</html>