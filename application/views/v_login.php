
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?= $sett_apps->nama_aplikasi ?> - <?= $sett_apps->company ?> </title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
		<style type="text/css">
				
			.login {
			  min-height: 100vh;
			}

			.bg-image {
			  background-image: url('https://source.unsplash.com/WEQbe2jBg40/600x1200');
			  background-size: cover;
			  background-position: center;
			}

			.login-heading {
			  font-weight: 300;
			}

			.btn-login {
			  font-size: 0.9rem;
			  letter-spacing: 0.05rem;
			  padding: 0.75rem 1rem;
			}


		</style>
	</head>
	<body>
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
		<div class="container-fluid ps-md-0">
		  <div class="row g-0">
		    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image" style="position: relative;">
		    	
		    </div>
		    <div class="col-md-8 col-lg-6">
		      <div class="login d-flex align-items-center py-5">
		        <div class="container">
		          <div class="row">
		            <div class="col-md-9 col-lg-8 mx-auto">
		            	<div class="mb-4">
		            		<img src="<?php echo base_url().'assets/images/logo_perusahaan.png' ?>" style="width: 140px;">
		            	</div>
						<h3 class="login-heading mb-4">Selamat Datang</h3>

						<!-- Sign In Form -->
						<form action="<?=site_url('auth/process')?>" method="post">
						<div class="form-floating mb-3">
						  <input type="text" name="username" class="form-control" id="floatingInput" placeholder="username">
						  <label for="floatingInput">Username</label>
						</div>
						<div class="form-floating mb-3">
						  <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
						  <label for="floatingPassword">Password</label>
						</div>

						<div class="d-grid">
						  <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit" name="login">Sign in</button>
						</div>

		              </form>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
	<script src="<?php echo base_url() ?>assets/js/dataflash.js"></script>
	</body>
</html>