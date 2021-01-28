<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends MY_Controller
{

    // $enkripsi1 = encode_rsa($pesan, $rsa_key['e'], $rsa_key['n']);
    // $dekripsi1 = decode_rsa($enkripsi1, $rsa_key['d'], $rsa_key['n']);

    public function __construct()
    {
        parent::__construct();
        is_logged_in(); // fungsi jika sudah login
        $this->load->model('riwayat_model', 'riwayat');
        $this->load->model('pasien_model', 'pasien');
        $this->load->model('dokter_model', 'dokter');
        $this->load->model('perawat_bidan_model', 'perawat_bidan');
    }

    public function index()
    {    //panggil key rsa

        $data = [
            'title' => 'Riwayat Pasien',
            'data' => $this->riwayat->getData(),
            'rsa_key' => rsa_key()
        ];

        $this->render('v_riwayat_index', $data);
    }


    public function data($id = false)
    {
        //panggil key rsa
        $rsa_key = rsa_key();
        // kondisi jika id tidak sama dengan false
        if ($id !== false) $id = decode($id);

        // start form validasi
        $this->form_validation->set_rules('id_pasien', 'id_pasien', 'trim|required', [
            'required' => 'pasien tidak Boleh Kosong!',
        ]);
        $this->form_validation->set_rules('tgl_berobat', 'tgl_berobat', 'trim|required', [
            'required' => 'Tanggal berobat tidak Boleh Kosong!',
        ]);
        $this->form_validation->set_rules('gejala', 'Gejala', 'trim|required', [
            'required' => 'Gejala tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('tb', 'Tinggi badan', 'trim|required', [
            'required' => 'Tinggi badan tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('bb', 'Berat Badan', 'trim|required', [
            'required' => 'Berat Badan tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('td', 'Tekanan darah', 'trim|required', [
            'required' => 'Tekanan darah tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('kat_penyakit', 'Kategori penyakit', 'trim|required', [
            'required' => 'Kategori penyakit tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('obat', 'obat', 'trim|required', [
            'required' => 'Obat tidak Boleh Kosong!',
        ]);

        // kondisi validasi
        if ($this->form_validation->run() == false) { // jika validasi gagal

            $error = validation_errors();
            $allData = false;
            $data = [
                'title' => 'Data Riwayat Pasien',
                'data' => $this->riwayat->getData($id, $allData),
                'pasien' => $this->pasien->getData(),
                'dokter' => $this->dokter->getData(),
                'perawat_bidan' => $this->perawat_bidan->getData(),
                'kat_penyakit' => [
                    ['val' => 'TM', 'label' => 'Tidak Menular'],
                    ['val' => 'M', 'label' => 'Menular'],
                ],
                'rsa_key' => $rsa_key,
                'error' => !empty($error) ? $error : ''

            ];

            $this->render('v_riwayat_data', $data);

            // jika validasi benar
        } else {

            $data = [
                'id_pasien'         =>  decode($this->input->post('id_pasien', true)),
                'tgl_berobat'       =>  $this->input->post('tgl_berobat', true),
                'gejala'            =>  encode_rsa($this->input->post('gejala', true), $rsa_key['e'], $rsa_key['n']),
                'tb'                =>  $this->input->post('tb', true),
                'bb'                =>  $this->input->post('bb', true),
                'td'                =>  $this->input->post('td', true),
                'kat_penyakit'      =>  $this->input->post('kat_penyakit', true),
                'obat'              =>  encode_rsa($this->input->post('obat', true), $rsa_key['e'], $rsa_key['n']),
                'id_dokter'         =>  !empty(trim($this->input->post('id_dokter', true))) ? decode($this->input->post('id_dokter', true)) : NULL,
                'id_pb'             => !empty(trim($this->input->post('id_perawat_bidan', true))) ? decode($this->input->post('id_perawat_bidan', true)) : NULL,
            ];

            if ($id) {
                $data['updated_at'] = current_timestamp();
            } else {
                $data['created_at'] = current_timestamp();
            }
            $save = $this->riwayat->saveData($id, $data);
            if ($save) {
                $this->session->set_flashdata('message', alert('Data berhasil disimpan!', 'success'));
            } else {
                $this->session->set_flashdata('message', alert('Data gagal disimpan!', 'danger'));
            }
            redirect('riwayat', 'refresh');
        }
    }

    public function hapus($id = false)
    {

        if ($id !== false) $id = decode($id);

        if ($id) {

            $delete = $this->riwayat->deleteData($id);

            if ($delete) {
                $this->session->set_flashdata('message', alert('Data berhasil dihapus!', 'success'));
            } else {
                $this->session->set_flashdata('message', alert('Data gagal dihapus', 'danger'));
            }
        } else {
            $this->session->set_flashdata('message', alert('Maaf, data tidak ditemukan!', 'danger'));
        }
        redirect('riwayat', 'refresh');
    }
}
