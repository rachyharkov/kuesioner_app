<style>
	#cp_red .ui-slider-range {
		background: #ef2929;
	}

	#cp_red .ui-slider-handle {
		border-color: #ef2929;
	}

	#cp_green .ui-slider-range {
		background: #8ae234;
	}

	#cp_green .ui-slider-handle {
		border-color: #8ae234;
	}

	#cp_blue .ui-slider-range {
		background: #729fcf;
	}

	#cp_blue .ui-slider-handle {
		border-color: #729fcf;
	}

	table td {
		border: none !important;
	}

	.tabel_pilihan_row {
		margin-top: 0.6rem;
	}

	.tabel_indicator_row {
		margin-top: 0.6rem;
	}

	.btn-status-status {
		font-size: 11px;
		border-radius: 55%;
		width: 18px;
		height: 18px;
		text-align: center;
		padding: 0px;
	}

	.tooltip {
		position: relative;
		opacity: 1 !important;
	}

	.tooltip:before,
	.tooltip:after {
		display: block;
		opacity: 0;
		pointer-events: none;
		position: absolute;
	}

	.tooltip:after {
		border-right: 6px solid transparent;
		border-bottom: 6px solid rgba(0, 0, 0, .75);
		border-left: 6px solid transparent;
		content: '';
		height: 0;
		top: 20px;
		left: 3px;
		width: 0;
	}

	.tooltip:before {
		width: 300px;
		background: rgba(0, 0, 0, .75);
		border-radius: 2px;
		color: #fff;
		content: attr(data-title);
		font-size: 10px;
		padding: 6px 10px;
		top: 26px;
		white-space: nowrap;
		left: -30px;
		white-space: pre-wrap;
	}

	/* the animations */
	/* fade */
	.tooltip.fade:after,
	.tooltip.fade:before {
		transform: translate3d(0, -10px, 0);
		transition: all .15s ease-in-out;
	}

	.tooltip.fade:hover:after,
	.tooltip.fade:hover:before {
		opacity: 1;
		transform: translate3d(0, 0, 0);
	}
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<?php echo $aksi ?> Kuesioner
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<form id="form_kuesioner_new">
							<input type="hidden" name="form_individu" class="form_individu" required readonly>
							<div class="mb-3">
								<label for="labelInputJudulKuesioner" class="form-label">Judul</label>
								<input type="text" name="judul_kuesioner" class="form-control" id="labelInputJudulKuesioner" required style="font-size: 1.1rem;">
							</div>
							<div class="mb-3">
								<label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
								<textarea name="deskripsi_kuesioner" rows="4" class="form-control" id="labelInputDeskripsiKuesioner" required placeholder="Masukan Deskripsi"></textarea>
							</div>
							<div class="mb-3">
								<label for="label" class="form-label">Form Individu</label>
								<div class="input-group">
									<input type="text" readonly class="form-control form_individu_name" id="labelInputFormIndividu" required placeholder="- Pilih Form Individu -">
									<div class="input-group-append">
										<button type="button" class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#modal_form_individu">
											<i class="fa fa-edit"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="mb-3">

								<div class="card">
									<div class="card-header">
										Optional Feature
									</div>
									<div class="card-body">
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input structural_based_question_check" type="checkbox">
												<span class="form-check-sign"></span>
												Structural Based Question
												<span style="position: absolute;top: -7px;right: -27px;"><button data-title="Apakah anda ingin kuesioner yang tampil tergantung dari opsi yang dipilih sebelum responden memulai isi kuesionernya?. Saat anda membuat diskusi nanti, akan ada opsi yang mengharuskan anda untuk mengatur diskusi sesuai dengan opsi-opsi yang sudah dibuat" class="btn btn-danger btn-sm btn-status-status tooltip fade" style="margin-left: 5px; z-index: 2;" onclick="return false;"><i class="fas fa-question"></i></button></span>
											</label>
										</div>
										<div class="structural_choice_wrapper">
											<input type="text" name="choices_structural" class="choices_structural" disabled>
										</div>
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input additional_feedback_respond_check" type="checkbox">
												<span class="form-check-sign"></span>
												Additional Feedback Respond
												<span style="position: absolute;top: -7px;right: -27px;"><button data-title="Fitur ini akan mengaktifkan kotak inputan saran dan juga kotak input khusus (untuk mengetahui hal yang menjadi penilaian rendah) yang bisa diketik responden saat salah responden terdeteksi memilih jawaban dengan poin rendah (Kritik dan Saran dapat dilihat pada detail respon masing-masing responden)" class="btn btn-danger btn-sm btn-status-status tooltip fade" style="margin-left: 5px; z-index: 1;" onclick="return false;"><i class="fas fa-question"></i></button></span>
											</label>
										</div>
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-6">
									<h5 style="margin: 1rem 0 0 0;">Gap/Tolak Ukur</h5>
									<table class="table" id="dimensi_table">
										<tr id="row0" class="baris_dimensi">
											<td>
												<input type="text" name="dimensi[]" placeholder="Masukan Dimensi" class="form-control dimensi" required />
												<table class="tabel_indicator_row">

												</table>
												<span style="font-size: 11px;"><a href="#" class="add_indicator">Tambah Indikator</a></span>
											</td>

											<td style="vertical-align: top;"><button type="button" id="add_dimensi" class="btn btn-success btn-sm"><i class="now-ui-icons ui-1_simple-add"></i></button></td>
										</tr>
									</table>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6">
									<h5 style="margin: 1rem 0 0 0;">Kategori Respon</h5>
									<table class="table table-borderless" id="kategori_response_table">
										<tr id="row0" class="baris_kategori_respon">
											<td>
												<input type="text" name="kategori_respon[]" placeholder="Masukan nama kategori jawaban" class="form-control kategori_respon" required />
												<table class="tabel_pilihan_row">

												</table>
												<span style="font-size: 11px;"><a href="#" class="add_pilihan">Tambah pilihan</a></span>
											</td>

											<td style="vertical-align: top;"><button type="button" id="add_kategori_respon" class="btn btn-success btn-sm"><i class="now-ui-icons ui-1_simple-add"></i></button></td>
										</tr>
									</table>
								</div>
							</div>
							<input type="text" name="theme_val" id="theme_val" value='<?php echo "[{\"name\":\"default\",\"value\":\"default_random\"}]" ?>'/>
							<button type="submit" class="btn btn-primary">Simpan</button>
							<a href="<?php echo site_url('kuesioner') ?>" class="btn btn-danger list-data">Kembali</a>
						</form>
					</div>
					<div class="col-6">
						<h5 style="margin: 1rem 0 0 0">Tema</h5>
						<div class="option_theme_settings" style="text-align: center;">
							<!-- create button group -->
							<div class="btn-group" role="group" aria-label="Basic example">
								<button type="button" class="btn btn-primary theme_choice active" data-theme="auto">Auto</button>
								<button type="button" class="btn btn-primary theme_choice" data-theme="gradient">Auto2</button>
								<button type="button" class="btn btn-primary theme_choice" data-theme="solid">Solid</button>
								<button type="button" class="btn btn-primary theme_choice" data-theme="picture">Gambar</button>
							</div>
							<div class="theme_setting_wrapper">
								<p style='font-size: 19px; color: gray; margin-bottom: 0;'><i class="fas fa-lightbulb"></i></p>
								<p style='font-size: 11px; color: gray;'>Empat Latar belakang Perpaduan Warna Dasar PT Pupuk Indonesia yang berbeda bagi setiap responden</p>
							</div>
						</div>
						<div class="theme_preview">
							<?php

							$primarycol = '';
							$secondarycol = '';

							$arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
							$arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

							$ano = array_rand($arr1, 1);

							$primarycol = $arr1[$ano];
							$secondarycol = $arr2[$ano];

							?>

							<style>
								.form__group {
									position: relative;
									padding: 15px 0 0;
									margin-top: 10px;
									width: 95%
								}

								.form__field {
									font-family: inherit;
									width: 100%;
									border: 0;
									border-bottom: 2px solid #9b9b9b;
									outline: 0;
									font-size: 1.3rem;
									color: black;
									padding: 7px 0;
									background: transparent;
									transition: border-color 0.2s;
								}

								.form__field::placeholder {
									color: transparent;
								}

								.form__field:placeholder-shown~.form__label {
									font-size: 1.3rem;
									cursor: text;
									top: 20px;
								}

								.form__label {
									position: absolute;
									top: 0;
									display: block;
									transition: 0.2s;
									font-size: 1rem;
									color: #9b9b9b;
								}

								.form__field:focus {
									padding-bottom: 6px;
									font-weight: 700;
									border-width: 3px;
									border-image: linear-gradient(to right, <?php echo $primarycol . ',' . $secondarycol ?>);
									border-image-slice: 1;
								}

								.form__field:focus~.form__label {
									position: absolute;
									top: 0;
									display: block;
									transition: 0.2s;
									font-size: 1rem;
									color: <?php echo $primarycol ?>;
									font-weight: 700;
								}

								.form__field:required,
								.form__field:invalid {
									box-shadow: none;
								}
							</style>

							<div class="card background_kuesioner" style="background-image: linear-gradient(to bottom right, <?php echo $primarycol . ',' . $secondarycol ?>);">
								<div class="card-body" style="text-align: center;">
									<div class="card" style="max-width: 314px; margin-top: 10px;">
										<div class="card-body" style="min-height: 60vh;">
											<div style="width: 100%;text-align: center;margin: 2vh 0;">
												<img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
											</div>
											<div id="form_input_preview_wrapper">
												<div class="form__group">
													<input type="text" class="form__field" disabled>
													<label class="form__label">Your Name</label>
												</div>
												<div class="form__group">
													<input type="text" class="form__field" disabled>
													<label class="form__label">Telp.</label>
												</div>
												<div class="form__group">
													<input type="text" class="form__field" disabled>
													<label class="form__label">City</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="card-footer">

			</div>
		</div>
	</div>
