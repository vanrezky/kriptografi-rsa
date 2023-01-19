<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends MY_Controller
{

	// $enkripsi1 = encode_rsa($pesan, $rsa_key['e'], $rsa_key['n']);
	// $dekripsi1 = decode_rsa($enkripsi1, $rsa_key['d'], $rsa_key['n']);

	public function __construct()
	{
		parent::__construct();
		is_logged_in(); // fungsi jika sudah login
		$this->load->model('dokter_model', 'dokter');
	}

	public function index()
	{	//panggil key rsa
		$rsa_key = rsa_key();

		$data_array = [];
		$getData = $this->dokter->getData();

		if (count($getData) > 0) {
			foreach ($getData as $key => $value) {
				$data_array[] = [
					'id' 			=> $value['id'],
					'nama_dokter' 	=> $value['nama_dokter'],
					'nip' 			=> decode_rsa($value['nip'], $rsa_key['d'], $rsa_key['n']),
					'no_hp' 		=> decode_rsa($value['no_hp'], $rsa_key['d'], $rsa_key['n']),
					'foto' 			=> $value['foto']
				];
			}
		}

		$data = [
			'title' => 'Dokter',
			'data' => $data_array
		];

		$this->render('v_dokter_index', $data);
	}


	public function data($id = false)
	{
		//panggil key rsa
		$rsa_key = rsa_key();

		// kondisi jika id tidak sama dengan false
		if ($id !== false) $id = decode($id);

		// start form validasi
		if ($id === false) {
			$this->form_validation->set_rules('nip', 'NIP', 'trim|required|is_unique[dokter.nip]', [
				'required' => 'NIP tidak Boleh Kosong!',
				'numeric' => 'NIP harus berupa angka!',
				'is_unique' => 'NIP sudah terdaftar!'
			]);
		}

		$this->form_validation->set_rules('nama_dokter', 'Nama dokter', 'trim|required', [
			'required' => 'Nama dokter tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('no_hp', 'Nomor Handphone', 'trim|numeric', [
			'required' => 'Nomor Handphone tidak Boleh Kosong!',
			'numeric' => 'Nomor Handphone harus berupa angka!'
		]);

		// kondisi validasi
		if ($this->form_validation->run() == false) { // jika validasi gagal

			$error = validation_errors();
			$allData = false;
			$getData = $this->dokter->getData($id, $allData);
			$data_array = [];
			if (!empty($getData)) {
				$data_array = [
					'id' => $getData['id'],
					'nama_dokter' => $getData['nama_dokter'],
					'nip' => decode_rsa($getData['nip'], $rsa_key['d'], $rsa_key['n']),
					'no_hp' => decode_rsa($getData['no_hp'], $rsa_key['d'], $rsa_key['n']),
					'foto' => $getData['foto'],
				];
			}

			$data = [
				'title' => 'Data dokter',
				'data' => $data_array,
				'error' => !empty($error) ? $error : ''
			];

			$this->render('v_dokter_data', $data);

			// jika validasi benar
		} else {

			$data = [
				'nama_dokter' 	=>  $this->input->post('nama_dokter', true),
				'nip' 			=> 	encode_rsa($this->input->post('nip', true), $rsa_key['e'], $rsa_key['n']),
				'no_hp' 		=>  encode_rsa($this->input->post('no_hp', true), $rsa_key['e'], $rsa_key['n']),
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
						$dokter = $this->dokter->getData($id);
						$src = 'public/uploads/img/';
						if ($dokter['foto'] != 'default.png') {
							if (file_exists(FCPATH . $src . $dokter['foto'])) {
								unlink($src . $dokter['foto']);
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
				redirect('dokter');
			} else {
				if ($id) {
					$data['updated_at'] = current_timestamp();
				} else {
					$data['created_at'] = current_timestamp();
				}
				$save = $this->dokter->saveData($id, $data);
				if ($save) {
					$this->session->set_flashdata('message', alert('Data berhasil disimpan!', 'success'));
				} else {
					$this->session->set_flashdata('message', alert('Data gagal disimpan!', 'danger'));
				}
				redirect('dokter', 'refresh');
			}
		}
	}

	public function hapus($id = false)
	{

		if ($id !== false) $id = decode($id);

		if ($id) {

			$data = $this->dokter->getData($id);
			$src = 'public/uploads/img/';
			if ($data['foto'] != 'default.png') {
				if (file_exists(FCPATH . $src . $data['foto'])) {
					unlink($src . $data['foto']);
				}
			}

			$delete = $this->dokter->deleteData($id);

			if ($delete) {
				$this->session->set_flashdata('message', alert('Data berhasil dihapus!', 'success'));
			} else {
				$this->session->set_flashdata('message', alert('Data gagal dihapus', 'danger'));
			}
		} else {
			$this->session->set_flashdata('message', alert('Maaf, data tidak ditemukan!', 'danger'));
		}
		redirect('dokter', 'refresh');
	}
}
