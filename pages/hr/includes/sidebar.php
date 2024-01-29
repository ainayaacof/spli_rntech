<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <img src="/splirntech/assets/img/corporation.png" alt="Icon" class="logo-image icon">
    <img src="/splirntech/assets/img/rntech.png" alt="RNTech Logo" class="logo-image">
  </a>


  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="/splirntech/pages/hr/dashboard/dashboard_hr.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Laman Utama
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/splirntech/pages/hr/SenaraiPelajar/list_student.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Senarai Pelajar
            </p>
          </a>


        </li>

        <li class="nav-item">
          <a href="/splirntech/pages/hr/SenaraiPermohonan/list_apply.php" class="nav-link">
            <i class="nav-icon fas fa-clipboard"></i>
            <p>
              Senarai Permohonan
            </p>
            <?php
            $note = mysqli_query($conn, "SELECT * FROM `application_intern` WHERE `status` = 'Baru'");
            $note1 = mysqli_num_rows($note);
            $myrow1 = mysqli_fetch_array($note);
            if ($note1 > 0) {
            ?>
              &nbsp;<span class="badge bg-warning text-dark"><?php print $note1; ?></span>
            <?php } else {
            } ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="/splirntech/pages/hr/PermohonanCuti/list_mc.php" class="nav-link">
            <i class="nav-icon fas fa-suitcase"></i>
            <p>
              Permohonan Cuti
            </p>
            <?php
            $note = mysqli_query($conn, "SELECT * FROM `leave_app` WHERE `status` = 'Baru'");
            $note1 = mysqli_num_rows($note);
            $myrow1 = mysqli_fetch_array($note);
            if ($note1 > 0) {
            ?>
              &nbsp;<span class="badge bg-warning text-dark"><?php print $note1; ?></span>
            <?php } else {
            } ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="/splirntech/pages/hr/Aduan/aduan.php" class="nav-link">
            <i class="nav-icon far fa-comments"></i>
            <p>
              Aduan Maklum Balas
            </p>
            <?php
            $note = mysqli_query($conn, "SELECT * FROM `feedback` WHERE `status` = 'Baru'");
            $note1 = mysqli_num_rows($note);
            $myrow1 = mysqli_fetch_array($note);
            if ($note1 > 0) {
            ?>
              &nbsp;<span class="badge bg-warning text-dark"><?php print $note1; ?></span>
            <?php } else {
            } ?>
          </a>
        </li>

        <li class="nav-item">
          <a href="/splirntech/pages/hr/Hebahan/hebahan_list.php" class="nav-link">
            <i class="nav-icon fas fa-bullhorn"></i>
            <p>
              Hebahan Tawaran
            </p>
          </a>
        </li>



        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs	"></i>
            <p>
              Tetapan
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/splirntech/pages/hr/Profil/profile.php" class="nav-link">
                <i class="far fa-circle nav-icon" style="color: yellow;"></i>
                <p>Profil</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/splirntech/pages/hr/Pengguna/list_user.php" class="nav-link">
                <i class="far fa-circle nav-icon" style="color: yellow;"></i>
                <p>Pengguna</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/splirntech/pages/hr/Permarkahan/list_mark.php" class="nav-link">
                <i class="far fa-circle nav-icon" style="color: yellow;"></i>
                <p>Permarkahan </p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>