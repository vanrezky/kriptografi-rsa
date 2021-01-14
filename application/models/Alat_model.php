<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Alat_model extends CI_Model
{
    function get_alat_info($number, $offset, $search = "")
    {
        // $this->db->join('tb_satuan', 'tb_alat.satuan_id=tb_satuan.satuan_id', 'left')
        $this->db->like('nama_alat', $search, 'both');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tb_alat', $number, $offset)->result_array();
    }

    public function set_kode_alat() // buat kode alat secara otomatis
    {
        $this->db->select('RIGHT(tb_alat.kode_alat,4) as kode', FALSE);
        $this->db->order_by('kode_alat', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_alat');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }

        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = "ALT" . $kodemax;
        return $kodejadi;
    }

    public function save_alat_info($data) // save data ke database tb_alat
    {
        return $this->db->insert('tb_alat', $data);
    }

    public function save_transaksi_info($data) // save data ke database tb_transaksi
    {
        return $this->db->insert('tb_transaksi', $data);
    }

    public function get_date_alat() //get tanggal input alat
    {
        $this->db->select('*');
        $this->db->from('tb_alat');
        $this->db->group_by('YEAR(tb_alat.date_created)');
        $info = $this->db->get();
        return $info->result_array();
    }

    public function get_all_satuan() //ambil data dari tabel satuan
    {

        $this->db->select('*');
        $this->db->from('tb_satuan');
        $info = $this->db->get();
        return $info->result_array();
    }

    public function get_single_alat($id) // ambil data alat berdasarkan id
    {

        $this->db->select('*');
        $this->db->from('tb_alat');
        // $this->db->join('tb_satuan', 'tb_alat.satuan_id=tb_satuan.satuan_id', 'inner');
        $this->db->where('tb_alat.id', $id);
        $info = $this->db->get();
        return $info->row_array();
    }



    public function update_alat_info($data, $param) // update alat
    {
        $this->db->where('id', $param);
        return $this->db->update('tb_alat', $data);
    }

    public function update_stock_info($dataalat, $alat_id) // update Stock
    {
        $this->db->where('id', $alat_id);
        return $this->db->update('tb_alat', $dataalat);
    }

    public function delete_alat_info($id) // delate alat
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_alat');
    }
}
