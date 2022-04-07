<?php

class Report_processor{
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();
    }

    function hue2rgb($p, $q, $t){
        if($t < 0) { $t++; }
        if($t > 1) { $t--; }
        if($t < 1/6) { return $p + ($q - $p) * 6 * $t; }
        if($t < 1/2) { return $q; }
        if($t < 2/3) { return $p + ($q - $p) * (2/3 - $t) * 6; }
        return $p;
    }
    
    function hslToRgb($h, $s, $l){
    #    var r, g, b;
        if($s == 0){
            $r = $g = $b = $l; // achromatic
        }else{
            if($l < 0.5){
                $q =$l * (1 + $s);
            } else {
                $q =$l + $s - $l * $s;
            }
            $p = 2 * $l - $q;
            $r = $this->hue2rgb($p, $q, $h + 1/3);
            $g = $this->hue2rgb($p, $q, $h);
            $b = $this->hue2rgb($p, $q, $h - 1/3);
        }
        $return=array(floor($r * 255), floor($g * 255), floor($b * 255));
        return $return;
    }
    
    /**
     * Convert a number to a color using hsl, with range definition.
     * Example: if min/max are 0/1, and i is 0.75, the color is closer to green.
     * Example: if min/max are 0.5/1, and i is 0.75, the color is in the middle between red and green.
     * @param i (floating point, range 0 to 1)
     * param min (floating point, range 0 to 1, all i at and below this is red)
     * param max (floating point, range 0 to 1, all i at and above this is green)
     */
    function numberToColorHsl($i, $min, $max) {
        $ratio = $i;
        if ($min> 0 || $max < 1) {
            if ($i < $min) {
                $ratio = 0;
            } elseif ($i > $max) {
                $ratio = 1;
            } else {
                $range = $max - $min;
                $ratio = ($i-$min) / $range;
            }
        }
        // as the function expects a value between 0 and 1, and red = 0° and green = 120°
        // we convert the input to the appropriate hue value
        $hue = $ratio * 1.2 / 3.60;
        //if (minMaxFactor!=1) hue /= minMaxFactor;
        //console.log(hue);
    
        // we convert hsl to rgb (saturation 100%, lightness 50%)
        $rgb = $this->hslToRgb($hue, 1, .5);
        // we format to css value and return
        return 'rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')'; 
    }
    
    /**
     * @param array      $array
     * @param int|string $position
     * @param mixed      $insert
     */
    function array_insert(&$array, $position, $insert)
    {
        if (is_int($position)) {
            array_splice($array, $position, 0, $insert);
        } else {
            $pos   = array_search($position, array_keys($array));
            $array = array_merge(
                array_slice($array, 0, $pos),
                $insert,
                array_slice($array, $pos)
            );
        }
    }

    public function get_jawaban_nilai($data_kuesioner)
    {
        $kategori_respon = json_decode($data_kuesioner->kategori_respon, TRUE);
        
        $data = [];
        
        foreach ($kategori_respon as $key => $kresp) {
            $respon = [];	
        
            foreach ($kresp['respon_list'] as $p => $rl) {
                $this->array_insert($respon, $rl, [
                    $rl => $p + 1
                ]);
            }
            $data[$kresp['nama']] = $respon;
        }

        return $data;
    }
    
    public function get_highest_gap($data_kuesioner, $jawabanlist) {
        
        if($jawabanlist){

            $datadimensi = json_decode($data_kuesioner->dimensi, TRUE);
    
            $highest_gap = [];
    
            $datadimensiindikatordannilai = [];
            foreach ($datadimensi as $key => $value) {
                $temp = [
                    "nama_dimensi" => $value['name'],
                    "indikator" => []
                ];
                
                foreach ($value['indikator'] as $key => $value) {
                    $temp['indikator'][$value] = 0;
                }
                
                $datadimensiindikatordannilai[] = $temp;
            }
        
            // find the highest value from the $datadimensiindikatordannilai[$indikator] and return key with the highest value
            foreach ($datadimensiindikatordannilai as $key => $v) {
                $highest_gap[$v['nama_dimensi']] = max($v['indikator']);
            }
        
            // print_r($highest_gap);
            $hg = [];
            foreach ($highest_gap as $name => $value) {
                $hg[$name] = $value;
            }
        
            foreach ($hg as $key => $value) {
                $color = '#' . substr(md5(rand()), 0, 6);
                echo '<span class="badge text-white" style="background-color:'.$color.'">'.$key.'</span>';
            }
        } else {
            echo '<span class="badge text-white" style="background-color:red">Tidak ada data</span>';
        }

    }
    
    function get_highest_focus($data_kuesioner,$jawabanlist) {

        if($jawabanlist) {
            $datadimensi = json_decode($data_kuesioner->dimensi, TRUE);
            $datakategorirespondannilai = [];
            $kategori_respon = json_decode($data_kuesioner->kategori_respon, TRUE);
            $pacuannilai = $this->get_jawaban_nilai($data_kuesioner);
    
        
            $datadimensiindikatordannilai = [];
            foreach ($datadimensi as $key => $value) {
                $temp = [
                    "nama_dimensi" => $value['name'],
                    "indikator" => []
                ];
                
                foreach ($value['indikator'] as $key => $value) {
                    $temp['indikator'][$value] = 0;
                }
                
                $datadimensiindikatordannilai[] = $temp;
            }
        
            foreach ($kategori_respon as $key => $kresp) {
                $respon = [];
        
                foreach ($kresp['respon_list'] as $p => $rl) {
                    $this->array_insert($respon, $rl, [
                        $rl => 0
                    ]);
                }
                $datakategorirespondannilai[$kresp['nama']] = $respon;
            }
        
            foreach ($jawabanlist as $key => $value) {
                $json_decode = json_decode($value->jawaban, TRUE);
                foreach ($json_decode as $keyjd => $value) {
                    
                    $query = "SELECT * FROM tbl_diskusi WHERE id = '".$value['id_diskusi']."'";
                    $ci =& get_instance();
                    $diskusi = $ci->db->query($query)->row();
                    
            
                    if($value['id_diskusi'] == $diskusi->id) {
                        // find the index of the $datadimensiindikatordannilai by value
                        $index = array_search($diskusi->dimensi, array_column($datadimensiindikatordannilai, 'nama_dimensi'));
            
                        foreach ($kategori_respon as $key => $kresp) {
                            $nama_kategori_respon = $kresp['nama'];
                            $datadimensiindikatordannilai[$index]['indikator'][$diskusi->indikator] += $pacuannilai[$nama_kategori_respon][$value[$nama_kategori_respon]];
                            
                            $jawabannya = $json_decode[$keyjd][$nama_kategori_respon];
                            $datakategorirespondannilai[$nama_kategori_respon][$jawabannya] += $pacuannilai[$nama_kategori_respon][$jawabannya];
                        }
                    }
                }
            }
        
            $datakategorirespondannilai = array_map(function($item) {
                $sum = array_sum($item);
                return $sum;
            }, $datakategorirespondannilai);
        
            $color = '#' . substr(md5(rand()), 0, 6);
            return '<span class="badge text-white" style="background-color:'.$color.'">'.array_keys($datakategorirespondannilai, max($datakategorirespondannilai))[0].'</span>';
        } else {
            echo '<span class="badge text-white" style="background-color:red">Tidak ada data</span>';
        }
    }
}