
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?= $sett_apps->nama_aplikasi ?> - <?= $sett_apps->company ?> </title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
		<!-- example 2 - using auto margins -->
		<nav class="navbar navbar-expand-md navbar-light bg-light">
		    <div class="container-fluid">
		    	<a class="navbar-brand" href="#">
		      		<img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24">
		    	</a>
		        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
		            <ul class="navbar-nav ms-auto">
		                <li class="nav-item">
		                	Welcome <?php echo $this->session->userdata('userid') ?>
			            </li>
			            <li class="nav-item">
			                <a href="<?php echo base_url().'auth/logout' ?>"><i class="fas fa-sign-out-alt"></i></a>
			            </li>
		            </ul>
		        </div>
		        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".dual-collapse2">
                	<span class="navbar-toggler-icon"></span>
            	</button>
		    </div>
		</nav>
		<div class="container-fluid">
			<div class="container-sm mt-10">
				<div class="body">

					
				</div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
		<script>

			function getAllKuesioner() {
				$.ajax({
	                type: "GET",
	                url: "<?php echo base_url() ?>kuesioner/get_all_kuesioner",
	                success: function(data){
	                    $('.body').html(data)
	                },
	                error: function(e) {
	                    alert('Terjadi kesalahan: X01')
	                }
	            });
			}

			$(document).ready(function() {
				getAllKuesioner()
			})


			$(document).on('click','.tambah_data', function() {
                $('.btn-loading').click()
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>kuesioner/create",
                    success: function(data){
                        $('.body').html(data);
                    },
                    error: function(error) {
                        Swal.fire({
							icon: 'error',
							title: "Oops!",
							text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi, hubungi IT'
                        })
                    }
                });
            })

            $(document).on('click','.list-data', function(e) {
                e.preventDefault()
                getAllKuesioner()
            })


		</script>
	</body>

</html>