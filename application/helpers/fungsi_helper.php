<?php
function check_already_login(){

    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if ($user_session){
        redirect('dashboard');
    }
}

//untuk semua ctrl cek seesion login dan session unit
function is_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
    if (!$user_session){
        redirect('auth');        
    }
}

//untuk bagian dashboard saja
function cek_login_aja(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('userid');
        if (!$user_session){
        redirect('auth');
      }
}


//format rupiah
function rupiah($angka){
    
    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
    return $hasil_rupiah;
}

function getNameFromNumber($num) {
    $numeric = ($num) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
}

