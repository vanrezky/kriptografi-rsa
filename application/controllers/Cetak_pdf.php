<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak_pdf extends CI_Controller
{

    // $enkripsi1 = encode_rsa($pesan, $rsa_key['e'], $rsa_key['n']);
    // $dekripsi1 = decode_rsa($enkripsi1, $rsa_key['d'], $rsa_key['n']);

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // fungsi jika sudah login

    }
    public function pasien()
    {
        $this->load->model('pasien_model', 'pasien');

        $data = [
            'title' => 'Laporan Pasien',
            'data' => $this->pasien->getData(),
            'rsa_key' => rsa_key()
        ];
        $this->load->library('pdf');
        $this->pdf->filename = "laporan-pasien.pdf";
        $this->pdf->load_view('v_pdf_laporan_pasien', $data);
    }

    public function dokter()
    {
        $this->load->model('dokter_model', 'dokter');
        $data = [
            'title' => 'Laporan Dokter',
            'data' => $this->dokter->getData(),
            'rsa_key' => rsa_key()
        ];
        $this->load->library('pdf');
        $this->pdf->filename = "laporan-dokter.pdf";
        $this->pdf->load_view('v_pdf_laporan_dokter', $data);
    }

    public function perawat_bidan()
    {
        $this->load->model('perawat_bidan_model', 'perawat_bidan');
        $data = [
            'title' => 'Laporan Perawat Bidan',
            'data' => $this->perawat_bidan->getData(),
            'rsa_key' => rsa_key()
        ];
        $this->load->library('pdf');
        $this->pdf->filename = "laporan-perawat-bidan.pdf";
        $this->pdf->load_view('v_pdf_laporan_perawat_bidan', $data);
    }

    public function riwayat()
    {
        $this->load->model('riwayat_model', 'riwayat');
        $data = [
            'title' => 'Laporan Riwayat Rekam Medis Pasien',
            'data' => $this->riwayat->getData(),
            'rsa_key' => rsa_key()
        ];
        $this->load->library('pdf');
        $this->pdf->filename = "laporan-riwayat-pasien.pdf";
        $this->pdf->load_view('v_pdf_laporan_riwayat', $data);
    }

    public function laporan($tgl_awal = "", $tgl_akhir = "")
    {
        $this->load->model('riwayat_model', 'riwayat');
        $data = $this->riwayat->getDataLaporan($tgl_awal, $tgl_akhir);

        $data = [
            'title' => 'Laporan Riwayat Pasien ',
            'tgl' => format_hari_tanggal($tgl_awal) . ' - ' . format_hari_tanggal($tgl_akhir),
            'data' => $data,
            'rsa_key' => rsa_key(),
        ];

        $this->load->library('pdf');
        $this->pdf->filename = "laporan-riwayat-pasien-tgl-$tgl_awal-sampai-$tgl_akhir.pdf";
        $this->pdf->load_view('v_pdf_laporan_cetak', $data);
    }
}
