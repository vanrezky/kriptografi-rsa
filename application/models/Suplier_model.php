<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Suplier_model extends CI_Model
{
    function get_suplier_info($number, $offset, $search = "")
    {
        $this->db->like('nama_suplier', $search, 'both');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('tb_suplier', $number, $offset)->result_array();
    }


    public function save_suplier_info($data) // save data ke database tb_suplier
    {
        return $this->db->insert('tb_suplier', $data);
    }

    public function save_transaksi_info($data) // save data ke database tb_transaksi
    {
        return $this->db->insert('tb_transaksi', $data);
    }

    public function get_date_suplier() //get tanggal input suplier
    {
        $this->db->select('*');
        $this->db->from('tb_suplier');
        $this->db->group_by('YEAR(tb_suplier.date_created)');
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

    public function get_single_suplier($id) // ambil data suplier berdasarkan id
    {

        $this->db->select('*');
        $this->db->from('tb_suplier');
        // $this->db->join('tb_satuan', 'tb_suplier.satuan_id=tb_satuan.satuan_id', 'inner');
        $this->db->where('tb_suplier.id', $id);
        $info = $this->db->get();
        return $info->row_array();
    }



    public function update_suplier_info($data, $param) // update suplier
    {
        $this->db->where('id', $param);
        return $this->db->update('tb_suplier', $data);
    }

    public function update_stock_info($datasuplier, $suplier_id) // update Stock
    {
        $this->db->where('id', $suplier_id);
        return $this->db->update('tb_suplier', $datasuplier);
    }

    public function delete_suplier_info($id) // delate suplier
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_suplier');
    }
}
