<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi_model', 'transaksi');
        $this->load->library('cart');
        $this->load->library('encryption');
        is_logged_in();
    }

    public function index()
    {
        $cari = $this->input->cookie('fcari');
        $data_array = []; // inisiasi terlebih dahulu

        $transaksi = $this->transaksi->get_all_transaksi(); // ambil data terlebih dahulu di database

        if (!empty($cari)) {
            // proses pencarian menggunakan sequential search
            for ($i = 0; $i < count($transaksi); $i++) {
                $cari = strtolower($cari);
                if ($cari == strtolower($transaksi[$i]['no_trans'])) { // jika pencarian sama dengan no transaksi
                    array_push($data_array, $transaksi[$i]);
                } else if ($cari == strtolower($transaksi[$i]['jenis_transaksi'])) { // jika pencarian sama dengan jenis transaksi
                    array_push($data_array, $transaksi[$i]);
                } else if ($cari == strtolower($transaksi[$i]['nama_suplier'])) { // jika pencarian sama dengan nama suplier
                    array_push($data_array, $transaksi[$i]);
                } else if ($cari == strtolower($transaksi[$i]['jenis_pembayaran'])) { // jika pencarian sama dengan jenis pembayaran
                    array_push($data_array, $transaksi[$i]);
                }
            }
            $count = count($data_array);
            if ($count > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $count . ' data ditemukan!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">data tidak ditemukan!</div>');
            }
        } else {

            $data_array = $transaksi;
        }
        $data = [
            'url' => 'transaksi/add', //url
            'title' => 'Transaksi', //judul halaman
            'allTransaksi' => $data_array, //ambil semua data transaksi
        ];
        $this->render('transaksi/transaksi_index', $data);
    }

    public function add()
    {
        // kondisi jika data transaksi sementara ada maka akan dihapus terlebih dahulu
        if (!empty($this->cart->contents())) {
            $this->cart->destroy();
        }

        $data = [
            'url' => "transaksi/add", // url
            'title' => 'Form Transaksi', // judul halaman
            'no_trans' => $this->transaksi->get_no_trans(), // ambil no transaksi
            'suplier' => $this->transaksi->get_all_suplier(),
            'proyek' => $this->transaksi->get_all_proyek(),
            'satuan' => $this->transaksi->get_all_satuan(),
        ];
        $this->render('transaksi/transaksi_form', $data);
    }

    public function jenis()
    {
        $jenis = $this->input->get('jenis', true);
        $data = [];

        if ($jenis === "barang") { //==> kondisi jika jenis transaksi adalah barang

            $query = $this->transaksi->get_all_barang(); //==> ambil semua data barang

            foreach ($query as $value) {
                $data[] = [
                    'id' => $value['id'],
                    'nama' => $value['nama_barang']
                ];
            }
        } else if ($jenis === "alat") { // ==>kondisi jika jenis transaksi adalah alat

            $query = $this->transaksi->get_all_alat(); // ==> ambil semua data alat

            foreach ($query as $value) {
                $data[] = [
                    'id' => $value['id'],
                    'nama' => $value['nama_alat']
                ];
            }
        } else if ($jenis === "transportasi") { // ==> kondisi jika jenis transaksi adalah transportasi

            $query = $this->transaksi->get_all_transportasi();  //==> ambil semua data transportasi

            foreach ($query as $value) {
                $data[] = [
                    'id' => $value['id'],
                    'nama' => $value['nama_kendaraan']
                ];
            }
        }

        if (empty($data)) {
            $D = ['successs' => false, 'message' => 'tidak ditemukan'];
        } else {
            $D = ['success' => true, 'message' => 'data ditampilkan!', 'data' => $data];
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function add_item()
    {
        $jenis_transaksi = $this->input->post('jenis_transaksi', true);
        $id = $this->input->post('item', true);
        $jumlah = $this->input->post('jumlah', true);
        $harga = $this->input->post('harga', true);
        $satuan = $this->input->post('satuan', true);
        $data = $this->transaksi->get_item("tb_" . $jenis_transaksi, $id);

        $jenis = $jenis_transaksi == 'transportasi' ? 'kendaraan' : $jenis_transaksi;

        if (!empty($data)) {
            $cart = array(
                'id'      => $data['id'],
                'qty'     => $jumlah,
                'price'   => $harga,
                'name'    => $data['nama_' . $jenis],
                'options' => array('satuan' => $satuan)
            );

            $this->cart->insert($cart);
            $D = [
                'success' => true,
                'message' => 'data berhasil ditambahkan!',
            ];
        } else {
            $D = [
                'success' => false,
                'message' => 'data tidak ditemukan!',
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function tampil_data()
    {
        $data  = $this->cart->contents();
        $data_array = [];
        $grand_total = 0;

        if (!empty($data)) {

            foreach ($data as $key => $value) {
                $id_satuan = $value['options']['satuan'];
                $satuan = $this->db->get_where('tb_satuan', ['satuan_id' => $id_satuan])->row()->satuan;

                $data_array[] = [
                    'id'      => $value['id'],
                    'qty'     => $value['qty'],
                    'price'   => $value['price'],
                    'name'    => $value['name'],
                    'subtotal' => $value['subtotal'],
                    'satuan' => $satuan
                ];
            }
            $grand_total = $this->cart->total();
        }

        $D = ['data' => $data_array, 'grand_total' => $grand_total];

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function destroy()
    {
        $this->cart->destroy(); //=> hapus semua data sementara

        $D = ['message' => 'success destroyed!'];

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function remove()
    {
        $rowid = $this->input->post('rowid', true);
        $success = $this->cart->remove($rowid);

        if ($success) {
            $D = ['success' => true, 'message' => 'Data berhasil dihapus..'];
        } else {
            $D = ['success' => false, 'message' => 'Data tidak ditemukan!'];
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function simpan()
    {
        $data_trans = [];
        $D = ['success' => false, 'message' => 'not allowed'];

        $this->form_validation->set_rules('no_trans', 'No Trans', 'trim|required', [
            'required' => 'No Trans tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('suplier', 'Suplier', 'trim|required', [
            'required' => 'Suplier tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('jenis_transaksi', 'Jenis Transaksi', 'trim|required', [
            'required' => 'Jenis Transaksi tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('proyek', 'Proyek', 'trim|required', [
            'required' => 'Proyek tidak Boleh Kosong!'
        ]);
        $this->form_validation->set_rules('jenis_pembayaran', 'Jenis Pembayaran', 'trim|required', [
            'required' => 'Jenis Pembayaran tidak Boleh Kosong!'
        ]);

        if ($this->form_validation->run() == false) {
            $error = validation_errors();
            $D = ['success' => false, 'message' => $error];
        } else {

            $no_trans = $this->transaksi->get_no_trans();
            $total_trans = $this->cart->total();
            $cek = '';

            $data_trans = [
                'no_trans' => $no_trans,
                'total' => $total_trans,
                'suplier' => $this->input->post('suplier', true),
                'jenis_transaksi' => $this->input->post('jenis_transaksi', true),
                'proyek' => $this->input->post('proyek', true),
                'jenis_pembayaran' => $this->input->post('jenis_pembayaran', true),
                'date_created' => $this->input->post('date_created', true),
            ];

            if (!empty($_FILES['bukti_bayar']['name'])) { // jika user upload bukti transfer
                $config['upload_path'] = './uploads/bukti/';
                $config['allowed_types'] = 'jpg|png';
                $config['encrypt_name'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti_bayar')) {
                    $error = $this->upload->display_errors();
                    $cek = $error;
                } else {
                    $post_image = $this->upload->data();
                    $data_trans['bukti_bayar'] = $post_image['file_name'];
                }
            }

            if (!empty($cek)) {
                $D = ['success' => false, 'message' => $cek]; // info error
            } else {
                $sub_trans = [];

                foreach ($this->cart->contents() as $key => $value) {
                    $sub_trans[] = [
                        'no_trans' => $no_trans,
                        'id_item' => $value['id'],
                        'jenis' => $this->input->post('jenis_transaksi', true),
                        'jumlah' => $value['qty'],
                        'satuan' => $value['options']['satuan'],
                        'harga' => $value['price'],
                    ];
                }
                //insert
                $transaksi = $this->db->insert('tb_transaksi', $data_trans);
                //insert batch
                $sub_transaksi = $this->db->insert_batch('tb_sub_transaksi', $sub_trans);

                if ($transaksi && $sub_transaksi) {
                    $D = ['success' => true, 'message' => 'Data berhasil disimpan!'];
                    $this->cart->destroy(); //=> hapus semua data sementara
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil disimpan!</div>');
                } else {
                    $D = ['success' => false, 'message' => 'Data gagal disimpan!'];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($D);
        exit();
    }

    public function hapus($no_trans)
    {
        $no_trans = decode($no_trans);

        $data = $this->db->get_where('tb_transaksi', ['no_trans' => $no_trans])->row_array();


        if (!empty($data)) {
            $trans = $this->transaksi->delete_transaksi_info($no_trans);
            $sub = $this->transaksi->delete_subtransaksi_info($no_trans);

            if ($trans && $sub) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal disimpan!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak ditemukan!</div>');
        }

        redirect('transaksi', 'refresh');
    }

    public function detail($no_trans)
    {
        $no_trans = decode($no_trans);

        $trans = $this->transaksi->get_transaksi_id($no_trans);

        $sub_trans = $this->transaksi->get_subtransaksi_id($no_trans, $trans['jenis_transaksi']);

        $data = [
            'title' => 'Detail Transaksi ' . $trans['no_trans'],
            'trans' => $trans,
            'sub_trans' => $sub_trans
        ];

        $this->render('transaksi/transaksi_detail', $data);
    }
}
