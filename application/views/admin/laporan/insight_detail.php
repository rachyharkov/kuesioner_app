<!-- Chart JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script>
<style>
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


function hue2rgb($p, $q, $t){
    if($t < 0) { $t++; }
    if($t > 1) { $t--; }
    if($t < 1/6) { return $p + ($q - $p) * 6 * $t; }
    if($t < 1/2) { return $q; }
    if($t < 2/3) { return $p + ($q - $p) * (2/3 - $t) * 6; }
    return $p;
}

function hslToRgb($h, $s, $l){
#    var r, g, b;
	if($s == 0){
		$r = $g = $b = $l; // achromatic
	}else{
		if($l < 0.5){
			$q =$l * (1 + $s);
		} else {
			$q =$l + $s - $l * $s;
		}
		$p = 2 * $l - $q;
		$r = hue2rgb($p, $q, $h + 1/3);
		$g = hue2rgb($p, $q, $h);
		$b = hue2rgb($p, $q, $h - 1/3);
	}
	$return=array(floor($r * 255), floor($g * 255), floor($b * 255));
	return $return;
}

/**
 * Convert a number to a color using hsl, with range definition.
 * Example: if min/max are 0/1, and i is 0.75, the color is closer to green.
 * Example: if min/max are 0.5/1, and i is 0.75, the color is in the middle between red and green.
 * @param i (floating point, range 0 to 1)
 * param min (floating point, range 0 to 1, all i at and below this is red)
 * param max (floating point, range 0 to 1, all i at and above this is green)
 */
function numberToColorHsl($i, $min, $max) {
    $ratio = $i;
    if ($min> 0 || $max < 1) {
        if ($i < $min) {
            $ratio = 0;
        } elseif ($i > $max) {
            $ratio = 1;
        } else {
            $range = $max - $min;
            $ratio = ($i-$min) / $range;
        }
    }
    // as the function expects a value between 0 and 1, and red = 0° and green = 120°
    // we convert the input to the appropriate hue value
    $hue = $ratio * 1.2 / 3.60;
    //if (minMaxFactor!=1) hue /= minMaxFactor;
    //console.log(hue);

    // we convert hsl to rgb (saturation 100%, lightness 50%)
    $rgb = hslToRgb($hue, 1, .5);
    // we format to css value and return
    return 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')'; 
}

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

$query = "SELECT *
	FROM tbl_jawaban
	WHERE jawaban LIKE '%\"id_kuesioner\":\"".$data_kuesioner->id_kuesioner."\"%'";
$jawabanlist = $this->db->query($query)->result();

$datadimensi = json_decode($data_kuesioner->dimensi, TRUE);

$kategori_respon = json_decode($data_kuesioner->kategori_respon, TRUE);

$pacuannilai = [];

$anu = [];

foreach ($kategori_respon as $key => $kresp) {
	$respon = [];	

	foreach ($kresp['respon_list'] as $p => $rl) {
		array_insert($respon, $rl, [
			$rl => $p + 1
		]);
	}
	$pacuannilai[$kresp['nama']] = $respon;
}

// echo '<pre>';

$datakategorirespondannilai = [];

$datadimensiindikatordannilai = [];
foreach ($datadimensi as $key => $value) {
	$temp = [
		"nama_dimensi" => $value['name'],
		"indikator" => []
	];
	
	foreach ($value['indikator'] as $key => $value) {
		$temp['indikator'][$value] = 0;
	}
	
	$datadimensiindikatordannilai[] = $temp;
}

foreach ($kategori_respon as $key => $kresp) {
	$respon = [];

	foreach ($kresp['respon_list'] as $p => $rl) {
		array_insert($respon, $rl, [
			$rl => 0
		]);
	}
	$datakategorirespondannilai[$kresp['nama']] = $respon;
}

