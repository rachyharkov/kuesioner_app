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
	<div class="container">
		
	</div>
	<div class="row">
		<div class="col-12">
			<?php

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
									$kr = json_decode($data_kuesioner->kategori_respon, true);

									foreach ($kr as $key => $v) {
										?>
										<div class="col">
										<?php
										echo "<p>".$v['nama']."</p>";
										$namakategorirespon = $v['nama']; 
										$rl = $v['respon_list'];

										$arrayresponlistdantotaljawaban = [];
										
										foreach ($rl as $key => $responnya) {
											$namaresponnya = $responnya;
											$query = "SELECT COUNT(*) AS 'total'
												FROM tbl_jawaban
												WHERE jawaban LIKE '%\"id_kuesioner\":\"".$data_kuesioner->id_kuesioner."\",\"id_diskusi\":\"".$diskusi->id."\"%'
													AND (
														jawaban LIKE '%\"".$namakategorirespon."\":\"".$responnya."\"%'
														)";
											$totaljawabanpadaresponini = $this->db->query($query)->row()->total;
											$arrayresponlistdantotaljawaban[] = array(
																					'nama' => $responnya,
																					'total' => $totaljawabanpadaresponini
																				);
										}
										
										// find the highest value in $arrayresponlistdantotaljawaban array
										$highest_value = max(array_column($arrayresponlistdantotaljawaban, 'total'));

										foreach ($arrayresponlistdantotaljawaban as $key => $rp) {
											?>
											<div style="display: grid;grid-template-columns: 0.2fr 1fr 0.3fr;">
												<!-- create a percent progressbar using php-->
											<?php 
												
												echo $rp['nama'];
												// $totalresponini = 40;
												$totalresponini = $rp['total'];
												// create a percent
												$percent = ($totalresponini / $highest_value) * 100;
											?>
												<div class="progress">
													<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $percent ?>%;" aria-valuenow="<?php echo $percent ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $percent.'%' ?></div>
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