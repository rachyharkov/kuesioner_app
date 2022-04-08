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
    
    public function get_dimension_result($data_kuesioner, $jawabanlist) {
        
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

            $maxscale = count($hg);
            $o = $maxscale;
            foreach ($hg as $key => $value) {
                $color = $this->numberToColorHsl($o/$maxscale, 0, 1);
                echo '<span class="badge text-white" style="background-color:'.$color.'; width: 100%; border-radius: 0; padding-top: 1rem; padding-bottom: 1rem;">'.$key.'</span>';
                $o--;
            }
        } else {
            echo '<span class="badge text-white" style="background-color:red">Tidak ada data</span>';
        }

    }
    
    function generate_gap_detail($data_kuesioner,$jawabanlist) {

        if($jawabanlist) {
            $datadimensi = json_decode($data_kuesioner->dimensi, TRUE);
            $datakategorirespondannilai = [];
            $kategori_respon = json_decode($data_kuesioner->kategori_respon, TRUE);
            $pacuannilai = $this->get_jawaban_nilai($data_kuesioner);
        
            $datadimensiindikatordannilai = [];
            foreach ($datadimensi as $key => $value) {
                $temp = [
                    "nama_dimensi" => $value['name'],
                    "total" => 0,
                    "indikator" => []
                ];
                
                foreach ($value['indikator'] as $key => $value) {

                    $arr = [
                        "nama_indikator" => $value,
                        "total_nilai" => 0,
                        "detail" => []
                    ];

                    $temp['indikator'][$key] = $arr;
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
                            
                            // find the index of the $datakategorirespondannilai['indikator'] by $diskusi->indikator
                            $index_indikator = array_search($diskusi->indikator, array_column($datadimensiindikatordannilai[$index]['indikator'], 'nama_indikator'));
                            
                            $datadimensiindikatordannilai[$index]['indikator'][$index_indikator]['total_nilai'] += $pacuannilai[$nama_kategori_respon][$value[$nama_kategori_respon]];

                            $datadimensiindikatordannilai[$index]['indikator'][$index_indikator]['detail'][$nama_kategori_respon] = 0; 
                            
                            $jawabannya = $json_decode[$keyjd][$nama_kategori_respon];

                            

                            $datakategorirespondannilai[$nama_kategori_respon][$jawabannya] += $pacuannilai[$nama_kategori_respon][$jawabannya];
                        }
                    }
                }
            }
        
            // repeat process to readding the value to the $datadimensiindikatordannilai
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
                                       
                            $index_indikator = array_search($diskusi->indikator, array_column($datadimensiindikatordannilai[$index]['indikator'], 'nama_indikator'));

                            $datadimensiindikatordannilai[$index]['indikator'][$index_indikator]['detail'][$nama_kategori_respon] += $pacuannilai[$nama_kategori_respon][$value[$nama_kategori_respon]];
                        }
                    }
                }
            }

            foreach ($datadimensiindikatordannilai as $key => $valuea) {
                foreach ($valuea['indikator'] as $valueb) {
                    $datadimensiindikatordannilai[$key]['total'] += $valueb['total_nilai'];
                }
            }
            
            return $datadimensiindikatordannilai;
        } else {
            return false;
            // echo '<span class="badge text-white" style="background-color:red">Tidak ada data</span>';
        }
    }

    public function get_last_update($id_kuesioner)
    {
        $query = "SELECT * FROM tbl_jawaban WHERE jawaban LIKE '%\"id_kuesioner\":\"".$id_kuesioner."\"%' ORDER BY tanggal DESC LIMIT 1";
        $ci =& get_instance();
        $kuesioner = $ci->db->query($query)->row();

        
        if($kuesioner) {
            $p = $kuesioner->tanggal;
            return $p;
        } else {
            return 'N/A';
        }

    }

    public function generate_gap_scoreboard($data_kuesioner,$jawabanlist)
    {
        $datadimensiindikatordannilai = $this->generate_gap_detail($data_kuesioner,$jawabanlist);
        echo '<pre>';
        print_r($datadimensiindikatordannilai);
        echo '</pre>';

        if($datadimensiindikatordannilai == false) {
            echo '<span class="badge text-white" style="background-color:red">Tidak ada data</span>';
        } else {

            usort($datadimensiindikatordannilai, function($a, $b) {
                return $b['total'] - $a['total'];
            });
            $maxscale = 0;
            $arrnilai = [];
            foreach ($datadimensiindikatordannilai as $key => $value) {
                array_push($arrnilai, $value['total']);
            }
            // remove duplicate of $arrnilai
            $arrnilai = array_unique($arrnilai);
            // sort $arrnilai
            sort($arrnilai);
            $maxscale = count($arrnilai) - 1;
            
            echo '
            <div class="left-side">
                <div style="display: flex; flex-direction: column;">
            ';
            
            foreach ($datadimensiindikatordannilai as $key => $value) {
    
                if(in_array($value['total'], $arrnilai)) {
    
                    // get current index of $arrnilai
                    $index = array_search($value['total'], $arrnilai);
    
    
    
                    $color = $this->numberToColorHsl($index/$maxscale, 0, 1);
                    echo '<span class="badge badge-gap text-white" style="background-color:'.$color.'; width: 100%; border-radius: 0; padding-top: 1rem; padding-bottom: 1rem; cursor: help;" data-dtl=\''.json_encode($value['indikator'], JSON_HEX_APOS).'\'>'.$value['nama_dimensi'].' (Skor: '.$value['total'].')</span>';
                }
            }
    
            echo '
                </div>
            </div>
            <div class="right-side">
                <p>Hidden Information Here</p>
            </div>';
        }
    }
}