<!-- Chart JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script>
<style>

	.preview-answer.form-check-radio input[type="radio"]:checked+.form-check-sign::after {
		transform: scale(2.5);
	}

	.gap-preview-wrapper>.left-side {
		position: relative;
		left: 50%;
		z-index: 2;
		transition: all 0.3s ease-in-out;
	}

	.gap-preview-wrapper>.right-side {
		position: relative;
		right: 50%;
		transition: all 0.3s ease-in-out;
	}

	.gap-preview-wrapper:hover>.left-side {
		left: 0;
		transition: all 0.3s ease-in-out;
	}

	.gap-preview-wrapper>.right-side {
		opacity: 0;
	}

	.gap-preview-wrapper:hover>.right-side {
		right: 0;
		transition: all 0.3s ease-in-out;
		opacity: 1;
	}

	.badge-gap {
		transition: all 0.2s ease-in-out;
	}

	.badge-gap:nth-child(1) {
		border-top-left-radius: 0.5rem !important;
		border-top-right-radius: 0.5rem !important;
	}

	.badge-gap:nth-last-child(1) {
		border-bottom-left-radius: 0.5rem !important;
		border-bottom-right-radius: 0.5rem !important;
	}

	.badge-gap:hover {
		transform: scale(1.1);
		transition: all 0.2s ease-in-out;
		border-radius: 0.5rem !important;
	}

	@media (min-width: 576px) {
		.custom-auto-width {
			width: auto;
		}
	}

	@media (min-width: 768px) {
		.custom-auto-width {
			width: 31%;
		}
	}
</style>
<?php

$datadiskusidanjumlahjawabannya = [];

$query = "SELECT *
	FROM tbl_jawaban
	WHERE jawaban LIKE '%\"id_kuesioner\":\"" . $data_kuesioner->id_kuesioner . "\"%'";
$jawabanlist = $this->db->query($query)->result();

?>

