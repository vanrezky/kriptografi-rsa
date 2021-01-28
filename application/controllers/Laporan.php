<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Laporan extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        // $this->load->model('laporan_model', 'laporan');
        $this->load->model('riwayat_model', 'riwayat');
        is_logged_in();
    }

    public function index()
    {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $data = $this->riwayat->getDataLaporan($tgl_awal, $tgl_akhir);

        $data = [
            'title' => 'Laporan Riwayat Pasien',
            'data' => $data,
            'rsa_key' => rsa_key(),
            'tgl' => ['awal' => $tgl_awal, 'akhir' => $tgl_akhir],
            'count' => count($data)
        ];

        $this->render('v_laporan_index', $data);
    }
}
