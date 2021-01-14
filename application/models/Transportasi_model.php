<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Transportasi_model extends CI_Model
{
    function get_transportasi_info($number, $offset, $search = "")
    {
        // $this->db->join('tb_satuan', 'tb_transportasi.satuan_id=tb_satuan.satuan_id', 'left')
        $this->db->like('nama_kendaraan', $search, 'both');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tb_transportasi', $number, $offset)->result_array();
    }


    public function save_transportasi_info($data) // save data ke database tb_transportasi
    {
        return $this->db->insert('tb_transportasi', $data);
    }

    public function save_transaksi_info($data) // save data ke database tb_transaksi
    {
        return $this->db->insert('tb_transaksi', $data);
    }

    public function get_date_transportasi() //get tanggal input transportasi
    {
        $this->db->select('*');
        $this->db->from('tb_transportasi');
        $this->db->group_by('YEAR(tb_transportasi.date_created)');
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

    public function get_single_transportasi($id) // ambil data transportasi berdasarkan id
    {

        $this->db->select('*');
        $this->db->from('tb_transportasi');
        // $this->db->join('tb_satuan', 'tb_transportasi.satuan_id=tb_satuan.satuan_id', 'inner');
        $this->db->where('tb_transportasi.id', $id);
        $info = $this->db->get();
        return $info->row_array();
    }



    public function update_transportasi_info($data, $param) // update transportasi
    {
        $this->db->where('id', $param);
        return $this->db->update('tb_transportasi', $data);
    }

    public function update_stock_info($datatransportasi, $transportasi_id) // update Stock
    {
        $this->db->where('id', $transportasi_id);
        return $this->db->update('tb_transportasi', $datatransportasi);
    }

    public function delete_transportasi_info($id) // delate transportasi
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_transportasi');
    }
}