<h4><?php echo $data_kuesioner->judul_kuesioner ?></h4>
<div class="container-fluid">
	<div class="d-flex flex-column flex-md-row mb-4">
		<div class="align-self-stretch custom-auto-width" style="height: 100%;">
			<div class="card" style="height: 100%; display: flex; margin: 0;">
				<div class="card-body">
					<p>Total Responden</p>
					<h2 style="margin: 0;"><?php echo $total_responden ?></h2>
				</div>
				<div class="card-footer text-right" style="font-size: 11px;">
					<!-- call modal #modal-data-respond -->
					<a href="#" data-toggle="modal" data-target="#modal-data-respond">
						Detail
					</a>
				</div>
			</div>
		</div>
		<div class="align-self-stretch custom-auto-width m-md-auto" style="height: 100%;">
			<div class="card" style="height: 100%; display: flex; margin: 0;">
				<div class="card-body">
					<p>Today's Respond</p>
					<h2 style="margin: 0;"><?php print_r($todays_responden) ?></h2>
				</div>
				<div class="card-footer text-right" style="font-size: 11px;">
					<a href="#">Detail</a>
				</div>
			</div>
		</div>
		<div class="align-self-stretch custom-auto-width d-flex flex-row flex-md-column justify-content-between">
			<div class="align-self-stretch card" style="margin: 0;">
				<div class="card-body">
					<p style="margin: 0;">Status</p>
					<?php

					echo $data_kuesioner->status == 1 ? '<span class="badge bg-success text-white">Aktif</span>' : '<span class="badge bg-danger text-white">Tidak Aktif</span>';
					// $this->report_processor->get_highest_gap($data_kuesioner, $jawabanlist);
					?>
				</div>
			</div>
			<div class="align-self-stretch card" style="margin: 0;">
				<div class="card-body">
					<p style="margin: 0;">Last Respond</p>
					<span class="badge bg-success text-white"><?= $this->report_processor->get_last_update($data_kuesioner->id_kuesioner) ?></span>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<!-- create table with borderless -->
			<p style="margin: 0;">Gap Result</p>
			<div class="gap-preview-wrapper" style="position: relative; display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
				<?php
				$this->report_processor->generate_gap_scoreboard($data_kuesioner, $jawabanlist);
				?>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<!-- create table with borderless -->
			<table>
				<?php
				$pacuannilai = $this->report_processor->get_jawaban_nilai($data_kuesioner);
				foreach ($pacuannilai as $key => $value) {
					$maxscale = count($value);
				?>
					<tr>
						<td><?= $key ?></td>
						<td>:</td>
						<td>
							<?php
							$urutanwarna = $maxscale;
							foreach ($value as $key => $value) {
							?>
								<span class="badge text-white" style="background-color:<?php echo $this->report_processor->numberToColorHsl($urutanwarna / $maxscale, 0, 1) ?>"><?php echo $key . '(' . $value . ')' ?></span>
							<?php
								$urutanwarna--;
							}
							?>
						</td>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<?php

			$i = 1;
			foreach ($list_diskusi as $diskusi) {
				$datadiskusidanjumlahjawabannya[$diskusi->id] = [];
			?>
				<!-- create card element only with body -->
				<div class="card">
					<div class="card-body">
						<p><?= $diskusi->isi_diskusi; ?></p>

						<div class="container">
							<div class="d-flex">
								<?php
								$id_diskusi = $diskusi->id;
								$kr = json_decode($data_kuesioner->kategori_respon, true);

								foreach ($kr as $keykategorirespon => $v) {

								?>
									<div class="w-50">
										<?php
										echo "<p>" . $v['nama'] . "</p>"; //kategori responnya
										$namakategorirespon = $v['nama'];
										$rl = $v['respon_list'];

										$datadiskusidanjumlahjawabannya[$id_diskusi][] = [
											'namakategorirespon' => $namakategorirespon,
											'detail' => [
												'label' => [],
												'datanya' => []
											]
										];

										$arrayresponlistdantotaljawaban = [];

										foreach ($rl as $key => $v) {
											$arrayresponlistdantotaljawaban[$v] = 0;
										}


										//should be fixed!
										foreach ($jawabanlist as $key => $jl) {
											$json_decode = json_decode($jl->jawaban, TRUE);

											$find_array_by_value = array_search($id_diskusi, array_column($json_decode, 'id_diskusi'));

											$arrjawabanfound = $json_decode[$find_array_by_value];

											if ($arrjawabanfound['id_diskusi'] == $id_diskusi) {
												$jawabannya = $arrjawabanfound[$namakategorirespon];

												if(isset($arrayresponlistdantotaljawaban[$jawabannya])){
													$arrayresponlistdantotaljawaban[$jawabannya]+= 1;
												}
											}
										}

										$highest_value = max($arrayresponlistdantotaljawaban);
										foreach ($arrayresponlistdantotaljawaban as $keynamaresponnya => $rp) {
										?>
											<div style="display: grid;grid-template-columns: 0.2fr 1fr 0.3fr;">

												<?php
												// find highest value of array $arrayresponlistdantotaljawaban[$key]
												echo $keynamaresponnya;
												$totalresponini = $rp;
												foreach ($datadiskusidanjumlahjawabannya[$id_diskusi] as $key => $value) {
													if ($value['namakategorirespon'] == $namakategorirespon) {
														array_push($datadiskusidanjumlahjawabannya[$id_diskusi][$key]['detail']['label'], $keynamaresponnya);
														array_push($datadiskusidanjumlahjawabannya[$id_diskusi][$key]['detail']['datanya'], $totalresponini);
													}
												}
												// create percent and handle error
												$percent = 0;
												if ($highest_value != 0) {
													$percent = ($rp / $highest_value) * 100;
												}
												$percent = number_format($percent, 2);

												?>
												<div class="progress">
													<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo round($percent, 2) ?>%;" aria-valuenow="<?php echo round($percent, 2) ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($percent, 2) . '%' ?></div>
												</div>
												<b><?php echo $totalresponini ?></b>
											</div>
										<?php
										}
										?>
										<div>
											<canvas id="myChart<?= $id_diskusi . $keykategorirespon ?>" height="250"></canvas>
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
		</div>
	</div>
</div>

<!-- modal -->

<!-- create large modal -->


<div class="modal fade" id="modal-data-respond" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 870px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Responden</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="display: inline-flex;flex-wrap: wrap;justify-content: space-between;width: 100%;">
					<div style="display: inline-flex;flex-wrap: wrap;gap: 8px;">
						<button class="prev-response" style="font-size: 11px;
							border: none;
							background-color: white;
							padding: 6px 12px;"><i class="fas fa-chevron-left"></i></button>
						<!-- input type text with 1rem of width -->
						<input type="number" class="urutan_respond" style="width: 3rem;text-align: center;border: none;border-bottom: solid 2px gray;" value="1" max="">
						<span style="padding-top: 4px; line-height: 3;">Of <span id="totalkuesioner"></span></span>
						<button class="next-response" style="font-size: 11px;
							border: none;
							background-color: white;
							padding: 6px 12px;"><i class="fas fa-chevron-right"></i></button>
					</div>
					<button class="btn btn-primary btn-sm" id="btn-print-responden" style="margin-left: 8px;" onclick="printJS('printJS-form', 'html')">
						<i class="fas fa-print"></i>
					</button>

				</div>
				<div class="detail-jawaban-responden" style="padding-top: 1rem;">

				</div>
			</div>
		</div>
	</div>
</div>


<script>

	$(document).ready(function() {

		
		function fetch_detail(urutan){

			var id_kuesioner = "<?php echo $data_kuesioner->id_kuesioner ?>";

			$.ajax({
				url: "<?php echo base_url('Laporan/fetch_detail_responden_individual') ?>",
				method: "POST",
				data: {
					id_kuesioner: id_kuesioner,
					urutan: urutan
				},
				success: function(data) {
					var dt = JSON.parse(data);
					$('.detail-jawaban-responden').html(dt.page);

					$('#totalkuesioner').html(dt.total_resp);
					$('.urutan_respond').attr('max', dt.total_resp);
				}
			});
		}

		$(document).on('input', '.urutan_respond', function() {
			var urutan = $(this).val();
			fetch_detail(urutan);
		});

		$(document).on('click', '.next-response', function() {
			var total_resp = $('#totalkuesioner').text();
			var urutan = parseInt($('.urutan_respond').val());
			if (urutan < total_resp) {
				urutan++;
				$('.urutan_respond').val(urutan);
				fetch_detail(urutan);
			}
		});

		$(document).on('click', '.prev-response', function() {
			var urutan = parseInt($('.urutan_respond').val());
			if (urutan > 1) {
				urutan--;
				$('.urutan_respond').val(urutan);
				fetch_detail(urutan);
			}
		});

		// trigger fetch_detail() when modal-data-respond is shown
		$(document).on('show.bs.modal','#modal-data-respond', function(e) {
			fetch_detail($('.urutan_respond').val());
		})

		$(document).on('click', '.badge-gap', function() {
			var jsonnya = $(this).data('dtl');

			var str = `
			<table style="width: 100%;">
				<thead>
					<tr>
						<th>Indikator</th>
						<th>Skor</th>
					</tr>
				</thead>
				<tbody>
			`;

			for (let key in jsonnya) {

				var p = jsonnya[key].detail

				str += `
					<tr>
						<td>
							<details>
								<summary>
									${jsonnya[key].nama_indikator}
								</summary>
								${
									// return each 
									$.each(p, function(i, val){
									return i + ' : ' + val;
								})}
							</details>
						</td>
						<td style="vertical-align: top;">
							<span class="badge bg-success text-white">${jsonnya[key].total_nilai}</span>
						</td>
					</tr>
				`;
			}

			str += `
				</tbody>
			</table>
			`;

			$('.right-side').html(str);

		})

		<?php
		foreach ($datadiskusidanjumlahjawabannya as $keyiddiskusi => $value) {
			foreach ($value as $key => $x) {
		?>
				var ctx<?= $keyiddiskusi . $key ?> = document.getElementById('myChart<?= $keyiddiskusi . $key ?>').getContext('2d');
				var myChart<?= $keyiddiskusi . $key ?> = new Chart(ctx<?= $keyiddiskusi . $key ?>, {
					type: 'pie',
					data: {
						labels: <?php echo json_encode($x['detail']['label']) ?>,
						datasets: [{
							data: <?php echo json_encode($x['detail']['datanya']) ?>,
							backgroundColor: [<?php
												$datany = $pacuannilai[$x['namakategorirespon']];
												$maxscale = count($datany);
												$urutanwarna = 1;
												foreach ($datany as $key => $value) {
													echo '"' . $this->report_processor->numberToColorHsl($urutanwarna / $maxscale, 0, 1) . '",';
													$urutanwarna++;
												}
												?>]
						}]
					},
					options: {
						tooltips: {
							enabled: true
						},
						plugins: {
							datalabels: {
								formatter: (value, ctx) => {
									let sum = 0;
									let dataArr = ctx.chart.data.datasets[0].data;
									dataArr.map(data => {
										sum += data;
									});
									let percentage = (value * 100 / sum).toFixed(2) + "%";
									return percentage;
								},
								color: '#000',
							}
						}
					}
				});
		<?php
			}
		}
		?>
	})
</script>