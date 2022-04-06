<style>
	table td {
		border: none !important;
	}

	.tabel_pilihan_row {
		margin-top: 0.6rem;
	}

	.tabel_indicator_row {
		margin-top: 0.6rem;
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
							<input type="text" readonly class="form-control form_individu_name" id="labelInputFormIndividu" required placeholder="- Pilih Form Individu -" style="max-width: 320px;">
							<div class="input-group-append">
								<button type="button" class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#modal_form_individu">
									<i class="fa fa-edit"></i>
								</button>
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
					<button type="submit" class="btn btn-primary">Simpan</button>
					<a href="<?php echo site_url('kuesioner') ?>" class="btn btn-danger list-data">Kembali</a>
				</form>
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
								<?php foreach($form_individu as $key => $value)
								{ ?>
									<option value="<?php echo $value->id_formindividu ?>"><?php echo $value->nama_form ?></option>
								<?php
								} ?>
							</select>
						</div>
						<p style="font-size: 11px;">Ingin mengelola/menambah form individu? <a href="<?= base_url().'pengaturan/form_individu/' ?>">klik disini.</a></p>
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

	function validateForm() {
		$
	}

	$(document).on('submit', '#form_kuesioner_new', function(e) {

		e.preventDefault()

		var btnselected = $(document.activeElement)

		btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

		var allowed = 

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

	$(document).on('change','.selectformindividu', function() {
		// ajax get
		$('.preview_individu_form').html('<p>Loading Preview...</p>') 
		var id = $(this).val()

		if(id != ''){
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

	$(document).on('click','.btn-choose-formindividu', function() {
		var id = $('.selectformindividu').val()
		var nama = $('.selectformindividu option:selected').text()
		
		$('.form_individu_name').val(nama)
		$('.form_individu').val(id)

		// close modal
		$('#modal_form_individu').modal('hide')
	})
</script>