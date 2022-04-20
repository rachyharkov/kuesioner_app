<style>
	
	table {
    	counter-reset: tableCount;     
	}
	.counterCell:before {              
	    content: counter(tableCount); 
	    counter-increment: tableCount; 
	}

	#list-of-diskusi {
		padding: 0;
	}

	#list-of-diskusi li {
		list-style: none;
	}

	.handle {
		color: gray;
	    cursor: grab;
	    width: 100%;
	    height: 21px;
	    text-align: center;
	    margin-top: -12px;
	    margin-bottom: 12px;
	}

	.indicator-view-editing {
		transition: 300ms ease-in-out;
		background-color: #F96332;
	    height: 100%;
	    position: absolute;
	    top: 0;
	    left: 0;
	    width: 0;
	    border-top-right-radius: 5px;
	    border-bottom-right-radius: 5px;
	}

	.baris-diskusi .card:focus-within .indicator-view-editing {
		transition: 300ms ease-in-out;
		width: 4px;
	}

	/* create animation bounce */
	.bounce {
		animation: bounce 1s infinite;
	}

	@keyframes bounce {
		0% {
			transform: scale(1.4);
		}
		30% {
			transform: scale(1);
		}
		60% {
			transform: scale(1.4);
		}
		100% {
			transform: scale(1);
		}
	}

</style>

<?php
	$data_respon = json_decode($data_kuesioner->kategori_respon, TRUE);
	$data_dimensi = json_decode($data_kuesioner->dimensi, TRUE);
?>

	<?php
	$jawabanresponlist = [];

	foreach ($data_respon as $v) {
		foreach ($v['respon_list'] as $y) {
			$jawabanresponlist[] = $y;
		}
	}

	?>
