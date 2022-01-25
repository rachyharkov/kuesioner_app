<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.4/r-2.2.9/sl-1.3.4/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.4/r-2.2.9/sl-1.3.4/datatables.min.js"></script>
<style>
	
	table td {
		border: none !important;
	}

	.tabel_pilihan_row {
		margin-top: 0.6rem;
	}

	.tabel_indicator_row {
		margin-top: 0.6rem;	
	}

</style>

<div class="row">
  	<div class="col-md-12">
	    <div class="card">
			<div class="card-header">
				Kuesioner Insight
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-6">
							<div class="container" style="display: flex; flex-direction: column; justify-content: center; text-align: center; min-height: 40vh; color: gray;">
								<i class="now-ui-icons ui-2_chat-round mb-2" style="font-size: 3.5rem"></i>
								<p style="font-size: 0.8rem">Informasi terkait kuesioner akan muncul disini, pilih kuesioner yang tersedia di bagian kanan layar</p>
							</div>
						</div>
						<div class="col-6">
							<table class="table" id="tabel_kuesioner">
					            <thead class=" text-primary">
					              	<tr>
					              		<th hidden>
					              			ID
					              		</th>
						              	<th>
						                	Judul Kuesioner
							            </th>
							            <th>
							                Responded
										</th>
							            <th>
							                Action
										</th>
						           	</tr>
						        </thead>
					            <tbody>
					            	<?php
									if (!$list_kuesioner) {
									?>
										<tr>
											<td colspan="5">
												<div class="alert alert-danger text-center">
												 		Tidak ada kuesioner
												</div>	
											</td>
										</tr>
									<?php
									} else {
										foreach ($list_kuesioner as $key => $value) {
											?>
											<tr>
												<td hidden><?php echo $value->id_kuesioner ?></td>
												<td><a href="<?php echo base_url().'preview/'.$value->id_kuesioner ?>"><?php echo $value->judul_kuesioner; ?></a></td>
												<td><?php echo 0; ?> </td>
												<td class="text-center">
													<div class="btn-group" role="group">
														<a href="<?php echo base_url().'kuesioner/edit/'.$value->id_kuesioner ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit fa-fw"></i></a>
														<a class="btn btn-success btn-sm" href="<?php echo base_url().'kuesioner/export/'.$value->id_kuesioner ?>"><i class="fas fa-file-excel fa-fw"></i></a>
														<a id="<?php echo $value->id_kuesioner ?>" class="btn btn-danger btn-sm text-white link_delete_kuesioner"><i class="fas fa-trash-alt fa-fw"></i></a>
													</div>
												</td>
											</tr>
										<?php
										}
									}
									?>
					            </tbody>
					        </table>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
		      	
		    </div>
  		</div>
  	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    var table = $('#tabel_kuesioner').DataTable();
	 
	    $('#tabel_kuesioner tbody').on( 'click', 'tr', function () {
	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	        }
	        else {
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected');
	        }
	    });
	 
	});
</script>