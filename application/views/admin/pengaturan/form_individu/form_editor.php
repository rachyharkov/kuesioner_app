<?php

$primarycol = '';
$secondarycol = '';

$arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
$arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

$ano = array_rand($arr1, 1);

$primarycol = $arr1[$ano];
$secondarycol = $arr2[$ano];

?>

<div class="container" style="min-height: 60vh;">
    <div class="row">
        <div class="col-1" style="position: relative;">
            <!-- create group of buttons with icon and responsive-->
            <div class="btn-group-vertical wrapper-btn-action wrapper-btn-action-with-context-menu">
                <button class="btn btn-primary btn-action-editor btn-add-element">
                    <i class="fa fa-plus"></i>
                    <span>Tambah</span>
                </button>
                <div class="context-menu-wrapper">
                    <ul class="list-group context-menu-list">
                        <li class="list-group-item">
                            <a href="#" class="add-element" data-type="text" data-element="input_text">
                                Input Text
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="add-element" data-type="number" data-element="input_number">
                                Input Angka
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="add-element" data-type="email" data-element="input_email">
                                Input Email
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="#" class="add-element" data-type="select" data-element="input_option_select">
                                Opsi Pilihan
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="btn btn-primary btn-action-editor btn-mode-delete" href="#">
                    <i class="fa fa-trash-alt"></i>
                    <span>Mode Hapus</span>
                </button>
                <button class="btn btn-primary btn-action-editor btn-save-form" href="#">
                    <i class="fa fa-save"></i>
                    <span>Simpan</span>
                </button>
                <button class="btn btn-primary btn-action-editor reset-form" href="#">
                    <i class="fa fa-redo"></i>
                    <span>Buat Ulang</span>
                </button>
                <a class="btn btn-primary btn-action-editor" href="<?php echo base_url() . 'pengaturan/form_individu' ?>">
                    <i class="fa fa-times"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
        <div class="col-11">
            <div class="container" style="position: relative;">
                <div class="row">
                    <div class="col-6">
                        <div style="position:relative;">
                            <input type="text" value="<?= $id != null ? $nama_form : '' ; ?>" name="form_name" class="form_name" placeholder="Nama Form" style="margin-bottom: 18px;border: none;font-size: 22px;padding-right: 2rem;display: inline-block;width: 100%;" />
                            <i class="fas fa-edit" style="position: absolute;right: 9px;top: 8px;"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <p style="text-align: right;margin: 0;">Mode: <span class="badge bg-success text-white mode-indicator" style="line-height: 20px;">Edit</span></p>
                    </div>
                </div>
                <div class="card" style="background-image: linear-gradient(to bottom right, <?php echo $primarycol . ',' . $secondarycol ?>);">
                    <div class="card-body" style="text-align: center;">
                        <div class="card" style="max-width: 490px;">
                            <div class="card-body" style="min-height: 60vh;">
                                <input type="text" name="form_design" class="form_design" value='<?= $id != null ? $design_form : '[]' ; ?>'>
                                <div style="width: 100%;text-align: center;margin: 2vh 0;">
                                    <img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
                                </div>

                                <?php 
                                
                                    if($id == null) {

                                        ?>
                                        <div class="warning-anu">
                                            <div style="text-align: center;padding: 15vh 0;">
                                                <i class="fas fa-cat" style="font-size: 92px;color: gray;margin-bottom: 35px;"></i>
                                                <p style="font-size: 14px;color: gray;text-align: center;">Tidak ada kolom formulir, mulai tambahkan sesuatu disini dengan menambahkan elemen formulir melalui tombol bilah pada bagian kiri laman</p>
                                            </div>
                                        </div>
                                        <div id="form_input_preview_wrapper">

                                        </div>
                                        <?php

                                    } else {
                                        ?>
                                        <div id="form_input_preview_wrapper">
                                            <?php
                                                $df = json_decode($design_form, TRUE);
                                                foreach($df as $key => $value) {
                                                    ?>
                                                    <div class="preview_element" style="display: flex;">
                                                        <div class="form__group">
                                                            <input type="<?= $value['elementtype'] ?>" id="<?= $value['id'] ?>" data-elementname="<?= $value['elementname'] ?>" data-prefix="${prefix}" class="form__field" placeholder="${placeholder}" data-requiredfill="${wajib_diisi}">
                                                            <label class="form__label"><?= $value['elementname'] ?></label>
                                                        </div>
                                                        <div class="handle">
                                                            <i class="fas fa-arrows-alt" style="bottom: 12px; position: absolute;left: 8px;"></i>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() . 'assets/js/jquery-ui/jquery-ui.min.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/js/jquery.ui.touch-punch.min.js' ?>"></script>

<script>

    $(document).ready(function(){

        function update_design_form() {
            var form_design = []
            var panjangelement = $('.form__field').length

            if (panjangelement > 0) {
                $('.warning-anu').hide()
            } else {
                $('.warning-anu').show()
            }

            // update form_design.position as .form__field index

            $('.form__field').each(function(index) {

                $(this).attr('id', index + 1)

                var id = $(this).attr('id');
                var type = $(this).attr('type');
                var nama_element = $(this).data('elementname')
                var prefix = $(this).data('prefix')
                var placeholder = $(this).attr('placeholder')
                var wajib_diisi = $(this).data('requiredfill')

                form_design.push({
                    'id': id,
                    'position': index + 1,
                    'elementname': nama_element,
                    'prefix': prefix,
                    'elementtype': type,
                    'placeholder': placeholder,
                    'required': wajib_diisi
                });
            })
            $('.form_design').val(JSON.stringify(form_design))
        }

        $("#form_input_preview_wrapper").sortable({
            handle: '.handle',
            cursor: 'grabbing',
            update: function(event, ui) {
                update_design_form()
            }
        })

        $('.wrapper-btn-action').on('click', '.btn-add-element', function() {
            $('.context-menu-wrapper').toggle();
        });

        // close .contex-menu-wrapper when click outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.wrapper-btn-action').length) {
                $('.context-menu-wrapper').hide();
            }
        });


        $(document).on('click', '.add-element', function() {
            // alert($(this).data('element'));
            $('.context-menu-wrapper').toggle();

            var jenis_element = $(this).data('element');


            var type_element = $(this).data('type');

            if (type_element == 'text' || type_element == 'number' || type_element == 'email') {
                $('.modal-content').html(`
                <form id="form-confirm-add-element">
                    <input type="hidden" name="type-element" value="${type_element}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Element <span id="jenis__element">${type_element}</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Element</label>
                            <input required type="text" class="form-control" name="nama_element" id="nama_element" placeholder="Nama Element">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Input Prefix</label>
                            <div class="input-group">
                                <input required type="text" class="form-control" name="prefix" id="prefix" placeholder="Contoh: nama_lengkap">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" style="margin: 0;">
                                        <i class="fa fa-magic"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Placeholder</label>
                            <input required type="text" class="form-control" name="placeholder" id="placeholder" placeholder="Pesan Instruksi">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox">
                                <span class="form-check-sign"></span>
                                Wajib Diisi?
                            </label>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn_add_element">Tambah</button>
                    </div>
                </form>

                `);
            } else if (type_element == 'select') {
                alert('Not Available yet')
            }

            $('#modal_add_element').modal('show');
        })

        $(document).on('click', '.reset-form', function() {
            // create sweetalert
            Swal.fire({
                title: 'Reset Form',
                text: "Apakah anda yakin ingin mereset form? (Semua element form yang sudah ditambahkan akan dihapus)",
                type: 'warning',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.value) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Sukses Reset Form'
                    })
                    $('#form_input_preview_wrapper').html('');
                    $('.form_design').val('[]');
                }
            })
        })

        $(document).on('submit', '#form-confirm-add-element', function(e) {

            e.preventDefault()

            var thisform = $(this);

            var type = thisform.find('input[name="type-element"]').val();
            var nama_element = thisform.find('input[name="nama_element"]').val();
            var prefix = thisform.find('input[name="prefix"]').val();
            var placeholder = thisform.find('input[name="placeholder"]').val();
            var wajib_diisi = thisform.find('input[type="checkbox"]').is(':checked');

            var count_element = $('.form__group').length + 1;

            if (wajib_diisi) {
                wajib_diisi = true
            } else {
                wajib_diisi = false
            }

            $('#form_input_preview_wrapper').append(`
                <div class="preview_element" style="display: flex;">
                    <div class="form__group">
                        <input type="${type}" id="${count_element}" data-elementname="${nama_element}" data-prefix="${prefix}" class="form__field" placeholder="${placeholder}" data-requiredfill="${wajib_diisi}">
                        <label class="form__label">${nama_element}</label>
                    </div>
                    <div class="handle">
                        <i class="fas fa-arrows-alt" style="bottom: 12px; position: absolute;left: 8px;"></i>
                    </div>
                </div>
                `);


            update_design_form()
            $('#modal_add_element').modal('hide');
            Toast.fire({
                icon: 'success',
                title: 'Berhasil menambah element form'
            })
        });

        $(document).on('click', '.btn-mode-delete', function() {
            // $(this).removeClass('btn-mode-delete')
            $('.mode-indicator').removeClass('bg-success')
            $('.mode-indicator').addClass('bg-danger active').text('Delete')

            $('.handle').removeClass('handle').addClass('delete').html('<i class="fas fa-trash-alt" style="bottom: 12px; position: absolute;left: 8px;"></i>')

        })

        $(document).on('click', '.btn-action-editor', function() {

            // detect index element of clicked
            var index_element = $(this).index();

            if (index_element != 2) {
                $('.mode-indicator').removeClass('bg-danger')
                $('.mode-indicator').addClass('bg-success').text('Edit')
                $('.delete').removeClass('delete').addClass('handle').html('<i class="fas fa-arrows-alt" style="bottom: 12px; position: absolute;left: 8px;"></i>')
            }
        })

        $(document).on('click', '.delete', function() {
            $(this).parents('.preview_element').remove()
            update_design_form()
            Toast.fire({
                icon: 'success',
                title: 'Berhasil menghapus element form'
            })
        })

        $(document).on('click', '.btn-save-form', function() {
            var form_design = $('.form_design').val()
            var form_name = $('.form_name').val()

            $.ajax({
                url: '<?= base_url('pengaturan/save_form_individu') ?>',
                type: 'POST',
                data: {
                    form_design: form_design,
                    form_name: form_name
                },
                success: function(data) {

                    var dt = JSON.parse(data)

                    if (dt.status == 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil menyimpan form'
                        })
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: dt.message
                        })
                    }
                    $('#modal_add_form').modal('hide');
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal menyimpan form'
                    })
                }
            })
        })
    })
</script>

</script>