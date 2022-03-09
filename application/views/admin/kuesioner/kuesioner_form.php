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

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<?php echo $aksi ?> Kuesioner
			</div>
			<div class="card-body">
				<form id="form_kuesioner_new">
					<div class="mb-3">
						<label for="labelInputJudulKuesioner" class="form-label">Judul</label>
						<input type="text" name="judul_kuesioner" class="form-control" id="labelInputJudulKuesioner" required style="font-size: 1.1rem;">
					</div>
					<div class="mb-3">
						<label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
						<textarea name="deskripsi_kuesioner" rows="4" class="form-control" id="labelInputDeskripsiKuesioner" required placeholder="Masukan Deskripsi"></textarea>
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

<script>
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
</script>