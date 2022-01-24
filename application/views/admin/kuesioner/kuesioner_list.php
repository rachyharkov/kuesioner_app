<?php
	if ($this->session->userdata('success')) {
		?>
			<div class="flash-data" data-flashdata="<?= $this->session->userdata('success'); ?>"></div>
		<?php
	}

	if ($this->session->userdata('failed')) {
		?>
			<div class="flash-data2" data-flashdata="<?= $this->session->userdata('failed'); ?>"></div>
		<?php
	}
?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">List Kuesioner</h4>
        <a href="<?php echo base_url() ?>kuesioner/create" class="btn btn-primary mt-4" >Tambah Kuesioner</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
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
		                Date
					</th>
					<th>
		                Created by
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
							<td><?php echo $value->created_at ?></td>
							<td><?php echo $value->created_by ?></td>
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
</div>

<script type="text/javascript">
	$(document).on('click','.link_delete_kuesioner', function(e) {
    	e.preventDefault()

    	var id_kuesioner = $(this).attr('id')

        var btnselected = $(this)

        btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

    	Swal.fire({
          title: 'Konfirmasi Tindakan',
          text: "Yakin Menghapus kuesioner ini?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
			if (result.isConfirmed) {
				window.location.href = '<?php echo base_url().'kuesioner/delete/'?>' + id_kuesioner
			} else {
				btnselected.html('<i class="fas fa-trash-alt"></i>').removeClass('disabled').removeAttr('disabled')
			}
		})
    })
</script>