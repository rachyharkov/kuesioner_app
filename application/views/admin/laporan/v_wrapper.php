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

	table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected {
	    background-color: #1a344a !important;
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
						<div class="col-sm-12 col-md-7 col-lg-7 kuesioner-info-overview">
							<div class="container" style="display: flex; flex-direction: column; justify-content: center; text-align: center; min-height: 40vh; color: gray;">
								<i class="now-ui-icons ui-2_chat-round mb-2" style="font-size: 3.5rem"></i>
								<p style="font-size: 0.8rem">Informasi terkait kuesioner akan muncul disini, pilih kuesioner yang tersedia di bagian kanan layar</p>
							</div>
						</div>
						<div class="col-sm-12 col-md-5 col-lg-5">
							<div class="container-fluid">
								<table class="table" id="tabel_kuesioner">
						            <thead class=" text-primary">
						              	<tr>
						              		<th hidden>
						              			ID
						              		</th>
							              	<th>
							                	Judul Kuesioner
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
												<tr id="<?php echo $value->id_kuesioner ?>">
													<td hidden><?php echo $value->id_kuesioner ?></td>
													<td><?php echo $value->judul_kuesioner; ?></td>
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
			</div>
			<div class="card-footer">
		      	
		    </div>
  		</div>
  	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    var table = $('#tabel_kuesioner').DataTable({
	    	responsive: true
	    });
	 
	    $('#tabel_kuesioner tbody').on( 'click', 'tr', function () {
	        if ( $(this).hasClass('selected') ) {
	            $(this).removeClass('selected');
	            $('.kuesioner-info-overview').html(`
	            	<div class="container" style="display: flex; flex-direction: column; justify-content: center; text-align: center; min-height: 40vh; color: gray;">
						<i class="now-ui-icons ui-2_chat-round mb-2" style="font-size: 3.5rem"></i>
						<p style="font-size: 0.8rem">Informasi terkait kuesioner akan muncul disini, pilih kuesioner yang tersedia di bagian kanan layar</p>
					</div>
	            	`)
	        }
	        else {
	        	var id_kuesioner = $(this).attr('id')
	            table.$('tr.selected').removeClass('selected');
	            $(this).addClass('selected')

	            $('.kuesioner-info-overview').html(`
	            	<div class="container" style="display: flex; flex-direction: column; justify-content: center; text-align: center; min-height: 40vh; color: gray;">
						<i class="fas fa-sync fa-spin" style="font-size: 3.5rem; margin: auto;"></i>
						<p style="font-size: 0.8rem">Mengambil data ${id_kuesioner}...</p>
					</div>
	            	`)

	            $.ajax({
				    type: "GET",
				    url: "<?php echo base_url().'laporan/detail_kuesioner/' ?>" + id_kuesioner,
				    success: function(data){
				    	var dt = JSON.parse(data)

				    	if (dt.response == 'ok') {
				    		$('.kuesioner-info-overview').html(dt.page)
				    	}
				    },
				    error: function(error) {
				        Swal.fire({
				          icon: 'error',
				          title: "Oops!",
				          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
				        })
				        $('.kuesioner-info-overview').html(`
			            	<div class="container" style="display: flex; flex-direction: column; justify-content: center; text-align: center; min-height: 40vh; color: gray;">
								<i class="fas fa-times" style="font-size: 3.5rem; margin: auto;"></i>
								<p style="font-size: 0.8rem">Terjadi kesalahan...</p>
							</div>
			            	`)
				        $(this).removeClass('selected');
				    }
				});
	        }
	    });
	 
	});
</script>