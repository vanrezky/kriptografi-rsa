<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perawat_bidan extends MY_Controller
{


	// $enkripsi1 = encode_rsa($pesan, $rsa_key['e'], $rsa_key['n']);
	// $dekripsi1 = decode_rsa($enkripsi1, $rsa_key['d'], $rsa_key['n']);

	public function __construct()
	{
		parent::__construct();
		is_logged_in(); // fungsi jika sudah login
		$this->load->model('perawat_bidan_model', 'perawat_bidan');
	}



	public function index()
	{
		// panggil key rsa
		$rsa_key = rsa_key();

		$data_array = [];
		$getData = $this->perawat_bidan->getData();

		if (count($getData) > 0) {
			foreach ($getData as $key => $value) {
				$data_array[] = [
					'id' 		=> $value['id'],
					'nama' => $value['nama'],
					'nip' 		=> decode_rsa($value['nip'], $rsa_key['d'], $rsa_key['n']),
					'pekerjaan' => $value['pekerjaan'],
					'no_hp' 	=> decode_rsa($value['no_hp'], $rsa_key['d'], $rsa_key['n']),
					'foto' 		=> $value['foto']
				];
			}
		}

		$data = [
			'title' => 'Perawat & Bidan',
			'data' => $data_array,
		];

		$this->render('v_perawat_bidan_index', $data);
	}


	public function data($id = false)
	{
		// ambil key rsa terlebih dahulu
		$rsa_key = rsa_key();
		// kondisi jika id tidak sama dengan false
		if ($id !== false) $id = decode($id);

		// start form validasi
		if ($id === false) {
			$this->form_validation->set_rules('nip', 'NIP', 'trim|required|numeric|is_unique[perawat_bidan.nip]', [
				'required' => 'NIP tidak Boleh Kosong!',
				'numeric' => 'NIP harus berupa angka!',
				'is_unique' => 'NIP sudah terdaftar!'
			]);
		}

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
			'required' => 'Nama tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('no_hp', 'Nomor Handphone', 'trim|required|numeric', [
			'required' => 'Nomor Handphone tidak Boleh Kosong!',
			'numeric' => 'Nomor Handphone harus berupa angka!'
		]);
		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'trim|required', [
			'required' => 'Pekerjaan tidak Boleh Kosong!'
		]);

		// kondisi validasi
		if ($this->form_validation->run() == false) { // jika validasi gagal

			$error = validation_errors();
			$allData = false; // semua data 
			$getData = $this->perawat_bidan->getData($id, $allData);

			$data_array = [];
			if (!empty($getData)) {
				$data_array = [
					'id' 		=> $getData['id'],
					'nama' 		=> $getData['nama'],
					'nip' 		=> decode_rsa($getData['nip'], $rsa_key['d'], $rsa_key['n']),
					'pekerjaan' => $getData['pekerjaan'],
					'no_hp' 	=> decode_rsa($getData['no_hp'], $rsa_key['d'], $rsa_key['n']),
					'foto' 		=> $getData['foto'],
				];
			}

			$data = [
				'title' => 'Data perawat bidan',
				'data' => $data_array,
				'pekerjaan' => ['perawat', 'bidan'],
				'error' => !empty($error) ? $error : ''
			];
			$this->render('v_perawat_bidan_data', $data);

			// jika validasi benar
		} else {


			$data = [
				'nip' 	=> 	encode_rsa($this->input->post('nip', true), $rsa_key['e'], $rsa_key['n']),
				'nama' 	=>  $this->input->post('nama', true),
				'no_hp' =>  encode_rsa($this->input->post('no_hp', true), $rsa_key['e'], $rsa_key['n']),
				'pekerjaan' =>  $this->input->post('pekerjaan', true),
			];

			$cek = '';
			if (!empty($_FILES['foto']['name'])) {
				$config['upload_path'] = './public/uploads/img/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('foto')) {
					$error = $this->upload->display_errors();
					$cek = $error;
				} else {
					if ($id) {
						$perawat_bidan = $this->perawat_bidan->getData($id);
						$src = 'public/uploads/img/';
						if ($perawat_bidan['foto'] != 'default.png') {
							if (file_exists(FCPATH . $src . $perawat_bidan['foto'])) {
								unlink($src . $perawat_bidan['foto']);
							}
						}
					}
					$post_image = $this->upload->data();
					$data['foto'] = $post_image['file_name'];
				}
			} else {
				if ($id === false) {
					$data['foto'] = 'default.png';
				}
			}

			if (!empty($cek)) {
				$this->session->set_flashdata('message', alert($cek, 'danger'));
				redirect('perawat_bidan');
			} else {
				if ($id) {
					$data['updated_at'] = current_timestamp();
				} else {
					$data['created_at'] = current_timestamp();
				}
				$save = $this->perawat_bidan->saveData($id, $data);
				if ($save) {
					$this->session->set_flashdata('message', alert('Data berhasil disimpan!', 'success'));
				} else {
					$this->session->set_flashdata('message', alert('Data gagal disimpan!', 'danger'));
				}
				redirect('perawat_bidan', 'refresh');
			}
		}
	}

	public function hapus($id = false)
	{

		if ($id !== false) $id = decode($id);

		if ($id) {

			$data = $this->perawat_bidan->getData($id);
			$src = 'public/uploads/img/';
			if ($data['foto'] != 'default.png') {
				if (file_exists(FCPATH . $src . $data['foto'])) {
					unlink($src . $data['foto']);
				}
			}

			$delete = $this->perawat_bidan->deleteData($id);

			if ($delete) {
				$this->session->set_flashdata('message', alert('Data berhasil dihapus!', 'success'));
			} else {
				$this->session->set_flashdata('message', alert('Data gagal dihapus', 'danger'));
			}
		} else {
			$this->session->set_flashdata('message', alert('Maaf, data tidak ditemukan!', 'danger'));
		}
		redirect('perawat_bidan', 'refresh');
	}
}
