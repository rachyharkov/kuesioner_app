// create function generatecolorscale()
function hueToRgb(p,q,t)
{
    var p = 0 
    if (t < 0) {
        t++;
    } else if (t > 1) {
        t--;
    } else if (t < 1 / 6) {
        return p + (q - p) * 6 * t;
    } else if (t < 1 / 2) {
        return q;
    } else if (t < 2 / 3) {
        return p + (q - p) * (2 / 3 - t) * 6;
    }

    return p;
}

function hslToRgb(hue, saturation, lightness) {
    var r, g, b;

    if (saturation == 0) {
        r = g = b = lightness; // achromatic
    } else {
        var q = lightness < 0.5 ? lightness * (1 + saturation) : lightness + saturation - lightness * saturation;
        var p = 2 * lightness - q;
        r = hueToRgb(p, q, hue + 1 / 3);
        g = hueToRgb(p, q, hue);
        b = hueToRgb(p, q, hue - 1 / 3);
    }

    return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
}

function numberToColorHsl(scale, min, max)
{
    var ratio = scale;

    if (min > 0 || max < 1) {
        if (scale < min) {
            ratio = 0;
        } else if (scale > max) {
            ratio = 1;
        } else {
            range = max - min;
            ratio = (scale - min) / range;
        }
    }

    // as the function expects a value between 0 and 1, and red = 0° and green = 120°
    // we convert the input to the appropriate hue value
    $hue = ratio * 1.2 / 3.60;

    // we convert hsl to rgb (saturation 100%, lightness 50%)
    $rgb = hslToRgb($hue, 1, .5);

    // we format to css value and return
    return "rgb" + "(" + $rgb[0] + "," + $rgb[1] + "," + $rgb[2] + ")";
}

function generateColorScaleforEachPilihanfromEachKategoriRespon() {
    $('.baris_kategori_respon').each(function(index) {
        var bariskategori = $(this)

        var scale = bariskategori.find('.tbpilihan').length

        if(scale <= 0) {
            $(this).find('.alertanuuan').html(`<p class="alertnyak" style="color: red; font-size: 11px"><b>Wajib ada pilihan pada kategori ini</b></p>`)
        } else if(scale <= 2) {
            $(this).find('.alertanuuan').html(`<p class="alertnyak" style="color: red; font-size: 11px"><b>Pilihan pada kategori ini harus lebih dari 2</b></p>`)
        } else {
            $(this).find('.alertanuuan').html('')
        }

        for(var i = 0; i <= scale; i++) {

            var color = numberToColorHsl(i / scale, 0, 1)

            bariskategori.find('.tbpilihan').eq(i).css('background-color', color)
        }
    });
}