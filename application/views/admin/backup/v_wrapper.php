<style>
    .btn-status-status {
        font-size: 11px;
        border-radius: 55%;
        width: 18px;
        height: 18px;
        text-align: center;
        padding: 0px;
    }

    .tooltip {
      position: relative;
      opacity: 1 !important;
    }
    .tooltip:before,
    .tooltip:after {
      display: block;
      opacity: 0;
      pointer-events: none;
      position: absolute;
    }
    .tooltip:after {
    	border-right: 6px solid transparent;
    	border-bottom: 6px solid rgba(0,0,0,.75); 
      border-left: 6px solid transparent;
      content: '';
      height: 0;
        top: 20px;
        left: 20px;
      width: 0;
    }
    .tooltip:before {
      background: rgba(0,0,0,.75);
      border-radius: 2px;
      color: #fff;
      content: attr(data-title);
      font-size: 14px;
      padding: 6px 10px;
        top: 26px;
      white-space: nowrap;
    }

    /* the animations */
    /* fade */
    .tooltip.fade:after,
    .tooltip.fade:before {
      transform: translate3d(0,-10px,0);
      transition: all .15s ease-in-out;
    }
    .tooltip.fade:hover:after,
    .tooltip.fade:hover:before {
      opacity: 1;
      transform: translate3d(0,0,0);
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Backup</h5>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Backup</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <p style="text-align: center;">Silahkan pilih tindakan yang ingin anda lakukan terkait backup dibawah ini</p>
                <ul class="nav nav-tabs" role="tablist" style="justify-content: center;">
                    <li class="nav-item">
                        <a class="nav-link" href="#export" role="tab" data-toggle="tab"><span><i class="now-ui-icons arrows-1_cloud-download-93"></i></span> Export</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#import" role="tab" data-toggle="tab"><span><i class="now-ui-icons arrows-1_cloud-upload-94"></i></span> Import</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="export">
                        <table class="table table-borderless">
                            <thead>
                                <tr style="font-size: 12px;">
                                    <th>Apa yang ingin anda export?</th>
                                    <th>Format</th>
                                </tr>
                            </thead>
                            <?php
                            $arrthingstoexport = [
                                0 => [
                                    'nama' => 'Kuesioner'
                                ],
                                1 => [
                                    'nama' => 'Respon'
                                ],
                                2 => [
                                    'nama' => 'Form Individu'
                                ],
                            ]
                            ?>
                            <tbody>
                                <tr>
                                    <td style="width: 10rem;">
                                        <select class="form-control type_export" name="type_export">
                                            <option value="">- pilih -</option>
                                            <?php
                                            foreach ($arrthingstoexport as $key => $value) {
                                            ?>
                                                <option value="<?= $key ?>"><?= $value['nama'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td style="width: 10rem;">
                                        <select class="form-control">
                                            <option value="">- pilih -</option>
                                            <option value="json">.json</option>
                                            <option value="xls">.xls</option>
                                            <option value="xlsx">.xlsx</option>
                                            <option value="csv">.csv</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="container data_wrapper">

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="import">
                        <div id="step-1">
                            <table class="table table-borderless">
                                <thead>
                                    <tr style="font-size: 12px;">
                                        <th>Upload</th>
                                        <th>Jenis</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 20rem;">
                                            <input type="file" class="form-control" accept=".xlsx,.xls" name="input-upload" id="input-upload">
                                        </td>
                                        <td>
                                            <p class="jenis-msg m-0">-</p>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                                            <button disabled class="btn btn-primary btn-confirm-import">Import</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="<?php echo base_url() ?>backup/import_template" target="_blank">Unduh Template Kuesioner</a>
                        </div>
                        <div id="step-2" style="display: none;">

                            <div class="alert alert-success alert-dismissible mt-4 fade show" role="alert" id="alert-danger">
                                <strong>Mengalami Masalah?</strong> <span id="alert-danger-msg">silahkan refresh ulang halaman dan mulai dari tahap awal</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <p>Silahkan masukan data terkait kuesioner dengan menentukan judul, deskripsi, dan tentukan kategori respon serta apa saja jawaban yang akan dipilih oleh para responden pada kuesioner ini</p>

                            <form id="form_kuesioner_new">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label for="labelInputJudulKuesioner" class="form-label">Judul</label>
                                            <input type="text" name="judul_kuesioner" class="form-control" id="labelInputJudulKuesioner" required style="font-size: 1.1rem;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="labelInputDeskripsiKuesioner" class="form-label">Deskripsi</label>
                                            <textarea name="deskripsi_kuesioner" rows="4" class="form-control" id="labelInputDeskripsiKuesioner" required placeholder="Masukan Deskripsi"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <table class="table table-borderless" id="kategori_response_table">
                                            <tr id="row0" class="baris_kategori_respon">
                                                <td>
                                                    <input type="text" name="kategori_respon[]" placeholder="Masukan nama kategori jawaban" class="form-control kategori_respon" required />
                                                    <table class="tabel_pilihan_row">

                                                    </table>
                                                    <span style="font-size: 11px;"><a href="#" class="add_pilihan">Tambah pilihan</a></span>
                                                </td>

                                                <td style="vertical-align: top;"><button type="button" id="add_kategori_respon" class="btn btn-success btn-sm"><i class="now-ui-icons ui-1_simple-add"></i></button></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="dataaa">
                                    <input type="text" name="dimensi" class="tbdimensi" value="" />
                                    <input type="text" name="diskusilist" class="tbdiskusilist" value="" />
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-export" tabindex="-1" aria-labelledby="modal-exportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-exportLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function show_modal_export() {
        $('#modal-export').modal('show');
    }

    $(document).on('click', '.btn-confirm-import', function() {
        // show modal-importconfirm modal
        $(this).html('<i class="fas fa-spinner fa-spin"></i>').attr('disabled', true);

        setTimeout(function() {
            $('#step-1').css('display', 'none');
            $('#step-2').css('display', 'block');
            $('.btn-confirm-import').html('Import').removeAttr('disabled');
        }, 1000);
    })

    $(document).on('change', '#input-upload', function(e) {
        var file = $(this).val();
        var ext = file.split('.').pop();
        var ext_allow = ['xlsx', 'xls'];
        if (ext_allow.indexOf(ext) < 0) {
            alert('File yang diperbolehkan hanya .xlsx dan .xls');
            $(this).val('');
        } else {
            // create ajax

            // get this file
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);

            $.ajax({
                url: "<?= base_url('backup/import') ?>",
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // console.log(response);
                    var dt = JSON.parse(response);
                    if (dt.response == 'ok') {
                        $('.jenis-msg').html(
                            `
                            ${dt.jenis}
                            <button data-title="Hypertext Markup Language" class="btn btn-success btn-sm btn-status-status tooltip fade" style="margin-left: 5px;"><i class="fas fa-check-circle"></i></button>    
                            `
                        );
                        $('.btn-confirm-import').removeAttr('disabled');
                        $('.tbdimensi').val(dt.datakuesioner);
                        $('.tbdiskusilist').val(dt.datadiskusi);
                    }

                    if (dt.response == 'error') {
                        $('.jenis-msg').html(
                            `
                            ${dt.jenis}
                            <button data-title="Hypertext Markup Language" class="btn btn-danger btn-sm btn-status-status tooltip fade" style="margin-left: 5px;"><i class="fas fa-exclamation-circle"></i></button>    
                            `
                        );

                        // disable .btn-confirm-import
                        $('.btn-confirm-import').attr('disabled', true);
                    }
                },
                error: function(response) {
                    console.log(response);
                    $('.btn-confirm-import').removeAttr('disabled');
                }
            });
        }
    })

    $(document).on('click', '.btn-delete', function() {
        // empty file input
        $('#input-upload').val('');
        $('.jenis-msg').html(`-`);
    })

    $(document).on('submit', '#form-export', function(e) {
        var id = $(this).find('td:eq(0) select').val();
        var jumlah = $(this).find('td:eq(1) select').val();
        var format = $(this).find('td:eq(2) select').val();
        // var url = "<?= base_url('admin/backup/export') ?>";
        var data = {
            id: id,
            jumlah: jumlah,
            format: format
        };

        // if data is not empty, do console log
        if (data.id != '' && data.jumlah != '' && data.format != '') {

            if (data.jumlah == 'few') {
                show_modal_export()
            } else {
                $.ajax({
                    url: "<?= base_url('backup/export') ?>",
                    type: 'post',
                    data: data,
                    success: function(response) {
                        // console.log(response);
                        var dt = JSON.parse(response);
                        if (dt.response == 'ok') {
                            window.location.href = dt.redirect;
                        } else {
                            alert('Export gagal');
                        }
                    }
                });
            }
        } else {
            alert('Ada isian yang tidak lengkap');
        }
    })

    $(document).on('change', '.type_export', function() {

        var type = $(this).val()
        // alert('Initialized')

        $.ajax({
            url: "<?= base_url('backup/get_list_backupdata') ?>",
            type: 'post',
            data: {
                type: type,
            },
            success: function(response) {
                // console.log(response);

                var dt = JSON.parse(response);

                $('.data_wrapper').html(dt.html);
            },
            error: function(response) {
                console.log(response);
            }
        })
    })


    $(document).on('click', '#add_kategori_respon', function() {
        var x = $('.baris_kategori_respon').length
        $('#kategori_response_table').append(`<tr id="row` + x +
            `" class="baris_kategori_respon"><td><input type="text" name="kategori_respon[]" placeholder="Masukan nama kategori jawaban" class="form-control" required="" /><table class="tabel_pilihan_row"></table><span style="font-size: 11px;"><a href="#" class="add_pilihan">Tambah Pilihan</a></span></td><td style='vertical-align: top;'><button type="button" name="remove" id="` + x + `" class="btn btn-danger btn-sm btn_remove_kategori_respon">X</button></td></tr>`)
    });

    $(document).on('click', '.btn_remove_kategori_respon', function() {
        var button_id = $(this).attr("id")
        $('.baris_kategori_respon#row' + button_id + '').remove()
    });

    $(document).on('click', '.add_pilihan', function(e) {
        e.preventDefault()
        var whatrow = $(this).parents('tr').attr('id')

        var tabelpilihan = $('#' + whatrow + '.baris_kategori_respon').find('.tabel_pilihan_row')
        var pilihaninputelementlength = tabelpilihan.find('tr').length

        console.log(tabelpilihan)
        tabelpilihan.append(`
        <tr id="kategori${whatrow}pilihanke${pilihaninputelementlength}">
          <td style='padding: 0.3rem 0 0 0;'><input type="text" name="pilihan_kategori_respon${whatrow}[]" placeholder="pilihan" class="form-control" required="" /></td>
          <td style='vertical-align: top;'><a class="remove_pilihan" id="${whatrow}pilihanke${pilihaninputelementlength}"><i class="fas fa-times"></i></a></td>
        </tr>
        `)

        console.log(`kategori${whatrow}pilihanke${pilihaninputelementlength} added`)
    })

    $(document).on('click', '.remove_pilihan', function() {
        var button_id = $(this).attr("id")
        console.log(button_id + 'removed')
        $('#kategori' + button_id + '').remove()
    })


    $(document).on('submit', '#form_kuesioner_new', function(e) {

        e.preventDefault()

        var btnselected = $(document.activeElement)

        btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

        Swal.fire({
            title: 'Konfirmasi Tindakan',
            text: "Yakin disimpan?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                dataString = $("#form_kuesioner_new").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'Kuesioner/create_kuesioner_full' ?>",
                    data: dataString,
                    success: function(data) {

                        var dt = JSON.parse(data)

                        if (dt.response == 'ok') {
                            window.location.href = '<?php echo base_url() . 'kuesioner/success?thing=kuesioner&operation=add' ?>'
                        } else {
                            alert('check console')
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: "Oops!",
                            text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                        btnselected.html('Simpan').removeClass('disabled').removeAttr('disabled')
                    }
                });
            } else {
                btnselected.html('Simpan').removeClass('disabled').removeAttr('disabled')
            }
        })
    })
</script>