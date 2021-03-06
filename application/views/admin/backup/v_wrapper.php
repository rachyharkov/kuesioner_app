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
                <h5 class="title">Backup</h5>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Backup</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <p style="text-align: center;">Silahkan pilih tindakan yang ingin anda lakukan terkait backup dibawah ini</p>
                <ul class="nav nav-tabs" role="tablist" style="justify-content: center;">
                    <li class="nav-item">
                        <a class="nav-link hreftoexport" href="#export" role="tab" data-toggle="tab"><span><i class="now-ui-icons arrows-1_cloud-download-93"></i></span> Export</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link hreftoimport" href="#import" role="tab" data-toggle="tab"><span><i class="now-ui-icons arrows-1_cloud-upload-94"></i></span> Import</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="export">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="font-size: 12px;">
                                    <th>Apa yang ingin anda export?</th>
                                    <th>Format</th>
                                </tr>
                            </thead>
                            <?php
                            $arrthingstoexport = [
                                0 => [
                                    'nama' => 'Kuesioner'
                                ],
                                1 => [
                                    'nama' => 'Respon'
                                ],
                                2 => [
                                    'nama' => 'Form Individu'
                                ],
                            ]
                            ?>
                            <tbody>
                                <tr>
                                    <td style="width: 10rem;">
                                        <select class="form-control type_export" name="type_export">
                                            <option value="">- pilih -</option>
                                            <?php
                                            foreach ($arrthingstoexport as $key => $value) {
                                            ?>
                                                <option value="<?= $key ?>"><?= $value['nama'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="width: 10rem;">
                                        <select class="form-control">
                                            <option value="">- pilih -</option>
                                            <option value="json">.json</option>
                                            <option value="xls">.xls</option>
                                            <option value="xlsx">.xlsx</option>
                                            <option value="csv">.csv</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="container data_wrapper">

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="import">
                        <div id="step-1">
                            <table class="table table-borderless">
                                <thead>
                                    <tr style="font-size: 12px;">
                                        <th>Upload</th>
                                        <th>Jenis</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 20rem;">
                                            <input type="file" class="form-control" accept=".xlsx,.xls" name="input-upload" id="input-upload">
                                        </td>
                                        <td>
                                            <p class="jenis-msg m-0" style="display: flex; flex-direction: row; justify-content: space-between;">-</p>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                                            <button disabled class="btn btn-primary btn-confirm-import">Import</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="<?php echo base_url() ?>backup/import_template" target="_blank">Unduh Template Kuesioner</a>
                        </div>
                        <div id="step-2" style="display: none;">

                            <div class="alert alert-success alert-dismissible mt-4 fade show" role="alert" id="alert-danger">
                                <strong>Mengalami Masalah?</strong> <span id="alert-danger-msg">silahkan refresh ulang halaman dan mulai dari tahap awal</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="preview_data_import">
                                <table class="table table-bordered table_preview_data_import" style="max-width: 21rem;margin: 10px auto 25px auto;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3"><b style="font-size: 14px;">Import Check Result</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <b style="font-size: 12px;">Detail</b> 
                                            </td>
                                            <td>
                                                <b style="font-size: 12px;">Status</b>
                                            </td>
                                            <td>
                                                <b style="font-size: 12px;">Tindakan</b>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <p>Silahkan masukan data terkait kuesioner dengan menentukan judul, deskripsi, dan tentukan kategori respon serta apa saja jawaban yang akan dipilih oleh para responden pada kuesioner ini</p>

                            <form id="form_kuesioner_new">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label for="labelInputJudulKuesioner" class="form-label">Judul</label>
                                            <input type="text" name="judul_kuesioner" class="form-control" id="labelInputJudulKuesioner" required style="font-size: 1.1rem;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
                                            <textarea name="deskripsi_kuesioner" rows="4" class="form-control summernote" id="labelInputDeskripsiKuesioner" required placeholder="Masukan Deskripsi"></textarea>
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
                                                    <h5>Opsional</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input additional_feedback_respond_check" name="auto_feedback_detection" type="checkbox">
                                                            <span class="form-check-sign"></span>
                                                            Auto Feedback Detection
                                                            <span style="position: absolute;top: -7px;right: -27px;"><button data-title="Fitur ini akan mengaktifkan kotak inputan saran dan juga kotak input khusus (untuk mengetahui hal yang mengakibatkan responden memberi penilaian rendah) yang bisa diketik responden saat salah responden terdeteksi memilih jawaban dengan poin rendah (Hasil input kritik dan saran dapat dilihat pada detail laporan respon masing-masing responden)" class="btn btn-danger btn-sm btn-status-status tooltip fade" style="margin-left: 5px; z-index: 1;" onclick="return false;"><i class="fas fa-question"></i></button></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-borderless" id="kategori_response_table">
                                            <tr id="row0" class="baris_kategori_respon">
                                                <td>
                                                    <input type="text" name="kategori_respon[]" placeholder="Masukan nama kategori jawaban" class="form-control kategori_respon" required />
                                                    <div class="alertanuuan">
                                                        <p class="alertnyak" style="color: red; font-size: 11px"><b>Wajib ada pilihan pada kategori ini</b></p>
                                                    </div>
                                                    <table class="tabel_pilihan_row">

                                                    </table>
                                                    <span style="font-size: 11px;"><a href="#" class="add_pilihan">Tambah pilihan</a></span>
                                                </td>

                                                <td style="vertical-align: top;"><button type="button" id="add_kategori_respon" class="btn btn-success btn-sm"><i class="now-ui-icons ui-1_simple-add"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
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

                                            <div class="card background_kuesioner" style="transition: all 500ms ease-in-out 0s;background-image: linear-gradient(to bottom right, <?php echo $primarycol . ',' . $secondarycol ?>);">
                                                <div class="card-body" style="text-align: center;">
                                                <div class="card theme-preview-card" style="max-width: 314px; margin-top: 10px;border-radius: 0.5rem;border-top: 10px solid <?= $primarycol ?>;box-shadow: rgb(0 0 0 / 16%) 0px 1px 4px;">
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
                                            <canvas id="temp-preview" style="display: none;"></canvas>
							                <canvas id="temp-canvas" style="display: none;"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="dataaa">
                                    <input type="hidden" name="theme_val" id="theme_val" value='<?php echo "[{\"name\":\"default\",\"value\":\"default_random\",\"accent\":\"dynamic\"}]" ?>'/>
                                    <input type="file" id="picture_background_input" name="picture_bekgron" style="margin-bottom: 5px;display: none;">
                                    <input type="hidden" name="form_individu" class="form_individu" required readonly>
                                    <input type="hidden" name="dimensi" class="tbdimensi" value="" />
                                    <input type="hidden" name="diskusilist" class="tbdiskusilist" value="" />
                                    <input type="hidden" name="choicesstructural" class="tbchoicesstructural" value="" />
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-export" tabindex="-1" aria-labelledby="modal-exportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-exportLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
							<span style="font-size: 11px;">Responden akan melihat pesan dan pilihan yang dibuat dibawah ini sebelum pengisian kuesioner dimulai, sehingga diskusi yang tampil akan sesuai dengan yang dipilih dibawah.</span>
						</div>
					</div>

                    <div class="alert alert-danger alert-danger-structural-question-message-error" role="alert">
						<div class="container" style="display: flex;padding: 0;">
							<div class="alert-icon" style="width: 15%;">
								<i class="now-ui-icons ui-1_bell-53" style="margin-top: 8px;"></i>
							</div>
							<span style="font-size: 11px;line-height: 3;"><b>Pesan</b> harus diisi.</span>
						</div>
					</div>

					<div class="form-group">
						<textarea class="form-control" id="option_structured_message" name="option_structured_message" rows="3" placeholder="Masukan pesan disini" required></textarea>
						<label for="optionsInput" class="mt-3">Opsi Pilihan</label>
						<ol class="list-options-ready">
                            
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

<script src="<?= base_url() . 'assets/admin/js/form-theme-editor.js' ?>"></script>
<script src="<?= base_url() . 'assets/admin/js/heatmap-evdigi.js'?>"></script>

<!-- import summernote -->

<script>
    $('.summernote').summernote({
		toolbar: [
			// [groupName, [list of button]]
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']]
		]
	});
    
    $('.selectformindividu').select2({
		placeholder: "Pilih form individu",
	});
    $('.selectformindividu').val(null).trigger('change');

    $(document).ready(function() {
        $('.nav-tabs a.hrefto<?= $action ?>').click()
    })

    // change query action to anu variable on click .nav-tabs a
    $('.nav-tabs a').click(function() {
        var action = $(this).attr('href').replace('#', '')
        // change query url ?action=action without refresh dont save it to history
        window.history.replaceState({}, '', '?action=' + action)
    })
    

    function show_modal_export() {
        $('#modal-export').modal('show');
    }

    $(document).on('click', '.btn-confirm-import', function() {
        // show modal-importconfirm modal
        $(this).html('<i class="fas fa-spinner fa-spin"></i>').attr('disabled', true);

        setTimeout(function() {
            $('#step-1').css('display', 'none');
            $('#step-2').css('display', 'block');
            $('.btn-confirm-import').html('Import').removeAttr('disabled');
        }, 1000);
    })

    $(document).on('change', '#input-upload', function(e) {
        var file = $(this).val();
        var ext = file.split('.').pop();
        var ext_allow = ['xlsx', 'xls'];
        if (ext_allow.indexOf(ext) < 0) {
            alert('File yang diperbolehkan hanya .xlsx dan .xls');
            $(this).val('');
        } else {
            // create ajax

            // show swal.fire loading
            Swal.fire({
                title: 'Loading',
                html: '<i class="fas fa-spinner fa-spin"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            })

            // get this file
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);

            $.ajax({
                url: "<?= base_url('backup/import') ?>",
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log(response);
                    var dt = JSON.parse(response);
                    if (dt.response == 'ok') {

                        // close swal loading
                        Swal.close();

                        $('.jenis-msg').html(
                            `
                            ${dt.jenis}
                            <button data-title="${dt.message}" class="btn btn-success btn-sm btn-status-status tooltip fade" style="margin-left: 5px;"><i class="fas fa-check-circle"></i></button>    
                            `
                        );

                        
                        $('.btn-confirm-import').removeAttr('disabled');
                        $('.tbdimensi').val(dt.datakuesioner);
                        $('.tbdiskusilist').val(dt.datadiskusi);
                        $('.tbchoicesstructural').val(dt.tbchoicesstructural);

                        var strhtmltotbl = `
                        <tr>
                                <td style='font-size: 12px;'>Dimensi/Gap/Tolak Ukur</td><td style='text-align: center;'><label class='badge bg-success text-white'>${dt.verify.dimensi}</label></td><td style='text-align: center;'></td>
                            </tr>
                            <tr>
                                <td style='font-size: 12px;'>Indikator</td><td style='text-align: center;'><label class='badge bg-success text-white'>${dt.verify.indikator}</label></td><td style='text-align: center;'></td>
                            </tr>
                            <tr>
                                <td style='font-size: 12px;'>Diskusi</td><td style='text-align: center;'><label class='badge bg-success text-white'>${dt.verify.diskusi}</label></td><td style='text-align: center;'></td>
                            </tr>
                            <tr>
                                <td style='font-size: 12px;'>Filter Based</td><td style='text-align: center;'>
                        `;

                        if(dt.verify.exception.status == 0) {
                            strhtmltotbl += `
                                <label class='badge bg-success text-white'>Tidak Aktif</label></td><td style='text-align: center;'></td>
                            </tr>
                            `;

                            $('.tbchoicesstructural').val('N/A');
                        } else {
                            strhtmltotbl += `
                                <label class='badge bg-warning text-white'>Perlu Tindakan</label></td><td style='text-align: center;'><button class='btn btn-warning btn-structured-options' style='width: 20px;height: 20px;font-size: 11px;text-align: center;padding: 0px;'><i class='fas fa-exclamation-triangle'></i></button></td>
                            </tr>
                            `;

                            var listofexception = '';

                            // foreach dt.verufy.exception.value insert string to listofexception
                            $.each(dt.verify.exception.value, function(i, v) {
                                listofexception += `
                                <li>
                                    <div style="display: grid; grid-template-columns: 1fr 0.1fr">
                                        <input type="text" value="${v}" name="optionsValue[]" class="optionsValue" style="border:none" readonly/>
                                    </div>
                                </li>
                                `;
                            })

                            $('.list-options-ready').append(listofexception);
                        }

                        $('.table_preview_data_import tbody').append(strhtmltotbl);

                    }

                    if (dt.response == 'error') {
                        Swal.close();
                        $('.jenis-msg').html(
                            `
                            ${dt.jenis}
                            <button data-title="${dt.message}" class="btn btn-danger btn-sm btn-status-status tooltip fade" style="margin-left: 5px;"><i class="fas fa-exclamation-circle"></i></button>    
                            `
                        );

                        // disable .btn-confirm-import
                        $('.btn-confirm-import').attr('disabled', true);
                    }
                },
                error: function(response) {
                    console.log(response);
                    Swal.close();

                    // get response error
                    var dt = JSON.parse(response.responseText);

                    $('.jenis-msg').html(
                        `
                        ${dt.jenis}
                        <button data-title="${dt.message}" class="btn btn-danger btn-sm btn-status-status tooltip fade" style="margin-left: 5px;"><i class="fas fa-exclamation-circle"></i></button>    
                        `
                    );

                    // disable .btn-confirm-import
                    $('.btn-confirm-import').attr('disabled', true);
                }
            });
        }
    })

    $(document).on('click', '.btn-structured-options', function() {
        $('#modal_option_structured').modal({
            backdrop: 'static',
            keyboard: false
        })
    })

    $(document).on('input','#option_structured_message', function() {
        var message = $(this).val();
        $('.btn-confirm-option-structured').attr('disabled', true);
        if(message.length > 0) {
            $('.btn-confirm-option-structured').removeAttr('disabled');
            $('.alert-danger-structural-question-message-error').css('display', 'none');
        } else {
            $('.alert-danger-structural-question-message-error').css('display', 'block');
        }
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
		$('.tbchoicesstructural').val(JSON.stringify(newData))

        $('.table_preview_data_import').find('tbody').find('tr').eq(5).html(`
            <td style='font-size: 12px;'>Filter Based</td><td style='text-align: center;'>
            <label class='badge bg-success text-white'>ok</label></td><td style='text-align: center;'><button class='btn btn-success btn-structured-options' style='width: 20px;height: 20px;font-size: 11px;text-align: center;padding: 0px;'><i class="fas fa-pen"></i></button></td>
        `);
	})

    $(document).on('click', '.btn-delete', function() {
        // empty file input
        $('#input-upload').val('');
        $('.jenis-msg').html(`-`);
    })

    $(document).on('submit', '#form-export', function(e) {
        var id = $(this).find('td:eq(0) select').val();
        var jumlah = $(this).find('td:eq(1) select').val();
        var format = $(this).find('td:eq(2) select').val();
        // var url = "<?= base_url('admin/backup/export') ?>";
        var data = {
            id: id,
            jumlah: jumlah,
            format: format
        };

        // if data is not empty, do console log
        if (data.id != '' && data.jumlah != '' && data.format != '') {

            if (data.jumlah == 'few') {
                show_modal_export()
            } else {
                $.ajax({
                    url: "<?= base_url('backup/export') ?>",
                    type: 'post',
                    data: data,
                    success: function(response) {
                        // console.log(response);
                        var dt = JSON.parse(response);
                        if (dt.response == 'ok') {
                            window.location.href = dt.redirect;
                        } else {
                            alert('Export gagal');
                        }
                    }
                });
            }
        } else {
            alert('Ada isian yang tidak lengkap');
        }
    })

    $(document).on('change', '.type_export', function() {

        var type = $(this).val()
        // alert('Initialized')

        $.ajax({
            url: "<?= base_url('backup/get_list_backupdata') ?>",
            type: 'post',
            data: {
                type: type,
            },
            success: function(response) {
                // console.log(response);

                var dt = JSON.parse(response);

                $('.data_wrapper').html(dt.html);
            },
            error: function(response) {
                console.log(response);
            }
        })
    })


    $(document).on('click', '#add_kategori_respon', function() {
        var x = $('.baris_kategori_respon').length
        $('#kategori_response_table').append(`<tr id="row` + x +
			`" class="baris_kategori_respon"><td><input type="text" name="kategori_respon[]" placeholder="Masukan nama kategori jawaban" class="form-control" required="" /><div class="alertanuuan"><p class="alertnyak" style="color: red; font-size: 11px"><b>Wajib ada pilihan pada kategori ini</b></p></div><table class="tabel_pilihan_row"></table><span style="font-size: 11px;"><a href="#" class="add_pilihan">Tambah Pilihan</a></span></td><td style='vertical-align: top;'><button type="button" name="remove" id="` + x + `" class="btn btn-danger btn-sm btn_remove_kategori_respon">X</button></td></tr>`)
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
        <tr id="kategori${whatrow}pilihanke${pilihaninputelementlength}" class="pilihandalamkategori">
          <td style='padding: 0.3rem 0 0 0;'><input type="text" name="pilihan_kategori_respon${whatrow}[]" placeholder="pilihan" class="form-control tbpilihan" required="" /></td>
          <td style='vertical-align: top;'><a class="remove_pilihan" id="${whatrow}pilihanke${pilihaninputelementlength}"><i class="fas fa-times"></i></a></td>
        </tr>
        `)

        console.log(`kategori${whatrow}pilihanke${pilihaninputelementlength} added`)
        generateColorScaleforEachPilihanfromEachKategoriRespon()
    })

    $(document).on('click', '.remove_pilihan', function() {
        var button_id = $(this).attr("id")
        console.log(button_id + 'removed')
        $('#kategori' + button_id + '').remove()
        generateColorScaleforEachPilihanfromEachKategoriRespon()
    })


    $(document).on('submit', '#form_kuesioner_new', function(e) {

        e.preventDefault()

        // if name=choicesstructural from this form is empty, do not submit, show swal error

        if ($('.tbchoicesstructural').val() == '') {
            // show swal

            // scroll screen to top quick
            $('.main-panel').animate({
                scrollTop: 0
            }, 700);

            // show toast swal

            alert('Selesaikan tindakan perbaikan terlebih dahulu')


        } else {
            var a = this
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
                        url: "<?php echo base_url() . 'Kuesioner/create_kuesioner_full' ?>",
                        data: new FormData(a), //penggunaan FormData
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false,
                        success: function(data) {
    
                            var dt = JSON.parse(data)
    
                            if (dt.response == 'ok') {
                                window.location.href = '<?php echo base_url() . 'kuesioner/success?thing=kuesioner&operation=add' ?>'
                            } else {
                                alert('check console')
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
        }

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

</script>