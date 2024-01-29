<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      

      <!-- User Dropdown Menu -->
	  
	  <li class="nav-item dropdown">
	  <a class="nav-link" data-toggle="dropdown" href="#">
		<i class="far fa-user"></i>
	  </a>
	  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right custom-dropdown">
		<div class="dropdown-header">
		  <div class="profile-info">
      <?php
			  $sql = "SELECT * FROM student WHERE student_id = '" . $_SESSION['id'] . "'";
			  $result = mysqli_query($conn, $sql);

			  if ($result) {
				$row = mysqli_fetch_assoc($result);
				if ($row) {
          $profile_pic = $row["profile_pic"];
          $student_name = $row['name'];
				} else {
				  echo "Name not found";
				}
			  } else {
				echo "Error in SQL query: " . mysqli_error($conn);
			  }
			  ?>

          <?php if(isset($profile_pic) && !empty($profile_pic)) { ?>
              <img src="../upload/profile_pic/<?php echo $profile_pic; ?>" alt="Profile Image">
          <?php } else { ?>
              <img src="../../assets/img/profile.png" alt="Default Profile Picture" class="img-fluid img-thumbnail" style="max-width: 160px;">
          <?php } ?>
			
          <span class="name"><?php echo strtoupper($student_name); ?></span>

			</span>
		  </div>
		</div>
		<div class="dropdown-divider"></div>
		<a href="profile_student.php?page=profile" class="dropdown-item">
		  <i class="far fa-id-badge"></i>
		  Profil
		</a>
		<div class="dropdown-divider"></div>
		<a href="../../index.php" class="dropdown-item">
		  <i class="fas fa-sign-out-alt"></i>
		  Log Keluar
		</a>
	  </div>
	</li>
	
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <!-- <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
