<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Master Data List</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/b-print-2.0.1/r-2.2.9/sc-2.0.5/sb-1.3.0/datatables.min.css"/>
</head>
<body>

<div id="container" style="padding: 15%;">
	<button class="btn btn-primary btn-xs" id="btn-uploaddayone" style="margin-bottom: 15px;">Upload Absen</button>
	<div hidden="">
		<!--TUNE DAY HERE-->
		<form role="form" method="POST" action="<?php echo base_url().'Welcome/upload/'.$id_masterdata?>" method="post" enctype="multipart/form-data" id="form-uploaddatautama">
			<input type="file" name="excel-datautama" id="input-uploaddatautama">	
			
		</form>
	</div>
	<div class="container">
		<table class="table table-responsive table-hover table-bordered" id="datatable-data">
			<thead>
				<tr>
					<?php

					foreach ($columnsmasterdata as $key => $showcolumnname) {
						?>
						<th><?php echo $showcolumnname->name ?></th>
						<?php
					}

					?>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				if (!$masterdata) {
					?>
					<tr>
						<td align="center" colspan="<?php echo count($columnsmasterdata) ?>">NO DATA</td>
					</tr>
					<?php
				} else {
					foreach ($masterdata as $key => $value) {
						?>
						<tr>
							<?php
								foreach ($columnsmasterdata as $showcolumnname) {
								?>
									<td><?php 
									$p = $showcolumnname->name;
									echo $value->$p; ?></td>
								<?php
							}?>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.0.1/b-html5-2.0.1/b-print-2.0.1/r-2.2.9/sc-2.0.5/sb-1.3.0/datatables.min.js"></script>
<script type="text/javascript">
		
	$(document).ready(function() {
		$('#datatable-data').DataTable({
			dom: 'Bfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ]
		});

		$('#btn-uploaddayone').on('click',function() {
			$('#input-uploaddatautama').click()
		})

		$('#input-uploaddatautama').change(function() {
			$('#form-uploaddatautama').submit()
		})
	})

</script>
</body>
</html>