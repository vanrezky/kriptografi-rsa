<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Riwayat_model extends CI_Model
{
    protected $table = 'riwayat_pasien';
    protected $primary_key = 'id';

    // ambil data
    public function getData($id = false, $allData = TRUE)
    {
        $table = $this->table;
        if ($id !== false) {

            return $this->db->get_where($table, [$this->primary_key => $id])->row_array();
        }
        $this->db->order_by($this->primary_key, 'DESC');

        if ($allData) {
            $this->db->select("$table.*, pasien.kode_pasien, pasien.nama_pasien, pasien.nik, pasien.alamat, pasien.no_hp, dokter.nama_dokter, perawat_bidan.nama");
            $this->db->join('pasien', "pasien.id=$table.id_pasien", 'LEFT');
            $this->db->join('dokter', "dokter.id=$table.id_dokter", 'LEFT');
            $this->db->join('perawat_bidan', "perawat_bidan.id=$table.id_pb", 'LEFT');
            return $this->db->get($table)->result_array();
        }
        return [];
    }

    // ambil data
    public function getDataLaporan($awal = "", $akhir = "")
    {
        if (!empty($awal) && !empty($akhir)) {
            $table = $this->table;
            $this->db->select("$table.*, pasien.kode_pasien, pasien.nama_pasien, pasien.nik, pasien.alamat, pasien.no_hp, dokter.nama_dokter, perawat_bidan.nama");
            $this->db->join('pasien', "pasien.id=$table.id_pasien", 'LEFT');
            $this->db->join('dokter', "dokter.id=$table.id_dokter", 'LEFT');
            $this->db->join('perawat_bidan', "perawat_bidan.id=$table.id_pb", 'LEFT');
            $this->db->where('riwayat_pasien.tgl_berobat BETWEEN "' . date('Y-m-d', strtotime($awal)) . '" and "' . date('Y-m-d', strtotime($akhir)) . '"');
            $this->db->order_by($this->primary_key, 'DESC');
            return $this->db->get($table)->result_array();
        }

        return [];
    }

    //simpan atau update data 
    public function saveData($id = false, $data = [])
    {
        if ($id === false) {
            return $this->db->insert($this->table, $data);
        }

        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteData($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table);
    }
}
