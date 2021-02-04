<?php defined('BASEPATH') or exit('No direct script access allowed');

function rsa_key()
{

    //Algoritma RSA - Set p dan q = bil. prima, p =/ q
    $p = 11;
    $q = 13;

    $n = $p * $q;
    $totient = ($p - 1) * ($q - 1);
    $e = cari_e($totient);
    $d = cari_d($e, $totient);

    // kembalikan
    $data = [
        'e' => $e,
        'n' => $n,
        'd' => $d
    ];
    return $data;
}

function cek_prima($bil)
{
    if ($bil < 2) {
        return FALSE;
    } // nol (0) dan 1 bukan prima
    for ($i = 2; $i <= ($bil / 2); $i++) {
        if ($bil % $i == 0) {
            return FALSE;
        }
    }
    return TRUE;
}

function gcd($e, $totient)
{
    $y = $e;
    $x = $totient;

    while (bccomp($y, 0) != 0) {
        $w = $x % $y;
        $x = $y;
        $y = $w;
    }

    return $x;
}

/*
* Cari nilai D,
* D = E-1 (mod N)
*/

function cari_d($Ee, $Em)
{
    $u1 = 1;
    $u2 = 0;
    $u3 = $Em;
    $v1 = 0;
    $v2 = 1;
    $v3 = $Ee;

    while ($v3 != 0) {
        $qq = floor($u3 / $v3);
        $t1 = $u1 - ($qq * $v1);
        $t2 = $u2 - ($qq * $v2);
        $t3 = $u3 - ($qq * $v3);
        $u1 = $v1;
        $u2 = $v2;
        $u3 = $v3;
        $v1 = $t1;
        $v2 = $t2;
        $v3 = $t3;
        $z = 1;
    }

    $uu = $u1;

    $vv = $u2;

    if ($vv < 0) {
        $inverse = $vv + $Em;
    } else {
        $inverse = $vv;
    }

    return $inverse;
}

/*
* Cari nilai E,
* GCD(N,E) = 1 and 1<E<N
*/

function cari_e($totient)
{
    $e = 3;
    if (bccomp(gcd($e, $totient), 1) != 0) {
        $e = 5;
        $step = 2;

        while (bccomp(gcd($e, $totient), 1) != 0) {
            $e = $e + $step;

            if ($step == 2) {
                $step = 4;
            } else {
                $step = 2;
            }
        }
    }

    return $e;
}

function encode_rsa($teks, $e, $n, $s = 1)
{
    $isiteks = "";
    $jmlchar = strlen($teks);
    $max = ceil($jmlchar / $s);

    for ($i = 0; $i < $max; $i++) {
        $gbchar = substr($teks, ($i * $s), $s);
        $code = 0;

        for ($j = 0; $j < $s; $j++) {
            // karakter jadikan ASCII * 256^urutan karakter
            $code = $code + (ord($gbchar[$j]) * bcpow(256, $j));
        }
        // karakter = karakter ^ E (mod N)

        $code = bcpowmod($code, $e, $n);
        $isiteks .= $code . " ";
    }

    return trim($isiteks);
}

/*
* Decrypt,
* M = X^D (mod N)
*/

function decode_rsa($encode, $d, $n)
{
    $isiteks = "";
    $char = explode(" ", $encode);
    $jmlchar = count($char);

    for ($i = 0; $i < $jmlchar; $i++) {
        // karakter = karakter enkripsi ^ D (mod N)
        $code = bcpowmod($char[$i], $d, $n);

        while (bccomp($code, "0") != 0) {
            // kembalikan nilai ASCII (mod 256 dari karakter div 256) ke karakter asli
            $ascii = $code % 256;
            $code = floor($code / 256);
            $isiteks .= chr($ascii);
        }
    }

    return $isiteks;
}
