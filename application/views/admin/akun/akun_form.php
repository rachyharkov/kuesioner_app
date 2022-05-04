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
				Akun Saya
			</div>
			<div class="card-body">
                <form id="form-update-password">
                    <div class="form-column">
                        <div class="form-group col-md-6">
                            <label for="inputoldPassword">Update Password</label>
                            <input type="password" class="form-control" id="inputoldPassword" name="inputoldPassword" placeholder="Password">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" class="form-control" id="inputnewPassword" name="inputnewPassword" placeholder="Password Baru">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" class="form-control" id="inputconfirmnewPassword" name="inputconfirmnewPassword" placeholder="Konfirmasi Password ">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
			<div class="card-footer">
		      	
		    </div>
  		</div>
  	</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {



        $('#form-update-password').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(this);
            $.ajax({
                url: '<?php echo base_url('akun/update_password'); ?>',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {

                    var dt = JSON.parse(response);

                    if(dt.status == 'wrong_confirm') {
                        Swal.fire({
                            title: "Terjadi Kesalahan",
                            text: dt.message,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    } else if(dt.status == 'success') {
                        Swal.fire({
                            title: "Password Berhasil Diubah",
                            text: "Password berhasil diubah",
                            type: "success",
                            confirmButtonText: "Ok"
                        });

                        $('#form-update-password')[0].reset();
                    } else {
                        Swal.fire({
                            title: "Terjadi Kesalahan",
                            text: dt.message,
                            type: "error",
                            confirmButtonText: "Ok"
                        });
                    }
                },
                error: function(response) {
                    Swal.fire({
                        title: "Terjadi Kesalahan",
                        text: "Silahkan coba lagi",
                        type: "error",
                        confirmButtonText: "Ok"
                    });
                }
            });
        });
    });
</script>