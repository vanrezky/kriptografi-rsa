<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Pasien_model extends CI_Model
{
    protected $table = 'pasien';
    protected $primary_key = 'id';

    public function buatKode()
    {

        $this->db->select("RIGHT($this->table.$this->primary_key ,4) as kode", FALSE);
        $this->db->order_by($this->primary_key, 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }

        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = "P-" . $kodemax;
        return $kodejadi;
    }

    // ambil data
    public function getData($id = false, $allData = true)
    {
        if ($id !== false) {
            return $this->db->get_where($this->table, [$this->primary_key => $id])->row_array();
        }

        if ($allData) {
            $this->db->order_by($this->primary_key, 'DESC');
            return $this->db->get($this->table)->result_array();
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
