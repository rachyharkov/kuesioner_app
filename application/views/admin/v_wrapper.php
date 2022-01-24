<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>assets/admin/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/admin/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title><?= $sett_apps->nama_aplikasi ?> - <?= $sett_apps->company ?> </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>assets/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
  <link href="<?php echo base_url() ?>assets/admin/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url() ?>assets/admin/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

  <script src="<?php echo base_url().'assets/js/jquery-ui/jquery-ui.min.js' ?>"></script>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="<?php echo base_url().'dashboard' ?>" class="simple-text logo-mini">
          <i class="now-ui-icons business_chart-pie-36"></i>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Kuesioner Sys
        </a>
      </div>
      <div>
      	Welcome <?php echo $this->session->userdata('userid') ?>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">

        	<?php
        		$arrmenu = [
        			0 => [
        				'nama_menu' => 'Dashboard',
        				'url' => 'dashboard',
        				'icon' => 'now-ui-icons design_app' 
        			],
        			1 => [
        				'nama_menu' => 'Kuesioner',
        				'url' => 'kuesioner',
        				'icon' => 'now-ui-icons education_atom' 
        			],
        			2 => [
        				'nama_menu' => 'Laporan',
        				'url' => 'laporan',
        				'icon' => 'now-ui-icons location_map-big' 
        			],
        			3 => [
        				'nama_menu' => 'Laporan',
        				'url' => 'profil',
        				'icon' => 'now-ui-icons users_single-02' 
        			],

        		];

        		foreach ($arrmenu as $key => $value) {
        			?>
        			<li class="<?php echo $this->uri->segment(1) == $value['url'] ? 'active' : '' ?>">
			            <a href="<?php echo base_url().$value['url'] ?>">
							<i class="<?php echo $value['icon'] ?>"></i>
							<p><?php echo $value['nama_menu'] ?></p>
			            </a>
			        </li>
        			<?php
        		}
        	?>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo"><?php echo $menu ?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                  </div>
                </div>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons media-2_sound-wave"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="now-ui-icons location_world"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Help</a>
                  <a class="dropdown-item" href="#">History Log</a>
                  <a class="dropdown-item" href="<?php echo base_url().'auth/logout' ?>">Logout</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
  	<?php
  		if ($this->uri->segment(1) == 'dashboard') {
  			?>
  			<div class="panel-header panel-header-lg">
    			<canvas id="bigDashboardChart"></canvas>
  			</div>
  			<?php
  		} else {
  			?>
      			<div class="panel-header panel-header-sm"></div>
  			<?php
  		}
  	?>

      <div class="content">

      	<?php echo $contentnya ?>
      
      </div>

      <footer class="footer">
        <div class=" container-fluid ">
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, LSP P2 Pupuk Indonensia | <a href="https://www.rach-nh.xyz" target="_blank">RNH</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="<?php echo base_url() ?>assets/admin/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/core/popper.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/core/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="<?php echo base_url() ?>assets/admin/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url() ?>assets/admin/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url() ?>assets/admin/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url() ?>assets/admin/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });


  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
	<script src="<?php echo base_url() ?>assets/js/dataflash.js"></script>
</body>

</html>