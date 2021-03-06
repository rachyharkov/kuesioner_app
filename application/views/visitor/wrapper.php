<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title><?php echo $judul_kuesioner == null || $judul_kuesioner == '' ? 'Not Found' : $judul_kuesioner ?> - Kuesioner Internal PT Pupuk Indonesia </title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- untuk sweet alret -->
	<?php

	$primarycol = '';
	$secondarycol = '';

	$arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
	$arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

	$primarycol = '';
	$secondarycol = '';
	$accent = '';
	$theme_apply = '';
	if ($theme) {
		$theme_decode = json_decode($theme, TRUE);

		if ($theme_decode[0]['name'] == 'default') {
			$ano = array_rand($arr1, 1);
			$primarycol = $arr1[$ano];
			$secondarycol = $arr2[$ano];
			$accent = $arr1[$ano];
			$theme_apply = 'background-image: linear-gradient(to bottom right, ' . $primarycol . ',' . $secondarycol . ');';
		} elseif ($theme_decode[0]['name'] == 'gradient') {
			$ano1 = array_rand($arr1, 1);
			$ano2 = array_rand($arr1, 1);
			$primarycol = $arr1[$ano1];
			$secondarycol = $arr2[$ano2];
			$accent = $arr1[$ano1];
			$theme_apply = 'background-image: linear-gradient(to bottom right, ' . $primarycol . ',' . $secondarycol . ');';
		} elseif ($theme_decode[0]['name'] == 'solid') {
			$primarycol = $theme_decode[0]['value'];
			$secondarycol = $theme_decode[0]['value'];
			$accent = $theme_decode[0]['accent'];
			$theme_apply = 'background-image: url();background-color: ' . $primarycol . ';';
		} elseif ($theme_decode[0]['name'] == 'picture') {
			$primarycol = $theme_decode[0]['accent'];
			$secondarycol = $theme_decode[0]['accent'];

			$accent = $theme_decode[0]['accent'];;
			$theme_apply = 'background: url(' . base_url() . 'assets/images/kuesioner/' . $theme_decode[0]['value'] . ') no-repeat center center fixed;background-size: cover;height: 100%;overflow: hidden;';
		}
	} else {
		$ano = array_rand($arr1, 1);
		$primarycol = $arr1[$ano];
		$secondarycol = $arr2[$ano];
		$theme_apply = 'background-image: linear-gradient(to bottom right, ' . $primarycol . ',' . $secondarycol . ');';
	}

	?>
	<style>
		@-webkit-keyframes click-wave {
			0% {
				height: 40px;
				width: 40px;
				opacity: 0.35;
				position: relative;
			}

			100% {
				height: 200px;
				width: 200px;
				margin-left: -80px;
				margin-top: -80px;
				opacity: 0;
			}
		}

		@-moz-keyframes click-wave {
			0% {
				height: 40px;
				width: 40px;
				opacity: 0.35;
				position: relative;
			}

			100% {
				height: 200px;
				width: 200px;
				margin-left: -80px;
				margin-top: -80px;
				opacity: 0;
			}
		}

		@keyframes click-wave {
			0% {
				height: 40px;
				width: 40px;
				opacity: 0.35;
				position: relative;
			}

			100% {
				height: 200px;
				width: 200px;
				margin-left: -80px;
				margin-top: -80px;
				opacity: 0;
			}
		}

		.option-input {
			-webkit-appearance: none;
			-moz-appearance: none;
			-ms-appearance: none;
			-o-appearance: none;
			appearance: none;
			position: relative;
			top: 13.3333333333px;
			right: 0;
			bottom: 0;
			left: 0;
			height: 40px;
			width: 40px;
			-webkit-transition: all 0.15s ease-out 0s;
			-moz-transition: all 0.15s ease-out 0s;
			transition: all 0.15s ease-out 0s;
			background: #cbd1d8;
			border: none;
			color: #fff;
			cursor: pointer;
			display: inline-block;
			margin-right: 0.5rem;
			outline: none;
			position: relative;
			z-index: 1000;
		}

		.option-input:hover {
			background: #9faab7;
		}

		.option-input:checked {
			background: <?= $primarycol ?>;
		}

		.option-input:checked::before {
			height: 40px;
			width: 40px;
			position: absolute;
			content: "???";
			display: inline-block;
			font-size: 26.6666666667px;
			text-align: center;
			line-height: 40px;
			transform: rotateZ(45deg);
		}

		.option-input:checked::after {
			-webkit-animation: click-wave 0.65s;
			-moz-animation: click-wave 0.65s;
			animation: click-wave 0.65s;
			background: <?= $primarycol ?>;
			content: "";
			display: block;
			position: relative;
			z-index: 100;
		}

		.option-input.radio-confirm {
			border-radius: 50%;
		}

		.option-input.radio-confirm::after {
			border-radius: 50%;
		}


		.radio {
			position: relative;
			cursor: pointer;
			line-height: 20px;
			font-size: 14px;
			margin: 7px;
		}

		.radio .label {
			position: relative;
			display: block;
			float: left;
			margin-right: 10px;
			width: 20px;
			height: 20px;
			border: 2px solid #c8ccd4;
			border-radius: 100%;
			-webkit-tap-highlight-color: transparent;
		}

		.radio .label:after {
			content: '';
			position: absolute;
			top: 3px;
			left: 3px;
			width: 10px;
			height: 10px;
			border-radius: 100%;
			background: <?= $primarycol ?>;
			transform: scale(0);
			transition: all 0.2s ease;
			opacity: 0.08;
			pointer-events: none;
		}

		.radio:hover .label:after {
			transform: scale(3.6);
		}

		input[type="radio"]:checked+.label {
			border-color: <?= $primarycol ?>;
		}

		input[type="radio"]:checked+.label:after {
			transform: scale(1);
			transition: all 0.2s cubic-bezier(0.35, 0.9, 0.4, 0.9);
			opacity: 1;
		}

		.hidden {
			display: none;
		}

		.form__group {
			position: relative;
			padding: 15px 0 0;
			margin-top: 10px;
			width: 100%;
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

		.landing-confirm-wrapper {
			height: 100%;
			width: 100%;
			z-index: 9999;
			position: fixed;
			background-color: white;

			display: flex;
			justify-content: center;
			align-items: center;
		}
	</style>

</head>

<body>
	<canvas id="temp-preview" style="display: none;"></canvas>
	<canvas id="temp-canvas" style="display: none;"></canvas>

	<?php

	if ($choices_structural) {
		if ($choices_structural != 'N/A') {
			$choices_structural = json_decode($choices_structural, true);
	?>
			<div class="landing-confirm-wrapper">
				<!-- create center div -->
				<div class="confirm-center-wrapper" style="max-width: 320px; margin: auto;">
					<p><?= $choices_structural[0]['description'] ?></p>
					<div style="display: flex; flex-direction: column;">
						<?php
							foreach($choices_structural[0]['optionsValue'] as $v) {
								?>
								<label>
									<input type="radio" class="option-input radio-confirm" name="structural-choice" value="<?= $v ?>"/>
									<?= $v ?>
								</label>
								<?php
							}
						?>
						<label>
							<input type="radio" class="option-input radio-confirm" name="structural-choice" value="skip" />
							Lewati
						</label>
					</div>
				</div>
			</div>
	<?php
		}
	}
	?>

	<div class="container-fluid" style="<?= $theme_apply; ?>">
		<div class="container-sm" style="max-width: 670px;min-height: 100vh;">
			<div id="body" style="position: relative;padding-top: 5rem;">
				
				<?php

				if($judul_kuesioner == null || $judul_kuesioner == '') {
					$classnyak->load->view('error_404');
				} else {
					?>
					<!-- create spinner -->
					<i class="fas fa-circle-notch fa-spin" style="font-size: 18px; position: absolute; left: 50%; top: 50%;"></i>
					<?php
				}

				?>
			
			</div>
		</div>
		<div class="footer">
			<div class="container-sm">
				<div class="row">
					<div class="col-sm-12">
						<div class="text-center">
							<p style="color: white; font-size: 12px;">Copyright &copy; <?php echo date('Y') ?> Kompartemen Pusat Pembelajaran dan Pengetahuan - PT Pupuk Indonesia (Persero) | <a href="https://rach-nh.xyz" style="color: white;">RNH</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalAutoSaveDetail" tabindex="-1" role="dialog" aria-labelledby="modalAutoSaveDetailTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div style="text-align: center;position: relative;">
						<i class="fas fa-save" style="font-size: 114px; color: gray;"></i>
						<i class="fas fa-sync-alt fa-spin" style="position: absolute;bottom: -4px;right: 70px;font-size: 34px;color: green;"></i>
					</div>
					<h4 class="mt-4">Autosave Respond</h4>
					<p style="font-size: 12px;">Kami otomatis menyimpan respon yang sudah anda buat pada perangkat anda, jadi anda bisa menunda pengisian tanpa harus mengulang isian dari awal.</p>
				</div>
				<div class="modal-footer" style="border-top: none !important;">
					<button type="button" class="btn btn-sm" style="font-size: 1rem;" data-bs-dismiss="modal">Mengerti</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		// define base url
		var base_url = '<?php echo base_url() ?>';
	</script>
	<script src="<?= base_url() . 'assets/admin/js/form-theme-editor.js' ?>"></script>

	<script type="text/javascript">

		function autoSaveResponse() {

			// if localStorage supported, insert datarespon to localstorage
			if (typeof(Storage) !== "undefined") {
				var id = getUrlParameter('id');
				
				// check if localstorage with key id is exists
				if (localStorage.getItem(id) != null) {
					var localdata = JSON.parse(localStorage.getItem(id));

					// check if localdata has same id with datarespon
					
					if (localdata.id == id) {
	
						// alert('Respon anda sudah dikembalikan dari perangkat anda :' + localdata.id);
						$('.btn-autosave-info').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-check" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
					<path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/></svg> Restored`);
					}
				} else {
					var data = {
						id: id,
						status: 1,
						data: []
					};
					var data_json = JSON.stringify(data);
					localStorage.setItem(id, data_json);
					// alert('Respon anda telah tersimpan')
					$('.btn-autosave-info').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-check" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
					<path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/></svg> Tersimpan`);
				}			
			} else {
				// if localStorage not supported, alert user
				alert("Sorry! No Web Storage support..");
				$('.btn-autosave-info').html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-check" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
					<path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/></svg> Not Supported`);
			}
			
		} 

		function getUrlParameter(sParam) {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
				}
			}
		};

		
		// get url query of id
		
		
		$(document).ready(function() {

			// create setTimout for autosave every 5 seconds
			setInterval(function() {
				$('.btn-autosave-info').html('<i class="fas fa-sync fa-spin"></i> Menyimpan Progress');
				autoSaveResponse();
			}, 5000);
			
			<?php 
			if($datakuesioner->auto_feedback_detection) {
				?>

				function detectFeedbackBehavior() {
					var arr = []

					// detect if any choice is checked
					$('.choicenya').each(function() {
						if($(this).is(':checked')) {
							var id = $(this).attr('id');

							// split id by _ and get last part
							var id_split = id.split('_');
							var id_last = id_split[id_split.length - 1];
							arr.push(id_last)
						}
					})

					var negative_feedback = 0

					// detect if arr has number with less than '2', if true, alert
					var count = 0;
					for(var i = 0; i < arr.length; i++) {
						if(arr[i] < 2) {
							// set negative_feedback to 1 then stop loop
							negative_feedback = 1;
							break;
						}
					} 

					if(negative_feedback == 1) {
						alert('LOW FEEDBACK DETECTED')
						$('.negative-feedback-wrapper').show().find('textarea.tbfeedback_negative').html('')
					} else {
						$('.negative-feedback-wrapper').hide().find('textarea.tbfeedback_negative').html('N/A')
					}
				}
				
				alert('AUTO FEEDBACK ACTIVE')

				// create setTimout for autosave every 5 seconds

				$(document).on('click','.choicenya', function() {
					detectFeedbackBehavior()
				})

				<?php
			}
			?>

			<?php
			if ($theme_decode[0]['name'] == 'default' || $theme_decode[0]['name'] == 'solid' || $theme_decode[0]['name'] == 'gradient') {
			?>

				var colortobright = increase_brightness('<?= $primarycol ?>', 50)
				$('.theme-preview-card').css('border-top', '10px solid ' + colortobright)

			<?php
			} else {
			?>

				var image = new Image()
				image.src = base_url + 'assets/images/kuesioner/<?= $theme_decode[0]['value'] ?>'
				image.onload = function() {
					var accent = getDominantColor(image)
					$('.theme-preview-card').css('border-top', '1rem solid ' + accent)
				}
			<?php
			}

			if($choices_structural) {
				if($choices_structural == 'N/A') {
					?>
					$.ajax({
						url: base_url + 'survey/get_kuesioner',
						type: 'GET',
						data: {
							id: getUrlParameter('id'),
							sel: 'skip'
						},
						success: function(data) {
							// console.log(data)
							// create variable to store data
							var data = JSON.parse(data)

							if (data.status == 'success') {
								$('.landing-confirm-wrapper').fadeOut(1000)
								$('#body').html(data.html)
							}
						}
					})
					<?php
				}
			} ?>
		})

		$(document).on('click', '.radio-confirm', function() {
			var selected = $(this).val()

			// disable .option-input.radio-confirm
			$('.option-input.radio-confirm').attr('disabled', true)

			$.ajax({
				url: base_url + 'survey/get_kuesioner',
				type: 'GET',
				data: {
					id: getUrlParameter('id'),
					sel: selected
				},
				success: function(data) {
					// console.log(data)
					// create variable to store data
					var data = JSON.parse(data)

					if (data.status == 'success') {
						$('.landing-confirm-wrapper').fadeOut(1000)
						$('#body').html(data.html)
					}
				}
			})

		})

		$(document).on('submit', '#form_create_action', function(e) {

			e.preventDefault()

			var btnselected = $(document.activeElement)

			btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

			var iseverythingchecked = 1;
			$('.card-body').find('.alert-wrapper').html('')
			$('.choicenya').each(function() {
				var thiselsinglechoice = $(this)

				var choicesname = $(`input[name="${thiselsinglechoice.attr('name')}"]:checked`)

				if (!choicesname.val()) {
					thiselsinglechoice.parents('.card-body').find('.alert-wrapper').html(`<div class="alert alert-danger">
								<b>Perhatian</b> Isian kosong, silahkan pilih salah satu
							</div>`)
					iseverythingchecked = 0;
				}
			})

			if (iseverythingchecked == 1) {
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
						dataString = $("#form_create_action").serialize();
						$.ajax({
							type: "POST",
							url: "<?php echo base_url() . 'Survey/save' ?>",
							data: dataString,
							success: function(data) {
								Swal.fire({
									icon: 'success',
									title: "Sukses",
									text: 'Survey tercatat'
								})

								// insert data to localstorage
								

								$('#body').html(data);
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
			} else {
				alert('Ada isian yang kosong, mohon di cek kembali')
				btnselected.html('Selesai').removeClass('disabled').removeAttr('disabled')
			}

		})
	</script>
</body>

</html>