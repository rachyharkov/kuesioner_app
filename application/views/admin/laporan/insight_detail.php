<h4><?php echo $judul_kuesioner ?></h4>
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
</div>