<?php defined('BASEPATH') or exit('No direct script access allowed');
function setCookies($name = '', $data = '')
{
    deleteCookies($name);
    setcookie($name, is_array($data) ? encode(json_encode($data)) : encode($data), time() + 3600, '/');
}

function getCookies($name = '')
{
    if (isset($_COOKIE[$name])) {
        $temp = decode($_COOKIE[$name]);
        if (is_null(json_decode($temp))) return $temp;
        return (array)json_decode($temp);
    }
    return NULL;
}

function deleteCookies($name = '')
{
    // unset($_COOKIE[$name]);
    // setcookie($name, NULL, -1, '/');  
    $t = explode("_", $name);
    $m = preg_grep('/^' . $t[0] . '_(\w+)/i', array_keys($_COOKIE));
    foreach ($m as $value) {
        unset($_COOKIE[$value]);
        setcookie($value, NULL, -1, '/');
    }
}

function nama_bulan()
{
    $bulan_array = array(

        ['val' => 1, 'label' => 'Januari'],

        ['val' => 2,  'label' => 'Februari'],

        ['val' => 3, 'label' => 'Maret'],

        ['val' => 4, 'label' => 'April'],

        ['val' => 5, 'label' => 'Mei'],

        ['val' => 6, 'label' => 'Juni'],

        ['val' => 7, 'label' => 'Juli'],

        ['val' => 8, 'label' => 'Agustus'],

        ['val' => 9, 'label' => 'September'],

        ['val' => 10, 'label' => 'Oktober'],

        ['val' => 11, 'label' => 'November'],

        ['val' => 12, 'label' => 'Desember'],

    );

    return $bulan_array;
}

function tahun_sekarang()
{
    $now = date('Y');
    $old = 2015;
    $tahun_array = [];
    for ($i = $old; $i < $now; $i++) {
        $tahun_array[] = [
            'val' => $i
        ];
    }

    return $tahun_array;
}

function d($var)
{
    echo '<pre>' . var_export($var, true) . '</pre>';
}

function dd($var)
{
    echo '<pre>' . var_export($var, true) . '</pre>';
    die;
}
