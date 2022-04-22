var canvas = document.getElementById("temp-canvas")
var preview = document.getElementById("temp-preview")
var ctx = canvas.getContext("2d")

function increase_brightness(hex, percent){
    // strip the leading # if it's there
    hex = hex.replace(/^\s*#|\s*$/g, '');

    // convert 3 char codes --> 6, e.g. `E0F` --> `EE00FF`
    if(hex.length == 3){
        hex = hex.replace(/(.)/g, '$1$1');
    }

    var r = parseInt(hex.substr(0, 2), 16),
        g = parseInt(hex.substr(2, 2), 16),
        b = parseInt(hex.substr(4, 2), 16);

    return '#' +
    ((0|(1<<8) + r + (256 - r) * percent / 100).toString(16)).substr(1) +
    ((0|(1<<8) + g + (256 - g) * percent / 100).toString(16)).substr(1) +
    ((0|(1<<8) + b + (256 - b) * percent / 100).toString(16)).substr(1);
}

$(document).on('change', '#clr', function() {

    var color = $(this).val()

    var accent = increase_brightness(color, 50)
    $('.theme-preview-card').css('border-top','10px solid ' + accent)

    $('.background_kuesioner').css({
        'background-image': 'url(' + color + ')',
        'background-color': color
    });
})

function getDominantColor(imageObject) {
    //draw the image to one pixel and let the browser find the dominant color
    ctx.drawImage(imageObject, 0, 0, 1, 1);

    //get pixel color
    const i = ctx.getImageData(0, 0, 1, 1).data;

    console.log(`rgba(${i[0]},${i[1]},${i[2]},${i[3]})`);

    var hex = "#" + ((1 << 24) + (i[0] << 16) + (i[1] << 8) + i[2]).toString(16).slice(1)

    return hex;
}

function themeSet(name, value, accent){

    var newData = [];
    newData.push({
        'name': name,
        'value': value,
        'accent': accent
    })
    $('#theme_val').val(JSON.stringify(newData))
}

$(document).on('click', '.theme_choice', function() {

    $('.theme_choice').removeClass('active')
    $(this).addClass('active')

    var theme = $(this).data('theme')

    if (theme == 'solid') {
        $('.theme_setting_wrapper').html(`
            <p style='font-size: 11px; color: gray;'>Latar belakang satu warna</p>
            <input type="color" value= "#001A57" id="clr">
            <label for="clr">Pilih Warna</label>	
        `)

        $('.background_kuesioner').css({
            'background-image': 'url()',
            'background-color': $('#clr').val()
        });
        
        var style = `${$('#clr').val()}`

        var accent = increase_brightness(style, 50)
        $('.theme-preview-card').css('border-top','10px solid ' + accent)

        themeSet('solid', style, accent)
        $('#picture_background_input').val('')

    } else if (theme == 'picture') {
        
        $('.theme_setting_wrapper').html(`
            <p style='font-size: 11px; color: gray;'>Latar belakang dengan dengan gambar yang bisa dipilih (disarankan menggunakan gambar blur serta warna agak gelap) </p>
            <button class='btn btn-primary btn-upload-pic'>Pilih Gambar</button>	
        `)

        $('.background_kuesioner').css({
            'background': 'url(' + base_url + '/assets/images/kuesioner/default.png) no-repeat center center',
            'background-size': 'cover',
            'height': '100%',
            'overflow': 'hidden',
            'background-color': $('#clr').val()
        });

        var image = new Image()
        image.src = base_url + 'assets/images/kuesioner/default.png'
        image.onload = function() {
            var accent = getDominantColor(image)
            $('.theme-preview-card').css('border-top','10px solid ' + accent)
            var style = 'pic'
            themeSet('picture', style, accent)
            $('#picture_background_input').val('')
        }

    } else if(theme == 'gradient') {
        var primarycol = '';
        var secondarycol = '';

        var arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
        var arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

        var rand1 = Math.floor(Math.random() * arr1.length);
        var rand2 = Math.floor(Math.random() * arr2.length);

        primarycol = arr1[rand1];
        secondarycol = arr2[rand2];

        $('.background_kuesioner').css('background-image', 'linear-gradient(to bottom right, ' + primarycol + ', ' + secondarycol + ')')
        
        var accent = increase_brightness(primarycol, 50)
        $('.theme-preview-card').css('border-top','10px solid ' + accent)

        $('.theme_setting_wrapper').html(`
            <p style='font-size: 19px; color: gray; margin-bottom: 0;'><i class="fas fa-lightbulb"></i></p>
            <p style='font-size: 11px; color: gray;'>Latar belakang Perpaduan Warna Dasar PT Pupuk Indonesia yang berubah-ubah untuk seluruh responden</p>
        `)

        var style = `gradient_random`
        themeSet('gradient', style, 'dynamic')
        $('#picture_background_input').val('')

    } else {

        var primarycol = '';
        var secondarycol = '';

        var arr1 = ['#fab438', '#11998e', '#f47b24', '#1f78bc'];
        var arr2 = ['#feec03', '#38ef7d', '#fbaf14', '#57a2cb'];

        var rand1 = Math.floor(Math.random() * arr1.length);

        primarycol = arr1[rand1];
        secondarycol = arr2[rand1];

        $('.background_kuesioner').css('background-image', 'linear-gradient(to bottom right, ' + primarycol + ', ' + secondarycol + ')')
        
        var accent = increase_brightness(primarycol, 50)

        $('.theme-preview-card').css('border-top','10px solid ' + accent)
        $('.theme_setting_wrapper').html(`
            <p style='font-size: 19px; color: gray; margin-bottom: 0;'><i class="fas fa-lightbulb"></i></p>
            <p style='font-size: 11px; color: gray;'>Empat Latar belakang Perpaduan Warna Dasar PT Pupuk Indonesia yang berbeda bagi setiap responden</p>
        `)

        var style = `default_random`
        themeSet('default', style, 'dynamic')
        $('#picture_background_input').val('')
    }

})

$(document).on('click','.btn-upload-pic', function() {
    $('#picture_background_input').click()
})

$(document).on('change','#picture_background_input', function() {
    var file = this.files[0];

    // can't submit if size more than 1mb
    if (file.size > 1000000) {
        $('#picture_background_input').val('')
        alert('Ukuran gambar terdeteksi melebihi ketentuan (Size 1 MB maximum)')
        return false
    } else {

        // detect image type
        var imageType = /image.*/;

        if (file.type.match(imageType)) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.background_kuesioner').css({
                    'background': 'url(' + e.target.result + ') no-repeat center center',
                    'background-size': 'cover',
                    'height': '100%',
                    'overflow': 'hidden',
                    'background-color': $('#clr').val()
                });

                // create variable image object from e.target.result
                var image = new Image();
                image.src = e.target.result;

                // draw image to preview
                image.onload = function() {
                    ctx.drawImage(image, 0, 0, image.width, image.height);
                    var dataURL = canvas.toDataURL('image/png');
                    var accent = getDominantColor(preview);
                    $('.theme-preview-card').css('border-top','10px solid ' + accent)
                }
            }

            reader.readAsDataURL(file);
        } else {
            // empty this input file
            $('#picture_background_input').val('')
            alert('File yang diupload bukan gambar')
        }
    }
})