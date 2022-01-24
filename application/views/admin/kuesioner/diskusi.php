<style>
	
	table {
    	counter-reset: tableCount;     
	}
	.counterCell:before {              
	    content: counter(tableCount); 
	    counter-increment: tableCount; 
	}

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
<button type="button" class="btn btn-danger list-data">Kembali</button>

<?php

$data_respon = json_decode($data_kuesioner->kategori_respon, TRUE);
$data_dimensi = json_decode($data_kuesioner->dimensi, TRUE);
?>

<?php
	$action = 'form_diskusi_edit';

	if (!$list_diskusi) {
		?>
		<div class="alert alert-danger" style="margin-top: 1rem;">
			<b>Perhatian</b> tidak ada diskusi yang dibahas ppada kuesioner ini
		</div>
		<?php
		$action = 'form_diskusi_new';
	}
?>

<form id="<?php echo $action ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" id="id_kuesioner" name="id_kuesioner" value="<?php echo $data_kuesioner->id_kuesioner ?>">
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
				<td hidden colspan="<?php echo count($jawabanresponlist) ?>">Response</td>
				<td rowspan="3">Tindakan</td>
			</tr>
			<tr class="nodrag">
				<?php
				foreach ($data_respon as $v) {
					?>
					<td hidden colspan="<?php echo count($v['respon_list']) ?>"><?php echo $v['nama'] ?></td>
					<?php
				}
				?>
			</tr>
			<tr class="nodrag">
				<?php
				foreach($jawabanresponlist as $lmao) {
					?>
					<td hidden><?php echo $lmao ?></td>
					<?php
				}
				?>
			</tr>
		</thead>
		<tbody id="list-of-diskusi">
			<?php

			if ($list_diskusi) {
				foreach ($list_diskusi as $ld) {
					?>
					<input type="hidden" name="id_diskusi<?php echo $ld->urutan ?>" value="<?php echo $ld->id ?>"/>
					<tr id="<?php echo $ld->urutan ?>" class="baris-diskusi">
						<td class="counterCell"></td>
						<td>
							<select name="dimensidiskusi<?php echo $ld->urutan ?>" class="dimensidiskusi">
								<option>-</option>
								<?php
								foreach($data_dimensi as $dd) {
									?>
									<option value="<?php echo $dd['name'] ?>" <?php echo $ld->dimensi == $dd['name'] ? 'selected' : ''; ?>><?php echo $dd['name'] ?></option>
									<?php
								}
								?>
							</select>
						</td>
						<td hidden><input type="hidden" name="barisdiskusi[]" value="1"/></td>
						<td>
							<select name="indikatordiskusi<?php echo $ld->urutan ?>" class="indikatordiskusi">
								<?php
								foreach($data_dimensi as $dd) {
									if ($dd['name'] == $ld->dimensi) {
										$classnyak->get_indikator($data_kuesioner->id_kuesioner, $dd['name']);
									}
								}
								?>
							</select>
						</td>
						<td><textarea name="isidiskusi<?php echo $ld->urutan ?>"><?php echo $ld->isi_diskusi ?></textarea></td>
						<?php
						foreach ($jawabanresponlist as $owo) {
							?>
							<td hidden></td>
							<?php
						}
						?>
						<td><button type="button" class="btn btn-danger btn-delete-diskusi" style="font-size: 10px;
		padding: 5px;"><i class="fas fa-trash-alt"></i></button></td>
					</tr>
					<?php	
				}
			}

			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<?php echo count($v['respon_list']) + 5 ?>"><button type="button" class="btn btn-primary btn-tambah-diskusi" style="position: fixed;bottom: 1rem;right: 1rem;"><i class="fas fa-plus"></i></button>
					<button type="submit" class="btn btn-success btn-save-all-diskusi" style="position: fixed;bottom: 1rem;right: 4rem;"><i class="fas fa-save"></i></button></td>
			</tr>
		</tfoot>
	</table>
</form>
<script type="text/javascript">

	function sortNewincrement() {
		let count = 1
		$('.baris-diskusi').each(function() {
			$(this).attr('id', count)
			$(this).find('td').eq(1).find('select').attr('name', 'dimensidiskusi' + count)
			$(this).find('td').eq(3).find('select').attr('name', 'indikatordiskusi' + count)
			$(this).find('td').eq(4).find('textarea').attr('name', 'isidiskusi' + count)
			count++
		})
	}

	$('.btn-tambah-diskusi').on('click',function(e) {
		e.preventDefault()

		var availablebaris = $('.baris-diskusi').length

		var count = availablebaris + 1

		const html = `

			<tr id="${count}" class="baris-diskusi">
				<td class="counterCell"></td>
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
				<td hidden><input type="hidden" name="barisdiskusi[]" value="1"/></td>
				<td>
					<select name="indikatordiskusi${count}" class="indikatordiskusi">

					</select>
				</td>
				<td><textarea name="isidiskusi${count}">test</textarea></td>
				<?php
				foreach ($jawabanresponlist as $owo) {
					?>
					<td hidden></td>
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
				sortNewincrement()
            // var rows = table.tBodies[0].rows;
            // var debugStr = "Row dropped was "+row.id+". New order: ";
            // for (var i=0; i<rows.length; i++) {
            //     debugStr += rows[i].id+" ";
            // }
            // $('#debugarea').html(debugStr);
        	},
		});
		// {
		// 	
	 //        onDragStart: function(table, row) {
	 //            // $('#debugarea').html("Started dragging row "+row.id);
	 //        }
		// }
	})

	$(document).on('change','.dimensidiskusi', function() {
		console.log('test')
		
		var dimensi = $(this).parents('tr').find('td').eq(1).find('select').val();
		var id_kuesioner = $('#id_kuesioner').val()

		var indikator_diskusi = $(this).parents('tr').find('td').eq(3).find('select')

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

	$(document).on('click', '.btn-delete-diskusi', function() {
		$(this).parents('tr').remove()
		sortNewincrement()
	})


</script>