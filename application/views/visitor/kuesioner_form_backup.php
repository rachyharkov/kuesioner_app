
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
.select2-container .select2-selection--single {
    height: 36px;
}

.scroll-to-down-anim {
  height: 3vh;
  position: relative;
  width: 100%;
}

.scroll-to-down-anim::before {
  	animation: bounce 1s ease infinite;
	bottom: -2rem;
	color: black;
	content: '╲╱';
	font-size: 2rem;
	height: 3rem;
	left: 50%;
	letter-spacing: -1px;
	line-height: 4rem;
	margin-left: -3rem;
	opacity: 0.8;
	position: absolute;
	text-align: center;
	width: 6rem;
}

@keyframes bounce {
  50% {
    transform: translateY(-50%);
  }
}

</style>

<form id="form_create_action" method="post" enctype="multipart/form-data">
	
	<div class="container" style="padding: 7vh 0;
display: block;
scroll-snap-align: start;">
		<div class="card" style="width: 100%;">
		  <div class="card-body">
		  	<div style="width: 100%;
text-align: center;
margin: 2vh 0;">
		  		<img src="<?php echo base_url().'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
		  	</div>
		  	<h4><?php echo $data_kuesioner->judul_kuesioner ?></h4>
		  	<p><?php echo $data_kuesioner->deskripsi_kuesioner ?></p>
		  	<div>
		  		<p style="font-style: italic;
font-size: 13px;">Terdapat dua (2) kolom respon yang masing-masing terdapat pilihan, pada pilihan berikut terdapat singkatan:</p>
		  		<div style="font-size: 13px;
display: flex;
justify-content: center;">
					<div class="card" style="position: relative;margin: 0px 5px;">
						<span class="badge rounded-pill bg-primary" style="position: absolute;
left: 1em;
top: -13px;">Kesesuaian Pengalaman</span>
						<div class="card-body">
					  		<ul>
					  			<li>STS = <b>Sangat Tidak Sesuai</b></li>
					  			<li>TS = <b>Tidak Sesuai</b></li>
					  			<li>S = <b>Sesuai</b></li>
					  			<li>SS = <b>Sangat Sesuai</b></li>
					  		</ul>
						</div>
					</div>
					<div class="card" style="position: relative;margin: 0px 5px;
">
						<span class="badge rounded-pill bg-primary" style="position: absolute;
left: 1em;
top: -13px;">Tingkat Kepentingan</span>
						<div class="card-body">
					  		<ul>
					  			<li>STP = <b>Sangat Tidak Penting</b></li>
					  			<li>TP = <b>Tidak Penting</b></li>
					  			<li>P = <b>Penting</b></li>
					  			<li>SP = <b>Sangat Penting</b></li>
					  		</ul>
						</div>
					</div>
		  		</div>
		  	</div>

		  	<div class="scroll-to-down-anim"></div>
		  	
		  </div>
		</div>
	</div>

	<div class="container" style="padding: 8vh 0; display: block;scroll-snap-align: start;">
		<div class="card" style="width: 100%;">
		  <div class="card-body">
		  	<div style="width: 100%;
