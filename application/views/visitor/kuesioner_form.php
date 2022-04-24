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

	.sequence-wrapper {
		margin-top: -50px;
		transform: scale(0);
		transition: all 500ms ease-in-out;
		animation-name:moveTobottom;
        animation-fill-mode: forwards;
		-webkit-animation-name:wowow;
        -webkit-animation-fill-mode: forwards;
	}

	@keyframes wowow{
		from{
			margin-top: -50px;
			transform: scale(0);
		}
		to{
			margin-top: 0px;
			transform: scale(1);
		}
	}
	@-webkit-keyframes wowow{
		from{
			margin-top: -50px;
			transform: scale(0);
		}
		to{
			margin-top: 0px;
			transform: scale(1);
		}
	}
</style>

<form id="form_create_action" method="post" enctype="multipart/form-data">

	<div class="container sequence-wrapper" style="padding: 1vh 0;display: block;animation-duration: 1.0s;">
		<div class="card" style="width: 100%;border-radius: 0.7rem;box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;">
			<div class="card-body">
				<div style="width: 100%;
text-align: center;
margin: 2vh 0;">
					<img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
				</div>
				<h4 class="mb-4"><?php echo $data_kuesioner->judul_kuesioner ?></h4>
				<p><?php echo $data_kuesioner->deskripsi_kuesioner ?></p>

				<div class="scroll-to-down-anim"></div>

			</div>
			<div class="card-footer" style="padding-top: 1rem;">
				<!-- create switch radio -->
				<p class="text-danger" style="float: left;">* Wajib Diisi</p>
				<!-- create button with autosave icon -->
				
				<!-- cloud check icon -->
				<button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalAutoSaveDetail" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-check" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
					<path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/></svg>
				</button>
			</div>
		</div>
	</div>
	
	<div class="container sequence-wrapper" style="padding: 2vh 0; display: block;animation-duration: 1.3s;">
		<div class="card theme-preview-card" style="width: 100%;border-radius: 1rem;border-top: 1rem solid white;box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;">	
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
						<div class="form__group field">
							<select aria-label="Pilih <?= $value['placeholder'] ?>" class="form__field" name="<?= $value['prefix'] ?>" style="margin: 3vh 0;">
								<option selected>- <?= $value['placeholder'] ?> -</option>
								<?php
									foreach ($value['elementvaluelist'] as $valuelist) {
									?>
										<option value="<?php echo $valuelist ?>"><?php echo $valuelist ?></option>
									<?php
									}
								?>
							</select>
							<label class="form__label"><?= $value['elementname'] ?></label>
						</div>
						<?php
					}

				}


				?>
			</div>
		</div>
	</div>
	<?php

	$dataanimationoffset = 1.3;
	$no = 1;
	foreach ($list_diskusi as $key => $value) {

	?>
		<input type="hidden" name="soal<?php echo $no ?>id" value="<?php echo $value->id ?>">
		<div class="container container-<?php echo $no ?> sequence-wrapper" style="padding: 2vh 0; display: block; margin-top: 11px;animation-duration: <?= $dataanimationoffset+0.3 ?>s;">
			<div class="card" style="width: 100%; border-radius: 1rem; position: relative;box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;">
				<span class="badge rounded-pill bg-secondary" style="position: absolute;
left: 50%;
top: -13px;
transform: scale(1.4);"><?php echo $no ?></span>
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
		$no++;
	}

	?>
	<?php

	if($data_kuesioner->auto_feedback_detection) {
		?>
		<div class="feedback-wrapper">
			<div class="container sequence-wrapper negative-feedback-wrapper" style="padding: 2vh 0; display: block; margin-top: 11px;animation-duration: <?= $dataanimationoffset+0.3 ?>s;">
				<div class="card" style="width: 100%; border-radius: 1rem; position: relative;box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;">
					<span class="badge rounded-pill bg-warning" style="position: absolute;left: 50%;top: -13px;transform: scale(1.4);"><i class="fas fa-frown"></i></span>
					<div class="card-body">
						<p class="card-text">Mohon maaf jika ada yang membuat anda kecewa, kami mendeteksi bahwa anda memberikan penilaian jauh dibawah ekspetasi kami, beritahu kami apa yang terjadi?</p>
		
						<textarea class="form-control" name="tbfeedback_negative" rows="3" style="width: 100%;"></textarea>
					</div>
				</div>
			</div>
		
			<div class="container sequence-wrapper positive-feedback-wrapper" style="padding: 2vh 0; display: block; margin-top: 11px;animation-duration: <?= $dataanimationoffset+0.3 ?>s;">
				<div class="card" style="width: 100%; border-radius: 1rem; position: relative;box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;">
					<span class="badge rounded-pill bg-success" style="position: absolute;left: 50%;top: -13px;transform: scale(1.4);"><i class="fas fa-smile"></i></span>
					<div class="card-body">
						<p class="card-text">Adakah yang ingin disampaikan pada kuesioner ini? (saran, hal yang disukai, dan sebagainya)</p>
		
						<textarea class="form-control" name="tbfeedback_negative" rows="3" style="width: 100%;"></textarea>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

	?>

	<input type="hidden" name="id_kuesioner" value="<?php echo $data_kuesioner->id_kuesioner ?>">
	<button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 5vh; font-size: 1.2rem;">Submit</button>
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