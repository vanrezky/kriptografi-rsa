<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends MY_Controller
{

	// $enkripsi1 = encode_rsa($pesan, $rsa_key['e'], $rsa_key['n']);
	// $dekripsi1 = decode_rsa($enkripsi1, $rsa_key['d'], $rsa_key['n']);

	public function __construct()
	{
		parent::__construct();
		is_logged_in(); // fungsi jika sudah login
		$this->load->model('pasien_model', 'pasien');
	}

	public function index()
	{	//panggil key rsa
		$rsa_key = rsa_key();

		$data_array = [];
		$getData = $this->pasien->getData();

		if (count($getData) > 0) {
			foreach ($getData as $key => $value) {
				$data_array[] = [
					'id' 			=> $value['id'],
					'kode_pasien' 	=> $value['kode_pasien'],
					'nama_pasien' 	=> $value['nama_pasien'],
					'nik' 			=> decode_rsa($value['nik'], $rsa_key['d'], $rsa_key['n']),
					'no_hp' 		=> decode_rsa($value['no_hp'], $rsa_key['d'], $rsa_key['n']),
					'kategori' 		=> ucfirst($value['kategori']),
					'jenis_kelamin' => ucfirst($value['jenis_kelamin']),
					'umur' 			=> $value['umur'],
					'alamat' 		=> ucfirst($value['alamat']),
				];
			}
		}

		$data = [
			'title' => 'Pasien',
			'data' => $data_array
		];

		$this->render('v_pasien_index', $data);
	}


	public function data($id = false)
	{
		//panggil key rsa
		$rsa_key = rsa_key();
		// kondisi jika id tidak sama dengan false
		if ($id !== false) $id = decode($id);

		// start form validasi
		if ($id === false) {
			$this->form_validation->set_rules('nik', 'NIK', 'required|numeric', [
				'required' => 'NIK tidak Boleh Kosong!',
				'numeric' => 'NIK harus berupa angka!',
			]);
			$this->form_validation->set_rules('kode_pasien', 'kode_pasien', 'trim|numeric|is_unique[pasien.kode_pasien]', [
				'numeric' => 'Kode pasien harus berupa angka!',
				'is_unique' => 'Kode pasien sudah terdaftar!'
			]);
		}

		$this->form_validation->set_rules('nama_pasien', 'Nama pasien', 'trim|required', [
			'required' => 'Nama pasien tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required', [
			'required' => 'Kategori tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis kelamin', 'trim|required', [
			'required' => 'Jenis kelamin tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('umur', 'Umur', 'trim|required', [
			'required' => 'Umur tidak Boleh Kosong!'
		]);
		$this->form_validation->set_rules('no_hp', 'Nomor Handphone', 'trim|required|numeric', [
			'required' => 'Nomor Handphone tidak Boleh Kosong!',
			'numeric' => 'Nomor Handphone harus berupa angka!'
		]);
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required', [
			'required' => 'Alamat tidak Boleh Kosong!'
		]);

		// kondisi validasi
		if ($this->form_validation->run() == false) { // jika validasi gagal

			$error = validation_errors();
			$allData = false;
			$getData = $this->pasien->getData($id, $allData);
			$data_array = [];
			if (!empty($getData)) {
				$data_array = [
					'id' => $getData['id'],
					'kode_pasien' => $getData['kode_pasien'],
					'nama_pasien' => $getData['nama_pasien'],
					'kategori' => $getData['kategori'],
					'jenis_kelamin' => $getData['jenis_kelamin'],
					'umur' => $getData['umur'],
					'alamat' => $getData['alamat'],
					'nik' => decode_rsa($getData['nik'], $rsa_key['d'], $rsa_key['n']),
					'no_hp' => decode_rsa($getData['no_hp'], $rsa_key['d'], $rsa_key['n']),
				];
			}

			$data = [
				'title' => 'Data pasien',
				'data' => $data_array,
				'kategori' => ['bayi', 'anak-anak', 'dewasa', 'lansia'],
				'jenis_kelamin' => ['laki-laki', 'perempuan'],
				'error' => !empty($error) ? $error : ''

			];

			$this->render('v_pasien_data', $data);

			// jika validasi benar
		} else {
			$cek = ""; // cek nik sudah terdaftar
			if ($id === false) {
				$nik = encode_rsa($this->input->post('nik', true), $rsa_key['e'], $rsa_key['n']);
				$cek = $this->db->get_where('pasien', ['nik' => $nik])->row_array();
			}

			if (empty($cek)) {
				$data = [
					'nama_pasien' 	=>  $this->input->post('nama_pasien', true),
					'kategori' 	=>  $this->input->post('kategori', true),
					'jenis_kelamin' 	=>  $this->input->post('jenis_kelamin', true),
					'umur' 	=>  $this->input->post('umur', true),
					'alamat' 	=>  $this->input->post('alamat', true),
					'no_hp' 		=>  encode_rsa($this->input->post('no_hp', true), $rsa_key['e'], $rsa_key['n']),
				];

				if ($id) {
					$data['updated_at'] = current_timestamp();
				} else {
					$data['kode_pasien'] = $this->pasien->buatKode();
					$data['nik'] = encode_rsa($this->input->post('nik', true), $rsa_key['e'], $rsa_key['n']);
					$data['created_at'] = current_timestamp();
				}
				$save = $this->pasien->saveData($id, $data);
				if ($save) {
					$this->session->set_flashdata('message', alert('Data berhasil disimpan!', 'success'));
				} else {
					$this->session->set_flashdata('message', alert('Data gagal disimpan!', 'danger'));
				}
			} else {
				$this->session->set_flashdata('message', alert('Maaf nik sudah terdaftar!', 'danger'));
			}
			redirect('pasien', 'refresh');
		}
	}

	public function hapus($id = false)
	{

		if ($id !== false) $id = decode($id);

		if ($id) {

			// $data = $this->pasien->getData($id);
			// $src = 'public/uploads/img/';
			// if ($data['foto'] != 'default.png') {
			// 	if (file_exists(FCPATH . $src . $data['foto'])) {
			// 		unlink($src . $data['foto']);
			// 	}
			// }

			$delete = $this->pasien->deleteData($id);

			if ($delete) {
				$this->session->set_flashdata('message', alert('Data berhasil dihapus!', 'success'));
			} else {
				$this->session->set_flashdata('message', alert('Data gagal dihapus', 'danger'));
			}
		} else {
			$this->session->set_flashdata('message', alert('Maaf, data tidak ditemukan!', 'danger'));
		}
		redirect('pasien', 'refresh');
	}
}