<form id="form_diskusi_list" enctype="multipart/form-data">
	<div class="row">
	  	<div class="col-12" style="max-width: 640px; margin: auto;">
		    <div class="card">
				<div class="card-header header-kuesioner">
					<?php echo $aksi ?> Kuesioner

					<input class="form-control mt-4" style="font-size: 24px;" type="text" name="judul_kuesioner" id="judul_kuesioner" value="<?php echo $data_kuesioner->judul_kuesioner ?>">
					<textarea class="form-control mt-3" rows="4" id="deskripsi_kuesioner" name="deskripsi_kuesioner"><?php echo $data_kuesioner->deskripsi_kuesioner ?></textarea>
				</div>
				<div class="card-body">
					<div class="alertny">
					<?php
						$action = 'form_diskusi_edit';

						if (!$list_diskusi) {
							?>							
							<div class="alert alert-danger" style="margin-top: 1rem;">
								<b>Perhatian</b> tidak ada diskusi yang dibahas ppada kuesioner ini
							</div>
							<?php
							$action = 'form_diskusi_new';
						}
					?>
					</div>
					<input type="hidden" id="id_kuesioner" name="id_kuesioner" value="<?php echo $data_kuesioner->id_kuesioner ?>">
				</div>
			</div>

			<ul id="list-of-diskusi">
			    <?php

					if ($list_diskusi) {
						foreach ($list_diskusi as $ld) {
							?>

							<li id="<?php echo $ld->urutan ?>" class="baris-diskusi">
								<input type="hidden" class="id_diskusi" name="id_diskusi" value="<?php echo $ld->id ?>"/>
								<input type="hidden" class="urutan-diskusi" name="urutan-diskusi" value="<?php echo $ld->urutan ?>"/>
								<div class="card">
									<div class="indicator-view-editing"></div>
									<div class="card-body" style="position: relative;">
										<div class="handle"><i class="fas fa-ellipsis-h"></i></div>
										<div class="row">
											<div class="col-7">
												<textarea class="form-control isidiskusi" style="width: 100%;" rows="5" name="isidiskusi[]" ><?php echo $ld->isi_diskusi ?></textarea>
											</div>
											<div class="col-5 row">
												<div class="col-12">
													<input type="hidden" name="id_diskusi[]" value=""/>
													<select name="dimensidiskusi[]" class="form-control dimensidiskusi">
														<option>- pilih dimensi -</option>
														<?php
														foreach($data_dimensi as $dd) {
															?>
															<option value="<?php echo $dd['name'] ?>" <?php echo $ld->dimensi == $dd['name'] ? 'selected' : ''; ?>><?php echo $dd['name'] ?></option>
															<?php
														}
														?>
													</select>
												</div>
												<div class="col-12">
													<select name="indikatordiskusi[]" class="form-control indikatordiskusi">
														<?php
														foreach($data_dimensi as $dd) {
															if ($dd['name'] == $ld->dimensi) {
																$classnyak->get_indikator($data_kuesioner->id_kuesioner, $dd['name'], $ld->indikator);
															}
														}
														?>
													</select>	
												</div>
											</div>
										</div>
										<button type="button" class="btn btn-danger btn-delete-diskusi" style="font-size: 10px;padding: 5px;"><i class="fas fa-trash-alt"></i></button>
									</div>
								</div>
							</li>
							<?php	
						}
					}

					?>
			</ul>			
		</div>
		<div class="col-12" style="max-width: 640px; margin: auto;">
			<div class="btn-group" role="group" aria-label="Basic example" style="position: fixed;bottom: 1rem;right: 1rem;">
				<a href="<?php echo base_url().'kuesioner' ?>" class="btn btn-secondary" ><i class="fas fa-chevron-left fa-fw"></i></a>
				<a href="<?php echo base_url().'survey?id='.encrypt_url($data_kuesioner->id_kuesioner) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-warning" ><i class="fas fa-eye fa-fw"></i></a>
				<button type="button" class="btn btn-primary btn-tambah-diskusi" data-action="add" ><i class="fas fa-plus"></i></button>
				<button type="button" class="btn btn-success btn-save"><i class="fas fa-save"></i></button>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">

	function save_all() {

		$('.btn-save').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

		var id_kuesioner = $('#id_kuesioner').val()

		/* array literal */
		var aData = [];

		/* object constructur */
		function Diskusi(id_diskusi,id_kuesioner, urutan, dimensi, indikator, isi_diskusi) {
			this.id_diskusi = id_diskusi
			this.id_kuesioner = id_kuesioner
			this.urutan = urutan
			this.dimensi = dimensi
			this.indikator = indikator
			this.isi_diskusi = isi_diskusi
		  // this.diskusi = function() {
		  //   // return (this.id_diskusi + " " + this.urutan);
		  //   return (`${this.id_diskusi} ${this.urutan}`); // es6 template string
		  // };
		}

		/* store object into array */
		$('#list-of-diskusi li').each( function(e) {

			var id_diskusi = $(this).find('.id_diskusi').val()
			var urutan = $(this).index() + 1
			var dimensi = $(this).find('.dimensidiskusi').val()
			var indikator = $(this).find('.indikatordiskusi').val()
			var isi_diskusi = $(this).find('textarea.isidiskusi').val()

			//add each li position to the array...
			// the +1 is for make it start from 1 instead of 0
			aData.push(new Diskusi(id_diskusi, id_kuesioner, urutan, dimensi, indikator, isi_diskusi));
		});
		/* loop array */

		/* convert array of object into string json */
		var jsonString = JSON.stringify(aData);

		console.log(jsonString)

		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url().'diskusi/save_all_diskusi' ?>",
		    data: {
		    	'id_kuesioner': id_kuesioner,
		    	'jsonString': jsonString
		    },
		    success: function(data){
		    	var dt = JSON.parse(data)

		    	if (dt.response == 'ok') {
					$('.btn-save').prop('disabled', false).html('<i class="fas fa-save"></i>');
					// animate .btn-save to bounce
					$('.btn-save').addClass('animated bounce');
					setTimeout(function(){
						$('.btn-save').removeClass('animated bounce');
					}, 1000);

		    	}
		    },
		    error: function(error) {
		        Swal.fire({
		          icon: 'error',
		          title: "Oops!",
		          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
		        })
		    }
		});
	}

	function sortNewincrement() {
		$('.baris-diskusi').each(function() {

			var id = $(this).attr('id')
			// alert(id)
			console.log($(this).find('input.urutan-diskusi').val(id))
		})
	}

	$("#list-of-diskusi").sortable({
		handle: '.handle',
    	cursor: 'grabbing',
    	update: function(event, ui) {

    		save_all()
        }
	})

	function check_diskusi_kuesioner(){

		const banyaknya = $('.baris-diskusi').length

		if (banyaknya >= 1) {
			$('.alertny').html('')
		} else {
			$('.alertny').html(`
				<div class="alert alert-danger" style="margin-top: 1rem;">
					<b>Perhatian</b> tidak ada diskusi yang dibahas ppada kuesioner ini
				</div>
				`)
		}
	}



	$('.baris-diskusi').on('focus',function() {
		$(this).find('.indicator-view-editing').css('width','4px')
	})

	$('.btn-tambah-diskusi').on('click',function(e) {
		e.preventDefault()

		var availablebaris = $('.baris-diskusi').length

		var action = $(this).attr('data-action')

		var count = availablebaris + 1

		var urutan = count
		var id_kuesioner = $('#id_kuesioner').val()
		$.ajax({
            type: "POST",
            url: "<?php echo base_url().'Kuesioner/auto_save'?>",
            data: {
            	id_kuesioner: id_kuesioner,
                urutan: urutan,
                action: action
            },
            success: function(data){
                var dt = JSON.parse(data)
                   
                let id_diskusi

                if (dt.response == 'ok') {
                    
                    id_diskusi = dt.id_diskusi
                    
                    Toast.fire({
                      icon: 'success',
                      title: 'Auto Save berhasil'
                    })

					const html = `
						<li id="${count}" class="baris-diskusi">
							<input type="hidden" class="id_diskusi" name="id_diskusi" value="${id_diskusi}"/>
							<input type="hidden" class="urutan-diskusi" name="urutan-diskusi" value="${count}"/>
							<div class="card">
								<div class="indicator-view-editing"></div>
								<div class="card-body" style="position: relative;">
									<div class="handle"><i class="fas fa-ellipsis-h"></i></div>
									<div class="row">
										<div class="col-7">
											<textarea class="form-control isidiskusi" style="width: 100%;" rows="5" name="isidiskusi[]" ></textarea>
										</div>
										<div class="col-5 row">
											<div class="col-12">
												<input type="hidden" name="id_diskusi[]" value=""/>
												<select name="dimensidiskusi[]" class="form-control dimensidiskusi">
													<option>- pilih dimensi -</option>
													<?php
													foreach($data_dimensi as $dd) {
														?>
														<option value="<?php echo $dd['name'] ?>"><?php echo $dd['name'] ?></option>
														<?php
													}
													?>
												</select>
											</div>
											<div class="col-12">
												<select name="indikatordiskusi[]" class="form-control indikatordiskusi">
													<option>- pilih indikator -</option>
												</select>	
											</div>
										</div>
									</div>
									<button type="button" class="btn btn-danger btn-delete-diskusi" style="font-size: 10px;padding: 5px;"><i class="fas fa-trash-alt"></i></button>
								</div>
							</div>
						</li>`

					$('#list-of-diskusi').append(html)
					check_diskusi_kuesioner()
                }

                //getAllKuesioner()
                thisel.html('<i class="fas fa-plus"></i>').removeClass('disabled').removeAttr('disabled')
            },
            error: function(error) {
                Swal.fire({
                  icon: 'error',
                  title: "Oops!",
                  text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                })
                thisel.html('<i class="fas fa-plus"></i>').removeClass('disabled').removeAttr('disabled')
            }
        });
	})

	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1000;  //time in ms, 5 second for example

	//on keyup, start the countdown
	$(document).on('keyup','.isidiskusi', function() {
		clearTimeout(typingTimer);

		var thisel = $(this)

	    if (thisel.val()) {
	        typingTimer = setTimeout(function(){

	        	console.log('test')
				save_all()

	        }, doneTypingInterval);
	    }
	})

	$(document).on('change','.dimensidiskusi', function() {
		console.log('test')
		
		var dimensi = $(this).parents('li').find('.dimensidiskusi').val();
		var id_kuesioner = $('#id_kuesioner').val()

		var indikator_diskusi = $(this).parents('li').find('.indikatordiskusi')

		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url().'diskusi/get_indikator' ?>",
		    data: {
		    	'id_kuesioner': id_kuesioner,
		    	'dimensi': dimensi
		    },
		    success: function(data){
		        indikator_diskusi.html(data)
		        // alert(data)
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

	$(document).on('change','.indikatordiskusi', function() {
		save_all()
	})

	$(document).on('click','.btn-save',function(e) {

		e.preventDefault()

		var judul_kuesioner = $('#judul_kuesioner').val()
		var deskripsi_kuesioner = $('#deskripsi_kuesioner').val()
		var id_kuesioner = $('#id_kuesioner').val()
		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url().'kuesioner/update_manual' ?>",
		    data: {
		    	id_kuesioner: id_kuesioner,
		    	judul_kuesioner: judul_kuesioner,
		    	deskripsi_kuesioner: deskripsi_kuesioner
		    },
		    success: function(data){
		    	var dt = JSON.parse(data)

		        if(dt.response == 'ok') {
		        	Toast.fire({
                      icon: 'success',
                      title: 'Berhasil Menyimpan'
                    })
		        }
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

	$(document).on('click', '.btn-delete-diskusi', function() {

		var id_diskusi = $(this).parents('li').find('.id_diskusi').val()

		var thisel = $(this)

		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url().'diskusi/delete_diskusi' ?>",
		    data: {
		    	id_diskusi: id_diskusi,
		    },
		    success: function(data){
		    	var dt = JSON.parse(data)

		        if(dt.response == 'ok') {
		        	Toast.fire({
                      icon: 'success',
                      title: 'Berhasil Menghapus'
                    })

                    thisel.parents('li').remove()
					sortNewincrement()
					check_diskusi_kuesioner()

					//reordering
					save_all()
		        }
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




</script>