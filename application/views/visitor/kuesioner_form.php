<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
	.select2-container .select2-selection--single {
		height: 36px;
	}

	.scroll-to-down-anim {
		height: 3vh;
		position: relative;
		width: 100%;
	}

	.scroll-to-down-anim::before {
		animation: bounce 1s ease infinite;
		bottom: -2rem;
		color: black;
		font-family: "Font Awesome 5 Free";
		content: "\f078";
		display: inline-block;
		padding-right: 3px;
		vertical-align: middle;
		font-weight: 900;
		font-size: 2rem;
		height: 3rem;
		left: 50%;
		letter-spacing: -1px;
		line-height: 4rem;
		margin-left: -3rem;
		opacity: 0.8;
		position: absolute;
		text-align: center;
		width: 6rem;
	}

	@keyframes bounce {
		50% {
			transform: translateY(-50%);
		}
	}
</style>

<form id="form_create_action" method="post" enctype="multipart/form-data">

	<div class="container" style="padding: 1vh 0;
display: block;">
		<div class="card" style="width: 100%;">
			<div class="card-body">
				<div style="width: 100%;
text-align: center;
margin: 2vh 0;">
					<img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
				</div>
				<h4><?php echo $data_kuesioner->judul_kuesioner ?></h4>
				<p><?php echo $data_kuesioner->deskripsi_kuesioner ?></p>

				<div class="scroll-to-down-anim"></div>

			</div>
		</div>
	</div>

	<div class="container" style="padding: 1vh 0; display: block;">
		<div class="card" style="width: 100%;">
			<div class="card-body">
				<div style="width: 100%;
text-align: center;
margin: 2vh 0;">
					<img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
				</div>

				<?php

				$formdata = json_decode($data_formindividu->design_form, true);
				
				// sort formdata by "position" value
				usort($formdata, function($a, $b) {
					return $a['position'] - $b['position'];
				});

				foreach ($formdata as $key => $value) {
					
					if($value['elementtype'] == 'text' || $value['elementtype'] == 'email' || $value['elementtype'] == 'number') {
						?>
						<div class="form__group field">
							<input type="<?= $value['elementtype'] ?>" class="form__field" placeholder="<?= $value['placeholder'] ?>" name="<?= $value['prefix'] ?>" <?= $value['required'] == true ? 'required' : '' ?> />
							<label for="<?= $value['prefix'] ?>" class="form__label"><?= $value['elementname'] ?></label>
						</div>
						<?php
					}

					if($value['elementtype'] == 'options') {
						?>
						<div class="form-group">
							<select class="form-select" aria-label="Pilih <?= $value['placeholder'] ?>" name="<?= $value['prefix'] ?>" style="margin: 3vh 0;">
								<option selected>- Pilih <?= $value['placeholder'] ?> -</option>
								<?php
									foreach ($value['elementvaluelist'] as $keyvaluelist => $valuelist) {
									?>
										<option value="<?php echo $valuelist['value'] ?>"><?php echo $valuelist['name'] ?></option>
									<?php
									}
								?>
							</select>
						</div>
						<?php
					}

				}


				?>
			</div>
		</div>
	</div>
	<?php

	foreach ($list_diskusi as $key => $value) {

	?>
		<input type="hidden" name="soal<?php echo $value->urutan ?>id" value="<?php echo $value->id ?>">
		<div class="container container-<?php echo $value->urutan ?>" style="padding: 1vh 0; display: block;">
			<div class="card" style="width: 100%; position: relative;">
				<span class="badge rounded-pill bg-secondary" style="position: absolute;
left: 50%;
top: -13px;
transform: scale(1.4);"><?php echo $value->urutan ?></span>
				<div class="card-body">
					<div class="alert-wrapper">

					</div>
					<p class="card-text"><?php echo $value->isi_diskusi ?></p>

					<div class="container-fluid" style="display: flex;
flex-direction: row;
justify-content: space-evenly;">

						<?php

						$kategori_resp = json_decode($data_kuesioner->kategori_respon, TRUE);

						foreach ($kategori_resp as $keykr => $kr) {

						?>
							<div>
								<span style="width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold;"><?php echo $kr['nama'] ?></span>
								<div style="display: flex; flex-direction: column;">
									<?php
									foreach ($kr['respon_list'] as $key => $rp) {
									?>
										<label for="disc<?php echo $value->urutan ?>_col<?php echo $keykr ?>_<?php echo $key ?>" class="radio">
											<input type="radio" value="<?php echo $rp ?>" name="disc<?php echo $value->urutan ?>_col<?php echo $keykr ?>" id="disc<?php echo $value->urutan ?>_col<?php echo $keykr ?>_<?php echo $key ?>" class="hidden choicenya disc<?php echo $value->urutan ?>_col<?php echo $keykr ?>" />
											<span class="label"></span><?php echo $rp ?>
										</label>
									<?php
									}
									?>
								</div>
							</div>
						<?php

						}
						?>

					</div>

				</div>
			</div>
		</div>
	<?php
	}

	?>
	<input type="hidden" name="id_kuesioner" value="<?php echo $data_kuesioner->id_kuesioner ?>">
	<button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 10vh; font-size: 1.2rem;">Selesai</button>
</form>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.select-uwu1').select2({
			placeholder: "Pilih Unit Kerja",
			allowClear: true
		});

		$('.select-uwu2').select2({
			placeholder: "Pilih Job Grade",
			allowClear: true
		});
	})
</script>