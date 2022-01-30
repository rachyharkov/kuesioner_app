<!-- Chart JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
<?php
/**
 * @param array      $array
 * @param int|string $position
 * @param mixed      $insert
 */
function array_insert(&$array, $position, $insert)
{
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}

$datadiskusidanjumlahjawabannya = [];
?>

<h4><?php echo $data_kuesioner->judul_kuesioner ?></h4>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<p>Total Responden</p>
					<h2><?php echo $total_responden ?></h2>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="card">
				<div class="card-body">
					<p>Today's Respond</p>
					<h2><?php print_r($todays_responden) ?></h2>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4 col-lg-4">
			<div class="row">
				<div class="col-sm-6 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-body">
							<p>Status</p>
							<span class="badge bg-success text-white">Active</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-body">
							<p>Highest Gap</p>
							<span class="badge bg-info text-white">Responsiveness</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
		<?php
			$datadimensi = json_decode($data_kuesioner->dimensi, TRUE);

			$kategori_respon = json_decode($data_kuesioner->kategori_respon, TRUE);

			$datakategorirespondannilai = [];
			
			$anu = [];

			foreach ($kategori_respon as $key => $kresp) {
				$respon = [];	

				foreach ($kresp['respon_list'] as $p => $rl) {
					array_insert($respon, $rl, [
						$rl => $p + 1
					]);
				}
				// array_insert($respon, $kresp['nama'], $respon);
				$datakategorirespondannilai[$kresp['nama']] = $respon;
			}
			
			echo '<pre>';
			// print_r($bbb);

			print_r($datakategorirespondannilai);
			echo '</pre>';
		?>
		</div>
	</div>		
	<div class="row">
		<div class="col-12">
			<?php
				$query = "SELECT *
					FROM tbl_jawaban
					WHERE jawaban LIKE '%\"id_kuesioner\":\"".$data_kuesioner->id_kuesioner."\"%'";
				$jawabanlist = $this->db->query($query)->result();

				$i = 1;
				foreach ($list_diskusi as $diskusi) {
					$datadiskusidanjumlahjawabannya[$diskusi->id] = [];
					?>
					<!-- create card element only with body -->
					<div class="card">
						<div class="card-body">
							<p><?=  $diskusi->isi_diskusi; ?></p>
							
							<div class="container">
								<div class="row">
								<?php
									$id_diskusi = $diskusi->id;
									$kr = json_decode($data_kuesioner->kategori_respon, true);

									foreach ($kr as $keykategorirespon => $v) {
										
										?>
										<div class="col">
										<?php
										echo "<p>".$v['nama']."</p>"; //kategori responnya
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
											
											$maxjawabanperuser = count($json_decode);
											
											$find_array_by_value = array_search($id_diskusi, array_column($json_decode, 'id_diskusi'));

											
											$arrjawabanfound = $json_decode[$find_array_by_value];

											if($arrjawabanfound['id_diskusi'] == $id_diskusi){
												$jawabannyaterkategori = $arrjawabanfound[$namakategorirespon];
										
												$arrayresponlistdantotaljawaban[$jawabannyaterkategori] += 1;
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
													if($value['namakategorirespon'] == $namakategorirespon){
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
													<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo round($percent,2) ?>%;" aria-valuenow="<?php echo round($percent,2) ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($percent,2).'%' ?></div>
												</div>
												<b><?php echo $totalresponini ?></b>
											</div>
											<?php
										}
											?>
											<div>
												<canvas id="myChart<?= $id_diskusi.$keykategorirespon ?>"></canvas>
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
<?php
echo "<pre>";
	print_r($datadiskusidanjumlahjawabannya);
echo "</pre>";
?>

<script>
	$(document).ready(function(){
		
		<?php
		foreach($datadiskusidanjumlahjawabannya as $keyiddiskusi => $value){
			foreach ($value as $key => $x) {
				?>
				var ctx<?= $keyiddiskusi.$key ?> = document.getElementById('myChart<?= $keyiddiskusi.$key ?>').getContext('2d');
				var myChart<?= $keyiddiskusi.$key ?> = new Chart(ctx<?= $keyiddiskusi.$key ?>, {
					type: 'pie',
					data: {
						labels: <?php echo json_encode($x['detail']['label']) ?>,
						datasets: [{
							data: <?php echo json_encode($x['detail']['datanya']) ?>,
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
									let percentage = (value*100 / sum).toFixed(2)+"%";
									return percentage;
								},
								color: '#000',
							},
							colorschemes: {
								scheme: 'brewer.Paired12'
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