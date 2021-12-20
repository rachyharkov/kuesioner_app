<form id="form_create_kuesioner" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="labelInputJudulKuesioner" class="form-label">Judul</label>
    <input type="text" name="judul_kuesioner" class="form-control" id="labelInputJudulKuesioner" required>
  </div>
  <div class="mb-3">
    <label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
    <input type="text" name="deskripsi_kuesioner" class="form-control" id="labelInputDeskripsiKuesioner" required>
  </div>
  <table class="table table-bordered" id="dimensi_table">
    <tr id="row0" class="baris_dimensi">
      <td>
        <input type="text" name="dimensi[]" placeholder="Dimensi" class="form-control dimensi" required/>
        <table class="tabel_indicator_row">
          
        </table>
        <span style="font-size: 11px;">Dimensi memiliki indikator? <a href="#" class="add_indicator">Tambah Indikator</a></span>
      </td>

      <td><button type="button" id="add_dimensi" class="btn btn-success">Add More</button></td>
    </tr>
  </table>
  <table class="table table-bordered" id="kategori_response_table">
    <tr id="row0" class="baris_kategori_respon">
      <td>
        <input type="text" name="kategori_respon[]" placeholder="kategori_respon" class="form-control kategori_respon" required/>
        <table class="tabel_pilihan_row">
          
        </table>
        <span style="font-size: 11px;">Memiliki pilihan? <a href="#" class="add_pilihan">Tambah pilihan</a></span>
      </td>

      <td><button type="button" id="add_kategori_respon" class="btn btn-success">Add More</button></td>
    </tr>
  </table>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="button" class="btn btn-danger list-data">Kembali</button>
</form>