</div>

<!-- modal -->
<div class="modal fade" id="modal_form_individu" role="dialog" aria-labelledby="modal_form_individu" aria-hidden="true" style="overflow:hidden;">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_form_individu">Form Individu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- create dropdowns -->
				<div class="row">
					<div class="col">
						<div class="form-group">
							<select class="form-control selectformindividu" id="labelSelectformindividu" required name="selectformindividu" style="width: 100%;">
								<?php foreach ($form_individu as $key => $value) { ?>
									<option value="<?php echo $value->id_formindividu ?>"><?php echo $value->nama_form ?></option>
								<?php
								} ?>
							</select>
						</div>
						<p style="font-size: 11px;">Ingin mengelola/menambah form individu? <a href="<?= base_url() . 'pengaturan/form_individu/' ?>">klik disini.</a></p>
						<button type="button" class="btn btn-primary btn-choose-formindividu" disabled style="width: 100%;">
							Simpan
						</button>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<p class="text-left">Preview :</p>
						<div class="preview_individu_form">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- create centered modal -->
<div class="modal fade" id="modal_option_structured" tabindex="-1" role="dialog" aria-labelledby="modal_option_structured" aria-hidden="true" style="overflow:hidden;">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_option_structured">Structural Kuesioner</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-structural-data">
				<div class="modal-body">
					<!-- create alert with icon fas fa-warning placed on left -->
					<div class="alert alert-success" role="alert">
						<div class="container" style="display: flex;padding: 0;">
							<div class="alert-icon" style="width: 15%;">
								<i class="now-ui-icons ui-1_bell-53" style="margin-top: 8px;"></i>
							</div>
							<span style="font-size: 11px;">Responden akan melihat pesan dan pilihan yang dibuat dibawah ini saat sebelum pengisian kuesioner dimulai, sehingga diskusi yang tampil akan sesuai dengan yang dipilih dibawah.</span>
						</div>
					</div>
					<div class="form-group">
						<textarea class="form-control" id="option_structured_message" name="option_structured_message" rows="3" placeholder="Masukan pesan disini" required></textarea>
						<label for="optionsInput" class="mt-3">Opsi Pilihan</label>
						<ol class="list-options-ready">
							<li>
								<div style="display: grid; grid-template-columns: 1fr 0.1fr">
									<input type="text" value="" name="optionsValue[]" class="optionsValue" style="border:none" />
									<button class="btn btn-sm btn-remove-this-valueoptions" style="visibility: hidden;">
										<i class="fa fa-times"></i>
									</button>
								</div>
							</li>
						</ol>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-close-structuralconf-dialog" data-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('.selectformindividu').select2({
		placeholder: "Pilih form individu",
	});

	$('[data-toggle="tooltip"]').tooltip()
	$(document).on('click', '#add_dimensi', function(e) {
		e.preventDefault()
		var x = $('.baris_dimensi').length
		$('#dimensi_table').append(`<tr id="row` + x +
			`" class="baris_dimensi"><td><input type="text" name="dimensi[]" placeholder="Masukan Dimensi" class="form-control" required="" /><table class="tabel_indicator_row"></table><span style="font-size: 11px;"><a href="#" class="add_indicator">Tambah Indikator</a></span></td><td style='vertical-align: top;'><button type="button" name="remove" id="` + x + `" class="btn btn-danger btn-sm btn_remove_dimensi">X</button></td></tr>`)
	});

	$(document).on('click', '.btn_remove_dimensi', function() {
		var button_id = $(this).attr("id")
		$('.baris_dimensi#row' + button_id + '').remove()
	});

	$(document).on('click', '.add_indicator', function(e) {
		e.preventDefault()
		var whatrow = $(this).parents('tr').attr('id')

		var tabelindikator = $('#' + whatrow + '.baris_dimensi').find('.tabel_indicator_row')
		var indicatorinputelementlength = tabelindikator.find('tr').length

		tabelindikator.append(`
        <tr id="indicator${whatrow}ke${indicatorinputelementlength}">
          <td style='padding: 0.3rem 0 0 0;'><input type="text" name="indikator_dimensi_${whatrow}[]" placeholder="Indikator" class="form-control" required="" /></td>
          <td style='vertical-align: top;'><a class="remove_indicator" id="${whatrow}ke${indicatorinputelementlength}"><i class="fas fa-times"></i></a></td>
        </tr>
        `)

		console.log(`indicator${whatrow}ke${indicatorinputelementlength} added`)
	})

	$(document).on('click', '.remove_indicator', function() {
		var button_id = $(this).attr("id")
		console.log(button_id + 'removed')
		$('#indicator' + button_id + '').remove()
	})

	//tambah dan kurangi dimensi end here

	//tambah dna kurangi kategori jawaban dan pilihan

	$(document).on('click', '#add_kategori_respon', function() {
		var x = $('.baris_kategori_respon').length
		$('#kategori_response_table').append(`<tr id="row` + x +
			`" class="baris_kategori_respon"><td><input type="text" name="kategori_respon[]" placeholder="Masukan nama kategori jawaban" class="form-control" required="" /><table class="tabel_pilihan_row"></table><span style="font-size: 11px;"><a href="#" class="add_pilihan">Tambah Pilihan</a></span></td><td style='vertical-align: top;'><button type="button" name="remove" id="` + x + `" class="btn btn-danger btn-sm btn_remove_kategori_respon">X</button></td></tr>`)
	});

	$(document).on('click', '.btn_remove_kategori_respon', function() {
		var button_id = $(this).attr("id")
		$('.baris_kategori_respon#row' + button_id + '').remove()
	});

	$(document).on('click', '.add_pilihan', function(e) {
		e.preventDefault()
		var whatrow = $(this).parents('tr').attr('id')

		var tabelpilihan = $('#' + whatrow + '.baris_kategori_respon').find('.tabel_pilihan_row')
		var pilihaninputelementlength = tabelpilihan.find('tr').length

		console.log(tabelpilihan)
		tabelpilihan.append(`
        <tr id="kategori${whatrow}pilihanke${pilihaninputelementlength}">
          <td style='padding: 0.3rem 0 0 0;'><input type="text" name="pilihan_kategori_respon${whatrow}[]" placeholder="pilihan" class="form-control" required="" /></td>
          <td style='vertical-align: top;'><a class="remove_pilihan" id="${whatrow}pilihanke${pilihaninputelementlength}"><i class="fas fa-times"></i></a></td>
        </tr>
        `)

		console.log(`kategori${whatrow}pilihanke${pilihaninputelementlength} added`)
	})

	$(document).on('click', '.remove_pilihan', function() {
		var button_id = $(this).attr("id")
		console.log(button_id + 'removed')
		$('#kategori' + button_id + '').remove()
	})

	$(document).on('submit', '#form_kuesioner_new', function(e) {

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
				dataString = $("#form_kuesioner_new").serialize();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url() . 'Kuesioner/create_action' ?>",
					data: dataString,
					success: function(data) {

						var dt = JSON.parse(data)

						if (dt.response == 'ok') {
							window.location.href = '<?php echo base_url() . 'kuesioner/success?thing=kuesioner&operation=add' ?>'
						}
					},
					error: function(error) {
						Swal.fire({
							icon: 'error',
							title: "Oops!",
							text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
						})
						btnselected.html('Simpan').removeClass('disabled').removeAttr('disabled')
					}
				});
			} else {
				btnselected.html('Simpan').removeClass('disabled').removeAttr('disabled')
			}
		})
	})

	$(document).on('change', '.selectformindividu', function() {
		// ajax get
		$('.preview_individu_form').html('<p>Loading Preview...</p>')
		var id = $(this).val()

		if (id != '') {
			$('.btn-choose-formindividu').removeAttr('disabled')
			$.ajax({
				type: "GET",
				url: "<?php echo base_url() . 'Individuform/preview_form/' ?>" + id,
				success: function(data) {
					$('.preview_individu_form').html(data)
				},
				error: function(error) {
					Swal.fire({
						icon: 'error',
						title: "Oops!",
						text: 'Tidak dapat melakukan preview Form Individu, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
					})
				}
			});
		} else {
			$('.preview_individu_form').html('<p>Silahkan Pilih Form Individu</p>')
			$('.btn-choose-formindividu').attr('disabled', true)
		}
	})

	$(document).on('click', '.btn-choose-formindividu', function() {
		var id = $('.selectformindividu').val()
		var nama = $('.selectformindividu option:selected').text()

		$('.form_individu_name').val(nama)
		$('.form_individu').val(id)

		// close modal
		$('#modal_form_individu').modal('hide')
	})

	$(document).on('change', '.structural_based_question_check', function() {
		if ($(this).prop('checked')) {
			// show modal_option_structured modal
			$('.choices_structural').removeAttr('disabled')
			$('#modal_option_structured').modal({
				backdrop: 'static',
				keyboard: false
			})
		} else {
			$('.choices_structural').prop('disabled', true)
		}
	})

	$(document).on('click', '.btn-close-structuralconf-dialog', function() {
		$('.structural_based_question_check').prop('checked', false)
		$('.choices_structural').prop('disabled', true)
	})

	$(document).on('focus', '.optionsValue', function() {
		var optionsElement = `<li>
			<div style="display: grid; grid-template-columns: 1fr 0.1fr">
				<input type="text" value="" name="optionsValue[]" class="optionsValue" style="border:none"/>
				<button class="btn btn-sm btn-remove-this-valueoptions">
					<i class="fa fa-times"></i>
				</button>
			</div>
		</li>`;
		var totalelement = $('.optionsValue').length

		// get index of this element

		var index = $(this).closest('li').index()

		console.log(index + "/" + totalelement)
		if (index >= (totalelement - 1)) {
			$(this).val("Options " + totalelement)
			$('.list-options-ready').append(optionsElement);
		}
	})

	$(document).on('click', '.btn-remove-this-valueoptions', function() {
		$(this).closest('li').remove();
	})

	$(document).on('hidden.bs.modal', '#modal_option_structured', function() {
		alert('anu')
	})

	$(document).on('submit', '#form-structural-data', function(e) {
		// var btnselected = $(this).find('button[type="submit"]')
		// btnselected.html('<i class="fa fa-spin fa-spinner"></i> Menyimpan').addClass('disabled').attr('disabled', true)
		e.preventDefault()
		var newData = [];
		newData.push({
			'description': $('#option_structured_message').val(),
			'optionsValue': []
		})
		$('.optionsValue').each(function() {
			if ($(this).val() != '') {
				newData[0].optionsValue.push($(this).val())
			}
		})
		$('#modal_option_structured').modal('hide')
		$('.choices_structural').val(JSON.stringify(newData))
	})

	$(document).on('change', '#clr', function() {
		$('.background_kuesioner').css({
			'background-image': 'url(' + $(this).val() + ')',
			'background-color': $(this).val()
		});
	})

	function themeSet(name, value){
		var newData = [];
		newData.push({
			'name': name,
			'value': value
		})
		$('#theme_val').val(JSON.stringify(newData))
	}	

	$(document).on('click', '.theme_choice', function() {

		$('.theme_choice').removeClass('active')
		$(this).addClass('active')

		var theme = $(this).data('theme')

		if (theme == 'solid') {
			$('.theme_setting_wrapper').html(`
				<p style='font-size: 11px; color: gray;'>Latar belakang satu warna</p>
				<input type="color" value= "#001A57" id="clr">
				<label for="clr">Pilih Warna</label>	
			`)

			$('.background_kuesioner').css({
				'background-image': 'url()',
				'background-color': $('#clr').val()
			});
			
			var style = `
				.background_kuesioner {
					background-image: url();
					background-color: ${$('#clr').val()};
				}
			`
			themeSet('solid', style)

		} else if (theme == 'picture') {
			$('.theme_setting_wrapper').html(`
				<p style='font-size: 11px; color: gray;'>Latar belakang dengan dengan gambar yang bisa dipilih (disarankan menggunakan gambar blur serta warna agak gelap) </p>
				<input type="file" id="picture_background_input" style="margin-bottom: 5px;">
				<label for="picture_background_input">Pilih Gambar</label>	
			`)

			$('.background_kuesioner').css({
				'background': 'url(<?= base_url().'assets/images/kuesioner/default.png' ?>) no-repeat center center',
				'background-size': 'cover',
				'height': '100%',
				'overflow': 'hidden',
				'background-color': $('#clr').val()
			});

			var style = `
				.background_kuesioner {
					background: default.png;
					background-size: cover;
					height: 100%;
					overflow: hidden;
					background-color: ${$('#clr').val()};
				}
			`
			themeSet('picture', style)

		} else if(theme == 'gradient') {
			var primarycol = '';
			var secondarycol = '';

			var arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
			var arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

			var rand1 = Math.floor(Math.random() * arr1.length);
			var rand2 = Math.floor(Math.random() * arr2.length);

			primarycol = arr1[rand1];
			secondarycol = arr2[rand2];

			$('.background_kuesioner').css('background-image', 'linear-gradient(to bottom right, ' + primarycol + ', ' + secondarycol + ')')

			$('.theme_setting_wrapper').html(`
				<p style='font-size: 19px; color: gray; margin-bottom: 0;'><i class="fas fa-lightbulb"></i></p>
				<p style='font-size: 11px; color: gray;'>Latar belakang Perpaduan Warna Dasar PT Pupuk Indonesia yang berubah-ubah untuk seluruh responden</p>
			`)

			var style = `gradient_random`
			themeSet('gradient', style)

		} else {

			var primarycol = '';
			var secondarycol = '';

			var arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
			var arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

			var rand1 = Math.floor(Math.random() * arr1.length);

			primarycol = arr1[rand1];
			secondarycol = arr2[rand1];

			$('.background_kuesioner').css('background-image', 'linear-gradient(to bottom right, ' + primarycol + ', ' + secondarycol + ')')
			$('.theme_setting_wrapper').html(`
				<p style='font-size: 19px; color: gray; margin-bottom: 0;'><i class="fas fa-lightbulb"></i></p>
				<p style='font-size: 11px; color: gray;'>Empat Latar belakang Perpaduan Warna Dasar PT Pupuk Indonesia yang berbeda bagi setiap responden</p>
			`)

			var style = `default_random`
			themeSet('default', style)
		}

	})

	$(document).on('change','#picture_background_input', function() {
		var file = this.files[0];

		// can't submit if size more than 1mb
		if (file.size > 1000000) {
			alert('Ukuran gambar terdeteksi melebihi ketentuan (Size 1 MB maximum)')
			return false
		} else {

			// detect image type
			var imageType = /image.*/;

			if (file.type.match(imageType)) {
				var reader = new FileReader();

				reader.onload = function(e) {
					$('.background_kuesioner').css({
						'background': 'url(' + e.target.result + ') no-repeat center center',
						'background-size': 'cover',
						'height': '100%',
						'overflow': 'hidden',
						'background-color': $('#clr').val()
					});
				}

				reader.readAsDataURL(file);
			} else {
				alert('File yang diupload bukan gambar')
			}
		}
	})
</script>