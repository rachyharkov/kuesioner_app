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

									foreach ($kr as $key => $v) {
										?>
										<div class="col">
										<?php
										echo "<p>".$v['nama']."</p>"; //kategori responnya
										$namakategorirespon = $v['nama']; 
										$rl = $v['respon_list'];

										$arrayresponlistdantotaljawaban = [];

										foreach ($rl as $key => $v) {
											$arrayresponlistdantotaljawaban[$v] = 0;
										}
										
										foreach ($jawabanlist as $key => $jl) {
											$json_decode = json_decode($jl->jawaban, TRUE);
											// find array by value of key id_diskusi from json_decode
											$find_array_by_value = array_search($id_diskusi, array_column($json_decode, 'id_diskusi'));
											$arrjawabanfound = $json_decode[$find_array_by_value];

											$jawabannyaterkategori = $arrjawabanfound[$namakategorirespon];
											$arrayresponlistdantotaljawaban[$jawabannyaterkategori] += 1;
											
										}

										$highest_value = max($arrayresponlistdantotaljawaban);
										foreach ($arrayresponlistdantotaljawaban as $key => $rp) {
											?>
											<div style="display: grid;grid-template-columns: 0.2fr 1fr 0.3fr;">
												<!-- create a percent progressbar using php-->
											<?php 
												// find highest value of array $arrayresponlistdantotaljawaban[$key]
												echo $key;
												$totalresponini = $rp;
												// create a percent
												$percent = ($totalresponini / $highest_value) * 100;
												// $percent = $totalresponini;
											?>
												<div class="progress">
													<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo round($percent,2) ?>%;" aria-valuenow="<?php echo round($percent,2) ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($percent,2).'%' ?></div>
												</div>
												<b><?php echo $totalresponini ?></b>
											</div>
											<?php
										}
											?>
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