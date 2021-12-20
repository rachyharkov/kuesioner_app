
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
			<div class="container-sm" style="max-width: 678px;">
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

            //tambah dan kurangi dimensi//

            $(document).on('click','#add_dimensi',function() {
		        var x = $('.baris_dimensi').length
		        $('#dimensi_table').append(`<tr id="row` + x +
		            `" class="baris_dimensi"><td><input type="text" name="dimensi[]" placeholder="Dimensi" class="form-control" required="" /><table class="tabel_indicator_row"></table><span style="font-size: 11px;">Dimensi memiliki indikator? <a href="#" class="add_indicator">Tambah Indikator</a></span></td><td><button type="button" name="remove" id="` + x + `" class="btn btn-danger btn_remove_dimensi">X</button></td></tr>`)
		    });

		    $(document).on('click', '.btn_remove_dimensi', function() {
		      var button_id = $(this).attr("id")
		      $('.baris_dimensi#row' + button_id + '').remove()
		    });

		    $(document).on('click','.add_indicator', function() {
		      var whatrow = $(this).parents('tr').attr('id')

		      var tabelindikator = $('#' + whatrow + '.baris_dimensi').find('.tabel_indicator_row')
		      var indicatorinputelementlength = tabelindikator.find('tr').length

		      tabelindikator.append(`
		        <tr id="indicator${whatrow}ke${indicatorinputelementlength}">
		          <td><input type="text" name="indikator_dimensi_${whatrow}[]" placeholder="Indikator" class="form-control" required="" /></td>
		          <td><a class="remove_indicator" id="${whatrow}ke${indicatorinputelementlength}"><i class="fas fa-times"></i></a></td>
		        </tr>
		        `)

		      console.log(`indicator${whatrow}ke${indicatorinputelementlength} added`)
		    })

		    $(document).on('click','.remove_indicator', function() {
		      var button_id = $(this).attr("id")
		      console.log(button_id + 'removed')
		      $('#indicator' + button_id + '').remove()
		    })

		    //tambah dan kurangi dimensi end here

		    //tambah dna kurangi kategori jawaban dan pilihan

		    $(document).on('click','#add_kategori_respon',function() {
		        var x = $('.baris_kategori_respon').length
		        $('#kategori_response_table').append(`<tr id="row` + x +
		            `" class="baris_kategori_respon"><td><input type="text" name="kategori_respon[]" placeholder="kategori_respon" class="form-control" required="" /><table class="tabel_pilihan_row"></table><span style="font-size: 11px;">Memiliki pilihan? <a href="#" class="add_pilihan">Tambah Pilihan</a></span></td><td><button type="button" name="remove" id="` + x + `" class="btn btn-danger btn_remove_kategori_respon">X</button></td></tr>`)
		    });

		    $(document).on('click', '.btn_remove_kategori_respon', function() {
		      var button_id = $(this).attr("id")
		      $('.baris_kategori_respon#row' + button_id + '').remove()
		    });

		    $(document).on('click','.add_pilihan', function() {
		      var whatrow = $(this).parents('tr').attr('id')

		      var tabelpilihan = $('#' + whatrow + '.baris_kategori_respon').find('.tabel_pilihan_row')
		      var pilihaninputelementlength = tabelpilihan.find('tr').length

		      console.log(tabelpilihan)
		      tabelpilihan.append(`
		        <tr id="kategori${whatrow}pilihanke${pilihaninputelementlength}">
		          <td><input type="text" name="pilihan_kategori_respon${whatrow}[]" placeholder="pilihan" class="form-control" required="" /></td>
		          <td><a class="remove_pilihan" id="${whatrow}pilihanke${pilihaninputelementlength}"><i class="fas fa-times"></i></a></td>
		        </tr>
		        `)

		      console.log(`kategori${whatrow}pilihanke${pilihaninputelementlength} added`)
		    })

		    $(document).on('click','.remove_pilihan', function() {
		      var button_id = $(this).attr("id")
		      console.log(button_id + 'removed')
		      $('#kategori' + button_id + '').remove()
		    })
		    //end


		    $(document).on('submit','#form_create_kuesioner', function(e) {

		        e.preventDefault()

		        var btnselected = $(document.activeElement)

		        btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

	        	Swal.fire({
		          title: 'Konfirmasi Tindakan',
		          text: "Yakin disimpan?",
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Yes'
		        }).then((result) => {
					if (result.isConfirmed) {
						dataString = $("#form_create_kuesioner").serialize();
						$.ajax({
						    type: "POST",
						    url: "<?php echo base_url().'Kuesioner/create_action'?>",
						    data: dataString,
						    success: function(data){
						        Swal.fire({
						          icon: 'success',
						          title: "Sukses",
						          text: 'Berhasil disimpan'
						        })
						        getAllKuesioner()
						        btnselected.html('Selesai').removeClass('disabled').removeAttr('disabled')
						    },
						    error: function(error) {
						        Swal.fire({
						          icon: 'error',
						          title: "Oops!",
						          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
						        })
						        btnselected.html('Selesai').removeClass('disabled').removeAttr('disabled')
						    }
						});
					} else {
						btnselected.html('Selesai').removeClass('disabled').removeAttr('disabled')
					}
		    	})
		    })

		    $(document).on('click','.link_kelola_kuesioner',function() {
		    	var id_diskusi = $(this).attr('id')
		    	$.ajax({
				    type: "GET",
				    url: "<?php echo base_url().'diskusi/get_all_diskusi_by_kuesioner'?>" + "/" + id_diskusi,
				    success: function(data){
				        $('.body').html(data)
				    },
				    error: function(error) {
				        Swal.fire({
				          icon: 'error',
				          title: "Oops!",
				          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
				        })
				    }
				});
		    })

		    $(document).on('click','.link_delete_kuesioner', function(e) {
		    	e.preventDefault()

		    	var id_diskusi = $(this).attr('id')

		        var btnselected = $(document.activeElement)

		        btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

	        	Swal.fire({
		          title: 'Konfirmasi Tindakan',
		          text: "Yakin Menghapus kuesioner id: " + id_diskusi,
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Yes'
		        }).then((result) => {
					if (result.isConfirmed) {

					} else {
						btnselected.html('<i class="fas fa-trash-alt"></i>').removeClass('disabled').removeAttr('disabled')
					}
				})
		    })

		</script>
	</body>

</html>