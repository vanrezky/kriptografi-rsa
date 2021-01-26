<?php defined('BASEPATH') or exit('No direct script access allowed');

function format_hari_tanggal($waktu)

{

    // Senin, Selasa dst.

    $hari_array = array(

        'Minggu',

        'Senin',

        'Selasa',

        'Rabu',

        'Kamis',

        'Jumat',

        'Sabtu'

    );

    $hr = date('w', strtotime($waktu));

    $hari = $hari_array[$hr];
    // Tanggal: 1-31 dst, tanpa leading zero.

    $tanggal = date('j', strtotime($waktu));



    // Bulan: Januari, Maret dst.

    $bulan_array = array(

        1 => 'Januari',

        2 => 'Februari',

        3 => 'Maret',

        4 => 'April',

        5 => 'Mei',

        6 => 'Juni',

        7 => 'Juli',

        8 => 'Agustus',

        9 => 'September',

        10 => 'Oktober',

        11 => 'November',

        12 => 'Desember',

    );

    $bl = date('n', strtotime($waktu));

    $bulan = $bulan_array[$bl];


    // Tahun, 4 digit.

    $tahun = date('Y', strtotime($waktu));

    //$jam = time('Y', strtotime($waktu));


    // Hasil akhir: Senin, 1 Oktober 2014

    return "$hari, $tanggal $bulan $tahun";
}

function encode($param)
{
    $CI = get_instance();
    $encrypt  = $CI->encryption->encrypt($param);

    return  str_replace(array('/'), array('0_0'), $encrypt);
}

function decode($param)
{
    $CI = get_instance();
    $decrypt = str_replace(array('0_0'), array('/'), $param);

    return  $CI->encryption->decrypt($decrypt);
}

function is_logged_in()
{
    $CI = &get_instance();

    if (empty($CI->session->has_userdata('username'))) {
        redirect('auth');
    }
}

function current_timestamp()
{
    date_default_timezone_set("Asia/Jakarta");
    return date("Y-m-d H:i:s");
}

function ifUang($nominal = "")
{
    if (is_numeric($nominal)) {
        $panjang = strlen($nominal);
        $char    = str_split($nominal);
        $hasil   = "";
        $no = 0;
        for ($i = count($char) - 1; $i >= 0; $i--) {
            if ($no == 3) {
                $hasil .= ".";
                $no = 0;
            }
            $no++;
            $hasil .= $char[$i];
        }
        return strrev($hasil);
    } else {
        return $nominal;
    }
}

function getLevel()
{
    return ['pemilik', 'administrator', 'perawat'];
}

function alert($pesan = '', $class = 'success')
{
    $icon = $class == 'success' ? 'icon fas fa-check' : 'icon fas fa-ban';
    $D = '';
    $D .= '<div class="alert alert-' . $class . ' alert-dismissible">';
    $D .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    $D .= '<h5><i class="' . $icon . '"></i> Info..</h5>';
    $D .= $pesan;
    $D .= '</div>';

    return $D;
}
