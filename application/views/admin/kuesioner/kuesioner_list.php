<style>
	.btn-lock {

		display: inline-block;
		background: #ff5b5b;
		width: 64px;
		height: 64px;
		box-sizing: border-box;
		padding: 11px 0 0 11px;
		border-radius: 50%;
		cursor: pointer;
		-webkit-tap-highlight-color: transparent;
		transform: scale(0.5);
	}

	.btn-lock svg {
		fill: none;
		transform: translate3d(0, 0, 0);
	}

	.btn-lock svg .bling {
		stroke: #fff;
		stroke-width: 2.5;
		stroke-linecap: round;
		stroke-dasharray: 3;
		stroke-dashoffset: 15;
		transition: all 0.3s ease;
	}

	.btn-lock svg .lock {
		stroke: #fff;
		stroke-width: 4;
		stroke-linejoin: round;
		stroke-linecap: round;
		stroke-dasharray: 36;
		transition: all 0.4s ease;
	}

	.btn-lock svg .lockb {
		fill: #fff;
		fill-rule: evenodd;
		clip-rule: evenodd;
		transform: rotate(8deg);
		transform-origin: 14px 20px;
		transition: all 0.2s ease;
	}

	.inpLock {
		display: none;
	}

	.inpLock:checked+label {
		background: #20cca5;
	}

	.inpLock:checked+label svg {
		opacity: 1;
	}

	.inpLock:checked+label svg .bling {
		animation: bling 0.3s linear forwards;
		animation-delay: 0.2s;
	}

	.inpLock:checked+label svg .lock {
		stroke-dasharray: 48;
		animation: locked 0.3s linear forwards;
	}

	.inpLock:checked+label svg .lockb {
		transform: rotate(0);
		transform-origin: 14px 22px;
	}

	@-moz-keyframes bling {
		50% {
			stroke-dasharray: 3;
			stroke-dashoffset: 12;
		}

		100% {
			stroke-dasharray: 3;
			stroke-dashoffset: 9;
		}
	}

	@-webkit-keyframes bling {
		50% {
			stroke-dasharray: 3;
			stroke-dashoffset: 12;
		}

		100% {
			stroke-dasharray: 3;
			stroke-dashoffset: 9;
		}
	}

	@-o-keyframes bling {
		50% {
			stroke-dasharray: 3;
			stroke-dashoffset: 12;
		}

		100% {
			stroke-dasharray: 3;
			stroke-dashoffset: 9;
		}
	}

	@keyframes bling {
		50% {
			stroke-dasharray: 3;
			stroke-dashoffset: 12;
		}

		100% {
			stroke-dasharray: 3;
			stroke-dashoffset: 9;
		}
	}

	@-moz-keyframes locked {
		50% {
			transform: translateY(1px);
		}
	}

	@-webkit-keyframes locked {
		50% {
			transform: translateY(1px);
		}
	}

	@-o-keyframes locked {
		50% {
			transform: translateY(1px);
		}
	}

	@keyframes locked {
		50% {
			transform: translateY(1px);
		}
	}
</style>


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
				<a href="<?php echo base_url() ?>kuesioner/create" class="btn btn-primary mt-4">Tambah Kuesioner</a>
			</div>
			<div class="card-body">
				<table class="table" id="tableKuesioner">
					<thead>
						<tr>
							<th></th>
							<th>Judul</th>
							<th>Jumlah Responden</th>
							<th>Created at</th>
							<th>Created by</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!$list_kuesioner) {
						?>
							<tr>
								<td colspan="6">
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
									<td class="text-center">
										<input class="inpLock switchstatus" type="checkbox" <?php echo $value->status == 0 ? 'checked' : ''; ?> name="checkbox" id="<?php echo $value->id_kuesioner ?>" />
										<label class="btn-lock" for="<?php echo $value->id_kuesioner ?>">
											<svg width="36" height="40" viewBox="0 0 36 40">
												<path class="lockb" d="M27 27C27 34.1797 21.1797 40 14 40C6.8203 40 1 34.1797 1 27C1 19.8203 6.8203 14 14 14C21.1797 14 27 19.8203 27 27ZM15.6298 26.5191C16.4544 25.9845 17 25.056 17 24C17 22.3431 15.6569 21 14 21C12.3431 21 11 22.3431 11 24C11 25.056 11.5456 25.9845 12.3702 26.5191L11 32H17L15.6298 26.5191Z"></path>
												<path class="lock" d="M6 21V10C6 5.58172 9.58172 2 14 2V2C18.4183 2 22 5.58172 22 10V21"></path>
												<path class="bling" d="M29 20L31 22"></path>
												<path class="bling" d="M31.5 15H34.5"></path>
												<path class="bling" d="M29 10L31 8"></path>
											</svg>
										</label>
									</td>
									<td><a href="<?php echo base_url() . 'survey?id=' . encrypt_url($value->id_kuesioner) ?>" target="_blank" rel="noopener noreferrer"><?php echo $value->judul_kuesioner; ?></a></td>
									<td><?php echo 0; ?> </td>
									<td><?php echo $value->created_at ?></td>
									<td><?php echo $value->created_by ?></td>
									<td class="text-center">
										<div class="btn-group" role="group">
											<a href="<?php echo base_url() . 'kuesioner/edit/' . $value->id_kuesioner ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit fa-fw"></i></a>
											<a class="btn btn-success btn-sm" href="<?php echo base_url() . 'kuesioner/export/' . $value->id_kuesioner ?>"><i class="fas fa-file-excel fa-fw"></i></a>
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
<script type="text/javascript">
	$(document).ready(function() {
		$('#tableKuesioner').DataTable({
			responsive: true
		});
	})

	$(document).on('change', '.switchstatus', function() {

		// get state of this checkbox
		var state = $(this).prop('checked');

		var st = 1
		if (state == true) {
			st = 0
		}
		var id = $(this).attr('id')
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() . 'Kuesioner/update_status' ?>",
			data: {
				id: id,
				status: st
			},
			success: function(data) {

				var dt = JSON.parse(data)

				if (dt.response == 'ok') {
					console.log('updated')
				}
			},
			error: function(error) {
				Swal.fire({
					icon: 'error',
					title: "Oops!",
					text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
				})
			}
		});
	});
	$(document).on('click', '.link_delete_kuesioner', function(e) {
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
				window.location.href = '<?php echo base_url() . 'kuesioner/delete/' ?>' + id_kuesioner
			} else {
				btnselected.html('<i class="fas fa-trash-alt"></i>').removeClass('disabled').removeAttr('disabled')
			}
		})
	})
</script>