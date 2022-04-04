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
</style>

<div class="card" style="background-image: linear-gradient(to bottom right, <?php echo $primarycol . ',' . $secondarycol ?>);">
    <div class="card-body" style="text-align: center;">
        <div class="card" style="max-width: 490px;">
            <div class="card-body" style="min-height: 60vh;">
                <div style="width: 100%;text-align: center;margin: 2vh 0;">
                    <img src="<?php echo base_url() . 'assets/images/logo_perusahaan.png' ?>" height="50" style="margin: auto;">
                </div>
                <div id="form_input_preview_wrapper">
                    <?php
                        $df = json_decode($dataformindividu->design_form, TRUE);
                        foreach($df as $key => $value) {

                            if($value['elementtype'] == 'text' || $value['elementtype'] == 'number' || $value['elementtype'] == 'email')
                            {
                                ?>
                                <div class="form__group">
                                    <input type="<?= $value['elementtype'] ?>" id="<?= $value['id'] ?>" data-elementname="<?= $value['elementname'] ?>" data-prefix="<?= $value['prefix'] ?>" class="form__field" placeholder="<?= $value['placeholder'] ?>" data-requiredfill="<?= $value['required'] ?>">
                                    <label class="form__label"><?= $value['elementname'] ?></label>
                                </div>
                                <?php
                            }

                            if($value['elementtype'] == 'options') {
                                ?>
                                <div class="form__group">
                                    <select id="<?= $value['id'] ?>" type="<?= $value['elementtype'] ?>" data-elementname="<?= $value['elementname'] ?>" data-prefix="<?= $value['prefix'] ?>" class="form__field" placeholder="<?= $value['placeholder'] ?>" data-requiredfill="<?= $value['required'] == 1 ? 'true' : 'false'; ?>" data-options='<?= json_encode($value['elementvaluelist']) ?>'>
                                        <option value="">Pilih Opsi</option>
                                        <?php
                                            foreach($value['elementvaluelist'] as $key2 => $value2) {
                                                ?>
                                                <option value="<?= $value2 ?>"><?= $value2 ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <label class="form__label"><?= $value['elementname'] ?></label>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>                    
</div>