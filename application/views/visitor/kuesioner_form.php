<form id="form_create_action" method="post" enctype="multipart/form-data">
	
	<div class="container" style="padding: 14vh 0; display: block;scroll-snap-align: start;">
		<div class="card" style="width: 100%;">
		  <div class="card-body">
		  	<div style="width: 100%;
text-align: center;
margin: 2vh 0;">
		  		<img src="<?php echo base_url().'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
		  	</div>
		  	<h4><?php echo $data_kuesioner->judul_kuesioner ?></h4>
		  	<p><?php echo $data_kuesioner->deskripsi_kuesioner ?></p>
		    <div class="form__group field">
			  <input type="input" class="form__field" placeholder="Nama Karyawan" name="nama_karyawan" id='nama_karyawan' required />
			  <label for="nama_karyawan" class="form__label">Nama Karyawan</label>
			</div>

			<div class="form__group field">
			  <input type="input" class="form__field" placeholder="Email" name="email" id='email' required />
			  <label for="email" class="form__label">Email</label>
			</div>

			<select class="form-select" aria-label="Default select" name="asal_perusahaan" style="margin-top: 3vh;">
			  <option selected>-pilih asal perusahaan-</option>
			  <?php
			  foreach ($asal_perusahaan as $key => $value) {
			  	?>
			  	<option value="<?php echo $value->id ?>"><?php echo $value->nama_perusahaan ?></option>
			  	<?php
			  }
			  ?>
			</select>
		  </div>
		</div>
	</div>
	<?php
		
		foreach ($list_diskusi as $key => $value) {

			?>
			<input type="hidden" name="soal<?php echo $value->urutan ?>id" value="<?php echo $value->id ?>">
			<div class="container container-<?php echo $value->urutan ?>" style="padding: 30vh 0; display: block;scroll-snap-align: start;">
				<div class="card" style="width: 100%;">
				  <div class="card-body">
				    <p class="card-text"><?php echo $value->detail_diskusi ?></p>

				    <span style="width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold;">Pengalaman</span>
					<div style="text-align: center;">
					    <label for="disc<?php echo $value->urutan ?>_col1_1" class="radio">
						    <input required type="radio" value="STS" name="disc<?php echo $value->urutan ?>_col1" id="disc<?php echo $value->urutan ?>_col1_1" class="hidden"/>
						    <span class="label"></span>STS
						</label>

						<label for="disc<?php echo $value->urutan ?>_col1_2" class="radio">
							<input required type="radio" value="TS" name="disc<?php echo $value->urutan ?>_col1" id="disc<?php echo $value->urutan ?>_col1_2" class="hidden"/>
							<span class="label"></span>TS
						</label>

						<label for="disc<?php echo $value->urutan ?>_col1_3" class="radio">
							<input required type="radio" value="S" name="disc<?php echo $value->urutan ?>_col1" id="disc<?php echo $value->urutan ?>_col1_3" class="hidden"/>
							<span class="label"></span>S
						</label>

						<label for="disc<?php echo $value->urutan ?>_col1_4" class="radio">
							<input required type="radio" value="SS" name="disc<?php echo $value->urutan ?>_col1" id="disc<?php echo $value->urutan ?>_col1_4" class="hidden"/>
							<span class="label"></span>SS
						</label>
					</div>

				    <span style="width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold; margin-top: 2vh;">Harapan</span>
				    <div style="text-align: center;">
				    	
					    <label for="disc<?php echo $value->urutan ?>_col2_1" class="radio">
						    <input required type="radio" value="STP" name="disc<?php echo $value->urutan ?>_col2" id="disc<?php echo $value->urutan ?>_col2_1" class="hidden"/>
						    <span class="label"></span>STP
						</label>

						<label for="disc<?php echo $value->urutan ?>_col2_2" class="radio">
							<input required type="radio" value="TP" name="disc<?php echo $value->urutan ?>_col2" id="disc<?php echo $value->urutan ?>_col2_2" class="hidden"/>
							<span class="label"></span>TP
						</label>

						<label for="disc<?php echo $value->urutan ?>_col2_3" class="radio">
							<input required type="radio" value="P" name="disc<?php echo $value->urutan ?>_col2" id="disc<?php echo $value->urutan ?>_col2_3" class="hidden"/>
							<span class="label"></span>P
						</label>

						<label for="disc<?php echo $value->urutan ?>_col2_4" class="radio">
							<input required type="radio" value="SP" name="disc<?php echo $value->urutan ?>_col2" id="disc<?php echo $value->urutan ?>_col2_4" class="hidden"/>
							<span class="label"></span>SP
						</label>
				    </div>

				  </div>
				</div>
			</div>
			<?php
		}

	?>
	<input type="hidden" name="id_kuesioner" value="<?php echo $data_kuesioner->id_kuesioner ?>">
	<button type="submit" class="btn btn-primary" style="position: absolute;
	right: 3vh;
	bottom: 19vh;
	width: 35vw;">Selesai</button>
</form>
