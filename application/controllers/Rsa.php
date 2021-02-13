<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rsa extends MY_Controller
{

    // $enkripsi1 = encode_rsa($pesan, $rsa_key['e'], $rsa_key['n']);
    // $dekripsi1 = decode_rsa($enkripsi1, $rsa_key['d'], $rsa_key['n']);

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // fungsi jika sudah login
    }

    public function index()
    {
        $rsa_key = rsa_key();
        $plain = trim($this->input->post('plain', true));
        $encrypt = !empty($plain) ? encode_rsa($plain, $rsa_key['e'], $rsa_key['n']) : '';
        $data_rsa = [
            'plain' => $plain,
            'encrypt' => $encrypt
        ];
        $data = [
            'title' => 'Implemenasi Kriptografi Algoritma RSA',
            'data_rsa' => $data_rsa
        ];
        $this->render('v_rsa_index', $data);
    }

    public function enkripsi()
    {
        $rsa_key = rsa_key();

        $D = ['success' => false, 'message' => 'Plainteks tidak boleh kosong!'];

        $plain = trim($this->input->post('plain'));
        if (!empty($plain)) {
            $e = $rsa_key['e'];
            $n = $rsa_key['n'];

            $hasil = $this->encode_rsa($plain, $e, $n);
            $proses = [
                'plainteks' => $plain,
                'e' => $e,
                'n' => $n,
                'ASCII' => $hasil['ASCII'],
                'ASCII^e mod n' => $hasil['perkalian'],
                'Chipperteks' => $hasil['isiteks']
            ];
            $message  = "<div class='alert alert-info'>";
            $message .= '<h5><i class="icon fas fa-info"></i> Proses Enkripsi!</h5>';
            $message .= '<pre>' . var_export($proses, true) . '</pre>';
            $message .= "</div>";

            $D = [
                'success' => true,
                'message' => $message,
                'proses' => $proses
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    private function encode_rsa($teks, $e, $n, $s = 1)
    {
        $isiteks = "";
        $jmlchar = strlen($teks);
        $max = ceil($jmlchar / $s);
        $hasil = [];
        $ASCII = "";
        $perkalian = "";
        for ($i = 0; $i < $max; $i++) {
            $gbchar = substr($teks, ($i * $s), $s);
            $code = 0;

            for ($j = 0; $j < $s; $j++) {
                // karakter jadikan ASCII * 256^urutan karakter
                $code = $code + (ord($gbchar[$j]) * bcpow(256, $j));
            }

            // karkater ASCII
            $ASCII .= $code . " ";

            //perkalian 
            $perkalian .= "($code^$e mod $n) ";

            // karakter = karakter ^ E (mod N)
            $code = bcpowmod($code, $e, $n);
            $isiteks .= $code . " ";
        }
        $ASCII = trim($ASCII);
        $perkalian = trim($perkalian);
        $isiteks = trim($isiteks);

        $hasil = [
            'ASCII' => $ASCII,
            'perkalian' => $perkalian,
            'isiteks' => $isiteks,
        ];
        return $hasil;
    }

    public function dekripsi()
    {
        $rsa_key = rsa_key();

        $D = ['success' => false, 'message' => 'Maaf, tidak ada perintah!'];

        $chip = $this->input->post('chip');
        if (!empty($chip)) {
            $d = $rsa_key['d'];
            $n = $rsa_key['n'];

            $hasil = $this->decode_rsa($chip, $d, $n);

            $proses = [
                'Chipperteks' => $chip,
                'd' => $d,
                'n' => $n,
                'Chipper^d mod n' => $hasil['perkalian'],
                'ASCII' => $hasil['ASCII'],
                'Plainteks' => $hasil['isiteks']
            ];

            $message  = "<div class='alert alert-warning'>";
            $message .= '<h5><i class="icon fas fa-info"></i> Proses Dekripsi!</h5>';
            $message .= '<pre>' . var_export($proses, true) . '</pre>';
            $message .= "</div>";

            $D = [
                'success' => true,
                'message' => $message,
                'proses' => $proses
            ];
        }


        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    function decode_rsa($encode, $d, $n)
    {
        $isiteks = "";
        $char = explode(" ", $encode);
        $jmlchar = count($char);
        $perkalian = "";
        $ASCIITEKS = "";

        for ($i = 0; $i < $jmlchar; $i++) {
            // karakter = karakter enkripsi ^ D (mod N)
            $code = bcpowmod($char[$i], $d, $n);

            // perkalian
            $perkalian .= "($char[$i]^$d mod $n) ";

            while (bccomp($code, "0") != 0) {
                // kembalikan nilai ASCII (mod 256 dari karakter div 256) ke karakter asli
                $ascii = $code % 256;
                $code = floor($code / 256);
                $isiteks .= chr($ascii);

                $ASCIITEKS .= "$ascii ";
            }
        }

        $hasil = [
            'isiteks' => $isiteks,
            'perkalian' => trim($perkalian),
            'ASCII' => trim($ASCIITEKS)
        ];

        return $hasil;
    }
}
