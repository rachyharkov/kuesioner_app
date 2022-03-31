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
        border-bottom: 6px solid rgba(0, 0, 0, .75);
        border-left: 6px solid transparent;
        content: '';
        height: 0;
        top: 20px;
        left: 20px;
        width: 0;
    }

    .tooltip:before {
        background: rgba(0, 0, 0, .75);
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
        transform: translate3d(0, -10px, 0);
        transition: all .15s ease-in-out;
    }

    .tooltip.fade:hover:after,
    .tooltip.fade:hover:before {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Form Individual Template</h5>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Individu</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body page-wrapper">
                <a class="btn btn-primary btn-add-data" href="<?php echo base_url() . 'pengaturan/form_individu_editor' ?>">Tambah Form</a>
                <div class="table-responsive">
                    <table class="table" id="tabel_formindividu">
                        <thead>
                            <tr>
                                <th>Nama Form</th>
                                <th>Tanggal</th>
                                <th>Dibuat</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$list_formindividu) {
                            ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="alert alert-danger text-center">
                                            Tidak ada Form
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            } else {
                                foreach ($list_formindividu as $key => $value) {
                                ?>
                                    <tr>
                                        <td><?= $value->nama_form ?><?= $key == 0 ? ' <label class="badge bg-success text-white">Default</label>' : '' ?></td>
                                        <td><?php echo $value->created_at ?></td>
                                        <td><?php echo $value->created_by ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo base_url() . 'pengaturan/form_individu_editor?edit=' . $value->id_formindividu ?>" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit fa-fw"></i></a>
                                                <?php
                                                if ($key == 0) {
                                                ?>
                                                    <button class="btn btn-danger btn-sm text-white" disabled><i class="fas fa-trash fa-fw"></i></button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button id="<?php echo $value->id_formindividu ?>" class="btn btn-danger btn-sm text-white link_delete_formindividu"><i class="fas fa-trash-alt fa-fw"></i></button>
                                                <?php
                                                }

                                                ?>
                                                <a id="<?php echo $value->id_formindividu ?>" class="btn btn-primary btn-sm text-white"><i class="fas fa-eye fa-fw"></i></a>
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
</div>

<script>
$(document).ready(function(){

    $(window).resize(function() {
        console.log($(window).height());
        $('#tabel_formindividu').css('min-height', ($(window).height() - 100));
    });

    $('#tabel_formindividu').DataTable({
        sScrollY: ($(window).height() - 100),
    });

    $(document).on('click', '.link_delete_formindividu', function() {
        var id = $(this).attr('id');

        var formname = $(this).parent().parent().parent().find('td:first-child').text();

        Swal.fire({
            title: 'Hapus Form Individu',
            text: "Apakah anda yakin ingin menghapus " + formname + "?",
            type: 'warning',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo base_url() . 'pengaturan/delete_form_individu' ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        Swal.fire(
                            'Terhapus!',
                            'Form individu berhasil dihapus.',
                            'success'
                        )
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Gagal!',
                            'Form individu gagal dihapus.',
                            'error'
                        )
                    }
                });
            }
        })
    })
})

</script>