text-align: center;
margin: 2vh 0;">
		  		<img src="<?php echo base_url().'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
		  	</div>
		    <div class="form__group field">
			  <input type="input" class="form__field" placeholder="Nama Karyawan" name="nama_karyawan" id='nama_karyawan' required />
			  <label for="nama_karyawan" class="form__label">Nama Karyawan</label>
			</div>

			<div class="form__group field">
			  <input type="input" class="form__field" placeholder="Email" name="email" id='email' required />
			  <label for="email" class="form__label">Email</label>
			</div>

			<div class="form-group">
				<select class="form-select" aria-label="Default select" name="direktorat" style="margin: 3vh 0;">
				  <option selected>- Pilih Direktorat -</option>
				  <?php
				  foreach ($direktorat as $key => $value) {
				  	?>
				  	<option value="<?php echo $value->id ?>"><?php echo $value->nama_perusahaan ?></option>
				  	<?php
				  }
				  ?>
				</select>
			</div>

			<div class="form-group" style="margin-top: 4vh;">
				<select class="select-uwu1" name="unit_kerja" style="width: 100%;">
				  <?php

				  $arrunitkerja = [
				  	'Kompartemen Sekretaris Perusahaan',
				  	'Kompartemen Komunikasi',
				  	'Kompartemen Satuan Pengawas Intern',
				  	'Kompartemen Manajemen Risiko',
				  	'Kompartemen Human Capital',
				  	'Kompartemen Learning & Development Center',
				  	'Kompartemen Corporate Services & PKBI',
				  	'Kompartemen Keuangan & Perbendaharaan',
				  	'Kompartemen Akuntansi',
				  	'Kompartemen Kinerja Korporat',
				  	'KompartemenNama  Strategic Office',
				  	'Kompartemen Teknologi Informasi',
				  	'Kompartemen Operasi & Produksi',
				  	'Kompartemen Pengadaan Strategis',
				  	'Kompartemen Pengadaan Operasional',
				  	'Kompartemen Perencanaan Pengadaan',
				  	'Kompartemen Strategic Marketing',
				  	'Kompartemen Logistic Optimation',
				  	'Kompartemen PSO Wilayah 1',
				  	'Kompartemen PSO Wilayah 2',
				  	'Kompartemen PSO Planning Management',
				  	'Kompartemen Commercial Marketing',
				  	'Kompartemen Pengembangan Korporat',
				  	'Kompartemen Portofolio Bisnis',
				  	'Kompartemen Indonesia Fertilizer Research Institute'
				  ];

				  foreach ($arrunitkerja as $value) {
				  	?>
				  	<option value="<?php echo $value ?>"><?php echo $value ?></option>
				  	<?php
				  }
				  ?>
				</select>
			</div>

			<div class="form-group" style="margin-top: 4vh;">
				<select class="select-uwu2" name="job_grade" style="width: 100%;">
				  <?php

				  $arrjobgrade = [
				  	'1A',
				  	'1B',
				  	'2A',
				  	'2B',
				  	'3A',
				  	'3B',
				  	'4A',
				  	'4B',
				  	'5A',
				  	'5B',
				  	'6A',
				  	'6B'
				  ];

				  foreach ($arrjobgrade as $value) {
				  	?>
				  	<option value="<?php echo $value ?>"><?php echo $value ?></option>
				  	<?php
				  }
				  ?>
				</select>
			</div>

			<div class="form-group">
				<select class="form-select" aria-label="Default select" name="status_karyawan" style="margin: 3vh 0;">
				  <option selected>- Pilih Status Karyawan -</option>
				  <option value="Karyawan PI">Karyawan PI</option>
				  <option value="Karyawan Non Mutasi">Karyawan Non Mutasi</option>
				</select>
			</div>

			<div class="form__group field">
			  	<input type="input" class="form__field" placeholder="Nama Jabatan" name="nama_jabatan" id='nama_jabatan' required />
			  	<label for="nama_jabatan" class="form__label">Nama Jabatan</label>
			</div>

		  </div>
		</div>
	</div>
	<?php
		
		foreach ($list_diskusi as $key => $value) {

			?>
			<input type="hidden" name="soal<?php echo $value->urutan ?>id" value="<?php echo $value->id ?>">
			<div class="container container-<?php echo $value->urutan ?>" style="padding: 30vh 0; display: block;scroll-snap-align: start;">
				<div class="card" style="width: 100%; position: relative;">
					<span class="badge rounded-pill bg-secondary" style="position: absolute;
left: 50%;
top: -13px;
transform: scale(1.4);"><?php echo $value->urutan ?></span>
				  <div class="card-body">
				    <p class="card-text"><?php echo $value->detail_diskusi ?></p>

				    <span style="width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold;">Kesesuaian Pengalaman</span>
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

				    <span style="width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold; margin-top: 2vh;">Tingkat Kepentingan</span>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$('.select-uwu1').select2({
			placeholder: "Pilih Unit Kerja",
			allowClear: true
		});

		$('.select-uwu2').select2({
			placeholder: "Pilih Job Grade",
			allowClear: true
		});
	})

</script>