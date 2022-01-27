<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
<button type="button" class="btn btn-danger list-data">Kembali</button>

<?php

$data_respon = json_decode($data_kuesioner->kategori_respon, TRUE);
$data_dimensi = json_decode($data_kuesioner->dimensi, TRUE);
?>

<?php
	if (!$list_diskusi) {
		?>
		<div class="alert alert-danger" style="margin-top: 1rem;">
			<b>Perhatian</b> tidak ada diskusi yang dibahas ppada kuesioner ini
		</div>
		<?php
	}
?>

<input type="hidden" id="id_kuesioner" value="<?php echo $data_kuesioner->id_kuesioner ?>">

<div id="debugarea">
	
</div>

<form id="form_diskusi" method="post" enctype="multipart/form-data">
	<button type="button" class="btn btn-primary btn-tambah-diskusi">+</button>
	<?php
	$jawabanresponlist = [];

	foreach ($data_respon as $v) {
		foreach ($v['respon_list'] as $y) {
			$jawabanresponlist[] = $y;
		}
	}

	?>
	<table class="table table-bordered table-hover" id="table-diskusi">
		<thead>
			<tr class="nodrag">
				<td rowspan="3">No</td>
				<td rowspan="3">Dimensi</td>
				<td rowspan="3">Indikator</td>
				<td rowspan="3">Diskusi</td>
				<td colspan="<?php echo count($jawabanresponlist) ?>">Response</td>
				<td rowspan="3">Tindakan</td>
			</tr>
			<tr class="nodrag">
				<?php
				foreach ($data_respon as $v) {
					?>
					<td colspan="<?php echo count($v['respon_list']) ?>"><?php echo $v['nama'] ?></td>
					<?php
				}
				?>
			</tr>
			<tr class="nodrag">
				<?php
				foreach($jawabanresponlist as $lmao) {
					?>
					<td><?php echo $lmao ?></td>
					<?php
				}
				?>
			</tr>
		</thead>
		<tbody id="list-of-diskusi">
			<tr id="1" class="baris-diskusi">
				<td>1</td>
				<td>
					<select name="dimensidiskusi1" class="dimensidiskusi">
						<option>-</option>
						<?php
						foreach($data_dimensi as $dd) {
							?>
							<option value="<?php echo $dd['name'] ?>"><?php echo $dd['name'] ?></option>
							<?php
						}
						?>
					</select>
				</td>
				<td>
					<select name="indikatordiskusi1" class="indikatordiskusi">

					</select>
				</td>
				<td><textarea name="diskusi[]">test</textarea></td>
				<?php
				foreach ($jawabanresponlist as $owo) {
					?>
					<td></td>
					<?php
				}
				?>
				<td></td>
			</tr>
		</tbody>
	</table>
</form>
<script type="text/javascript">
	$('.btn-tambah-diskusi').on('click',function(e) {
		e.preventDefault()

		var availablebaris = $('.baris-diskusi').length

		var count = availablebaris + 1

		const html = `

			<tr id="${count}" class="baris-diskusi">
				<td>${count}</td>
				<td>
					<select name="dimensidiskusi${count}" class="dimensidiskusi">
						<option>-</option>
						<?php
						foreach($data_dimensi as $dd) {
							?>
							<option value="<?php echo $dd['name'] ?>"><?php echo $dd['name'] ?></option>
							<?php
						}
						?>
					</select>
				</td>
				<td>
					<select name="indikatordiskusi${count}" class="indikatordiskusi">

					</select>
				</td>
				<td><textarea name="diskusi[]">test</textarea></td>
				<?php
				foreach ($jawabanresponlist as $owo) {
					?>
					<td></td>
					<?php
				}
				?>
				<td><button type="button" class="btn btn-danger btn-delete-diskusi" style="font-size: 10px;
padding: 5px;"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
		`;

		$('#list-of-diskusi').append(html)
		$("#table-diskusi").tableDnD({
			onDrop: function(table, row) {
	            var rows = table.tBodies[0].rows;
	            var debugStr = "Row dropped was "+row.id+". New order: ";
	            for (var i=0; i<rows.length; i++) {
	                debugStr += rows[i].id+" ";
	            }
	            $('#debugarea').html(debugStr);
	        },
	        onDragStart: function(table, row) {
	            $('#debugarea').html("Started dragging row "+row.id);
	        }
		});
	})

	$(document).on('change','.dimensidiskusi', function() {
		console.log('test')
		
		var dimensi = $(this).parents('tr').find('td').eq(1).find('select').val();
		var id_kuesioner = $('#id_kuesioner').val()

		var indikator_diskusi = $(this).parents('tr').find('td').eq(2).find('select')

		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url().'diskusi/get_indikator' ?>",
		    data: {
		    	'id_kuesioner': id_kuesioner,
		    	'dimensi': dimensi
		    },
		    success: function(data){
		        indikator_diskusi.html(data)
		        // alert(data)
		    },
		    error: function(error) {
		        Swal.fire({
		          icon: 'error',
		          title: "Oops!",
		          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
		        })
		    }
		});
	})


</script>