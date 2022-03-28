<style>
    .wrapper-btn-action-with-context-menu {
        position: sticky;
        top: 70px;
        z-index: 999;
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

    .btn-action-editor span {
        opacity: 0;
        transition: opacity 0.3s;
        width: 100%;
        position: absolute;
        left: 0;
        top: 9px;
    }

    .btn-action-editor svg {
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

    .btn-action-editor:hover svg {
        opacity: 0;
        transition: opacity 0.3s;
    }

    .handle {
        width: 5%;
        cursor: move;
        position: relative;
    }

    .delete {
        width: 5%;
        cursor: pointer;
        position: relative;
    }
</style>

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

    .lego-loader {
        width: 480px !important;
        margin: auto;
        display: flex;
    }

    .lego-loader::after {
        content: 'Loading...';
        font-size: 1.5rem;
        color: #9b9b9b;
        margin-left: 10px;
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
                        <li class="breadcrumb-item"><a href="<?= base_url('pengaturan/form_individu') ?>">Form Individu</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Editor</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body page-wrapper">
                <div class="loader-editor">

                </div>
                <p>Mempersiapkan editor...</p>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.1/lottie.min.js" integrity="sha512-CWKGqmXoxo+9RjazbVIaiFcD+bYEIcUbBHwEzPlT0FilQq3TCUac+/uxZ5KDmvYiXJvp32O8rcgchkYw6J6zOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    
    var animData = {
        wrapper: document.querySelector('.loader-editor'),
        animType: 'svg',
        loop: true,
        prerender: true,
        autoplay: true,
        path: 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/LEGO_loader.json',
        rendererSettings: {
            preserveAspectRatio: 'xMidYMid slice',
            className: 'lego-loader'
        }
    };
    var anim = bodymovin.loadAnimation(animData);
    anim.setSpeed(3.4);

    $(document).ready(function() {

        // get parameter url of id
        var url = new URL(window.location.href);
        var id = url.searchParams.get("edit");
        
        setTimeout(function() {
            $.ajax({
                url: "<?= base_url('pengaturan/fetch_individuform_editor/') ?>" + id,
                type: "GET",
                success: function(data) {
                    $('.page-wrapper').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('.page-wrapper').html('<p>Terjadi kesalahan, silahkan refresh editor</p>');
                    alert('Gagal Memuat Form Editor, silahkan refresh halaman');
                }
            })
        }, 5000);
    })
</script>