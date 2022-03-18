<?php

$primarycol = '';
$secondarycol = '';

$arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
$arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

$ano = array_rand($arr1, 1);

$primarycol = $arr1[$ano];
$secondarycol = $arr2[$ano];

?>

<style>
    .wrapper-btn-action-with-context-menu {
        position: absolute;
        top: 0;
    }

    .context-menu-wrapper {
        z-index: 9;
        position: absolute;
        left: 37px;
        top: 10px;
        width: 10rem;
        display: none;
    }

    .btn.btn-action-editor {
        margin-bottom: 0;
    }



    .form__group {
        position: relative;
        padding: 15px 0 0;
        margin-top: 10px;
        width: 95%
    }

    .form__field {
        font-family: inherit;
        width: 100%;
        border: 0;
        border-bottom: 2px solid #9b9b9b;
        outline: 0;
        font-size: 1.3rem;
        color: black;
        padding: 7px 0;
        background: transparent;
        transition: border-color 0.2s;
    }

    .form__field::placeholder {
        color: transparent;
    }

    .form__field:placeholder-shown~.form__label {
        font-size: 1.3rem;
        cursor: text;
        top: 20px;
    }

    .form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 1rem;
        color: #9b9b9b;
    }

    .form__field:focus {
        padding-bottom: 6px;
        font-weight: 700;
        border-width: 3px;
        border-image: linear-gradient(to right, <?php echo $primarycol . ',' . $secondarycol ?>);
        border-image-slice: 1;
    }

    .form__field:focus~.form__label {
        position: absolute;
        top: 0;
        display: block;
        transition: 0.2s;
        font-size: 1rem;
        color: <?php echo $primarycol ?>;
        font-weight: 700;
    }

    .form__field:required,
    .form__field:invalid {
        box-shadow: none;
    }

    .btn-action-editor span{
        opacity: 0;
        transition: opacity 0.3s;
        width: 100%;
        position: absolute;
        left: 0;
        top: 9px;
    }

    .btn-action-editor svg{
        opacity: 1;
        transition: opacity 0.3s;
    }
    .btn-action-editor {
        width: 100%;
        transition: ease-in-out 0.3s;
    }
    .btn-action-editor:hover {
        width: 200%;
        transition: ease-in-out 0.3s;
    }
    .btn-action-editor:hover span {
        opacity: 1;
        transition: opacity 0.6s;
    }
    .btn-action-editor:hover svg{
        opacity: 0;
        transition: opacity 0.3s;
    }
</style>
<div class="container" style="min-height: 60vh;">
    <div class="row">
        <div class="col-2" style="position: relative;">
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
                <button class="btn btn-primary btn-action-editor" href="#">
                    <i class="fa fa-trash-alt"></i>
                    <span>Mode Hapus</span>
                </button>
                <button class="btn btn-primary btn-action-editor" href="#">
                    <i class="fa fa-save"></i>
                    <span>Simpan</span>
                </button>
                <button class="btn btn-primary btn-action-editor reset-form" href="#">
                    <i class="fa fa-redo"></i>
                    <span>Buat Ulang</span>
                </button>
                <a class="btn btn-danger btn-action-editor" href="<?php echo base_url() . 'pengaturan/form_individu' ?>">
                    <i class="fa fa-times"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
        <div class="col-10">
            <div class="container" style="position: relative;">
                <h4>Preview</h4>
                <div class="card" style="background-image: linear-gradient(to bottom right, <?php echo $primarycol . ',' . $secondarycol ?>);">
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <input type="text" name="form_design" class="form_design" value="[]">
                                <div style="width: 100%;text-align: center;margin: 2vh 0;">
                                    <img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
                                </div>
                                <div id="form_input_preview_wrapper">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- create modal -->
<div class="modal fade" id="modal_add_element" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<script src="<?php echo base_url().'assets/js/jquery-ui/jquery-ui.min.js' ?>"></script>
<script src="<?php echo base_url().'assets/js/jquery.ui.touch-punch.min.js' ?>"></script>

<script>

    $(document).ready(function() {

        function update_design_form() {
            var form_design = JSON.parse($('.form_design').val())
            // update form_design.position as .form__field index
            for (var i = 0; i < form_design.length; i++) {
                var pos = 0
                $('.form__field').each(function(index){
                    if ($(this).attr('data-prefix') == form_design[i].prefix) {
                        pos = index
                    }
                })
                form_design[i].position = pos + 1
            }
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


        $(document).on('click','.add-element', function() {
            // alert($(this).data('element'));
            $('.context-menu-wrapper').toggle();

            $('#jenis__element').text($(this).data('element'));

            var type_element = $(this).data('type');

            if (type_element == 'text' || type_element == 'number' || type_element == 'email') {
                $('.modal-content').html(`
                <form id="form-confirm-add-element">
                    <input type="hidden" name="type-element" value="${type_element}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Element <span id="jenis__element"></span></h5>
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
            $('#form_input_preview_wrapper').html('');
            $('.form_design').val('[]');
        })

        $(document).on('submit','#form-confirm-add-element', function(e) {

            e.preventDefault()

            var thisform = $(this);

            var type = thisform.find('input[name="type-element"]').val();
            var nama_element = thisform.find('input[name="nama_element"]').val();
            var prefix = thisform.find('input[name="prefix"]').val();
            var placeholder = thisform.find('input[name="placeholder"]').val();
            var wajib_diisi = thisform.find('input[type="checkbox"]').is(':checked');
            
            var count_element = $('.form__group').length + 1;
            
            $('#form_input_preview_wrapper').append(`
                <div class="preview_element" style="display: flex;">
                    <div class="form__group">
                        <input type="${type}" id="${count_element}" data-elementname="${nama_element}" data-prefix="${prefix}" class="form__field" placeholder="${placeholder}">
                        <label class="form__label">${nama_element}</label>
                    </div>
                    <div class="handle" style="width: 5%;cursor: move; position: relative;">
                        <i class="fas fa-arrows-alt" style="bottom: 12px;   position: absolute;left: 8px;"></i>
                    </div>
                </div>
                `);


            var form_design = $('.form_design').val();
            var form_design_json = JSON.parse(form_design);

            if(wajib_diisi){
                wajib_diisi = true
            } else {
                wajib_diisi = false
            }

            form_design_json.push({
                'id':count_element,
                'position': count_element,
                'elementname': nama_element,
                'prefix': prefix,
                'elementtype': type,
                'placeholder': placeholder,
                'required': wajib_diisi
            });

            var form_design_json_string = JSON.stringify(form_design_json);

            $('.form_design').val(form_design_json_string);

            $('#modal_add_element').modal('hide');
        });
    })
</script>