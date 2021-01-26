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
            'title' => 'Implemenasi RSA',
            'data_rsa' => $data_rsa
        ];
        $this->render('v_rsa_index', $data);
    }
}
