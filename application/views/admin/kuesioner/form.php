<form id="form_create_kuesioner" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="labelInputJudulKuesioner" class="form-label">Judul</label>
    <input type="text" name="judul_kuesioner" class="form-control" id="labelInputJudulKuesioner">
  </div>
  <div class="mb-3">
    <label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
    <input type="text" name="deskripsi_kuesioner" class="form-control" id="labelInputDeskripsiKuesioner">
  </div>
  <table class="table table-bordered" id="dynamic_field">
    <tr id="row0">
      <td>
        <input type="text" name="nama_berkas[]" placeholder="Dimensi" class="form-control nama_berkas" required/>
        <table class="tabel_indicator_row">
          
        </table>
        <span style="font-size: 11px;">Dimensi memiliki indikator? <a href="#" class="add_indicator">Tambah Indikator</a></span>
      </td>

      <td><button type="button" id="add_dimensi" class="btn btn-success">Add More</button></td>
    </tr>
  </table>
  <div class="mb-3">
  	
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="button" class="btn btn-danger list-data">Kembali</button>
</form>