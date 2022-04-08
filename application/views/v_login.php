<!--

=========================================================
* Now UI Kit - v1.3.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-kit
* Copyright 2019 Creative Tim (http://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/now-ui-kit/blob/master/LICENSE.md)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>/assets/admin/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/admin/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title><?= $sett_apps->nama_aplikasi ?> - <?= $sett_apps->company ?> </title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />


  <!-- Extra details for Live View on GitHub Pages -->

  <!--  Social tags      -->
  <meta name="keywords" content="kuesioner pi">
  <meta name="description" content="Kuesioner PT Pupuk Indonesia Management System.">


  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Kuesioner App PI">
  <meta itemprop="description" content="Aplikasi Manajemen Sistem Kuesioner PT. Pupuk Indonesia.">

  <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/56/opt_nudp_thumbnail.jpg">


  <!-- Twitter Card data -->
  <meta name="twitter:card" content="product">
  <meta name="twitter:site" content="@pupukindonesia">
  <meta name="twitter:title" content="Kuesioner Management System PT Pupuk Indonesia">

  <meta name="twitter:description" content="Aplikasi Manajemen Sistem Kuesioner PT. Pupuk Indonesia.">
  <meta name="twitter:creator" content="@rachmad35">
  <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/56/opt_nudp_thumbnail.jpg">


  <!-- Open Graph data -->
  <meta property="og:title" content="Kuesioner Management System PI" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?php echo base_url() ?>" />
  <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/56/opt_nudp_thumbnail.jpg" />
  <meta property="og:description" content="Aplikasi Manajemen Sistem Kuesioner PT. Pupuk Indonesia" />
  <meta property="og:site_name" content="Kuesioner Management System PI" />




  <!--     Fonts and icons     -->

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Files -->

  <link href="<?php echo base_url() ?>/assets/admin/css/bootstrap.min.css" rel="stylesheet" />




  <link href="<?php echo base_url() ?>/assets/admin/css/now-ui-kit.min.css?v=1.3.0" rel="stylesheet" />

  <style>
    .bg-cool {
      background-image: url(<?php echo base_url() ?>assets/admin/img/login.jpg);
      animation: zoomout 15s ease-out;
    }

    /* create animation */
    @keyframes zoomout {
      0% {
        transform: scale(1.3);
      }
      10% {
        transform: scale(1.14);
      }
      100% {
        transform: scale(1);
      }
    }



  </style>

</head>

<body class="login-page sidebar-collapse">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
    <div class="container">

      <div class="dropdown button-dropdown">
        <a href="#pablo" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
          <span class="button-bar"></span>
          <span class="button-bar"></span>
          <span class="button-bar"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-header">Dropdown header</a>
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">One more separated link</a>
        </div>
      </div>

    </div>
  </nav>
  <!-- End Navbar -->

  <div class="page-header clear-filter" style="background: linear-gradient(0deg,rgba(44,44,44,.2),rgb(255 255 255 / 71%));">
    <div class="page-header-image bg-cool"></div>
    <div class="content">
      <div class="container">
        <?php
        if ($this->session->userdata('success')) {
        ?>
          <div class="flash-data" data-flashdata="<?= $this->session->userdata('success'); ?>"></div>
        <?php
        }

        if ($this->session->userdata('failed')) {
        ?>
          <div class="flash-data2" data-flashdata2="<?= $this->session->userdata('failed'); ?>"></div>
        <?php
        }
        ?>
        <div class="col-md-4 ml-auto mr-auto">
          <div class="card card-login card-plain">
            <form class="form" action="<?= site_url('auth/process') ?>" method="post">
              <div class="card-header text-center">
                <img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" alt="" style="transform: scale(0.7);">
              </div>
              <div class="card-body">
                <div class="input-group no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="now-ui-icons users_circle-08"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="username" placeholder="username">
                </div>

                <div class="input-group no-border input-lg">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="now-ui-icons text_caps-small"></i>
                    </span>
                  </div>
                  <input type="password" name="password" placeholder="password" class="form-control" />
                </div>
              </div>
              <div class="card-footer text-center">
                <button class="btn btn-primary btn-round btn-lg btn-block" type="submit" name="login">Sign In</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer">

    <div class=" container ">
      <div class="copyright" id="copyright">
        &copy; <script>
          document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
        </script>, Create with <3 by <a href="https://www.rach-nh.xyz" target="_blank">RNH</a>.
      </div>
    </div>



  </footer>

  </div>


















  <!--   Core JS Files   -->
  <script src="<?php echo base_url() ?>/assets/admin/js/core/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url() ?>/assets/admin/js/core/popper.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url() ?>/assets/admin/js/core/bootstrap.min.js" type="text/javascript"></script>

  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?php echo base_url() ?>/assets/admin/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
  <script src="<?php echo base_url() ?>assets/js/dataflash.js"></script>

</body>

</html>