foreach ($jawabanlist as $key => $value) {
	$json_decode = json_decode($value->jawaban, TRUE);
	foreach ($json_decode as $keyjd => $value) {
		
		$query = "SELECT * FROM tbl_diskusi WHERE id = '".$value['id_diskusi']."'";
		$diskusi = $this->db->query($query)->row();
		

		if($value['id_diskusi'] == $diskusi->id) {
			// find the index of the $datadimensiindikatordannilai by value
			$index = array_search($diskusi->dimensi, array_column($datadimensiindikatordannilai, 'nama_dimensi'));

			foreach ($kategori_respon as $key => $kresp) {
				$nama_kategori_respon = $kresp['nama'];
				$datadimensiindikatordannilai[$index]['indikator'][$diskusi->indikator] += $pacuannilai[$nama_kategori_respon][$value[$nama_kategori_respon]];
				
				$jawabannya = $json_decode[$keyjd][$nama_kategori_respon];
				$datakategorirespondannilai[$nama_kategori_respon][$jawabannya] += $pacuannilai[$nama_kategori_respon][$jawabannya];
			}
		}
	}
}

// print_r($datadimensiindikatordannilai);
// print_r($datakategorirespondannilai);

$highest_gap = [];

// find the highest value from the $datadimensiindikatordannilai[$indikator] and return key with the highest value
foreach ($datadimensiindikatordannilai as $key => $v) {
	$highest_gap[$v['nama_dimensi']] = max($v['indikator']);
}

// print_r($highest_gap);
$hg = [];
foreach ($highest_gap as $name => $value) {
	$hg[$name] = $value;
}

$datakategorirespondannilai = array_map(function($item) {
	$sum = array_sum($item);
	return $sum;
}, $datakategorirespondannilai);

// print_r($datakategorirespondannilai);

// echo '</pre>';

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
					<a href="#">Detail</a>
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
		<div class="align-self-stretch custom-auto-width d-flex flex-row flex-md-column justify-content-between" style="">
			<div class="align-self-stretch card" style="margin: 0;">
				<div class="card-body">
					<p style="margin: 0;">Highest Gap</p>
					<?php
					foreach ($hg as $key => $value) {
						$color = '#' . substr(md5(rand()), 0, 6);
						echo '<span class="badge text-white" style="background-color:'.$color.'">'.$key.'</span>';
					}
					?>
				</div>
			</div>
			<div class="align-self-stretch card" style="margin: 0;">
				<div class="card-body">
					<p style="margin: 0;">Highest Focus</p>
					<?php
					// generate random color based on length of $hg
					$color = '#' . substr(md5(rand()), 0, 6);
					echo '<span class="badge text-white" style="background-color:'.$color.'">'.array_keys($datakategorirespondannilai, max($datakategorirespondannilai))[0].'</span>';
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<!-- create table with borderless -->
			<table>	
				<?php
				foreach($pacuannilai as $key => $value) {
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
								<span class="badge text-white" style="background-color:<?php echo numberToColorHsl($urutanwarna/$maxscale, 0, 1) ?>"><?php echo $key.'('.$value.')' ?></span>
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
							<p><?=  $diskusi->isi_diskusi; ?></p>
							
							<div class="container">
								<div class="d-flex">
								<?php
									$id_diskusi = $diskusi->id;
									$kr = json_decode($data_kuesioner->kategori_respon, true);

									foreach ($kr as $keykategorirespon => $v) {
										
										?>
										<div class="w-50">
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
											
											$find_array_by_value = array_search($id_diskusi, array_column($json_decode, 'id_diskusi'));

											$arrjawabanfound = $json_decode[$find_array_by_value];

											if($arrjawabanfound['id_diskusi'] == $id_diskusi){
												$jawabannya = $arrjawabanfound[$namakategorirespon];
										
												$arrayresponlistdantotaljawaban[$jawabannya] += 1;
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
												<canvas id="myChart<?= $id_diskusi.$keykategorirespon ?>" height="250"></canvas>
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
// echo "<pre>";
// 	print_r($datadiskusidanjumlahjawabannya);
// echo "</pre>";
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
							backgroundColor: [<?php
								$datany = $pacuannilai[$x['namakategorirespon']];
								$maxscale = count($datany);
								$urutanwarna = 1;
								foreach ($datany as $key => $value) {
									echo '"'.numberToColorHsl($urutanwarna/$maxscale, 0, 1).'",';
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
									let percentage = (value*100 / sum).toFixed(2)+"%";
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