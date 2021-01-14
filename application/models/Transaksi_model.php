<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Transaksi_model extends CI_Model
{


    public function get_all_barang()
    {
        return $this->db->get('tb_barang')->result_array();
    }

    public function get_all_alat()
    {
        return $this->db->get('tb_alat')->result_array();
    }
    public function get_all_transportasi()
    {
        return $this->db->get('tb_transportasi')->result_array();
    }
    public function get_all_satuan()
    {
        return $this->db->get('tb_satuan')->result_array();
    }

    public function get_item($tb, $param)
    {
        $this->db->select('*');
        $this->db->where('id', $param);
        $query = $this->db->get($tb);
        return $query->row_array();
    }

    public function get_all_suplier()
    {
        return $this->db->get('tb_suplier')->result_array();
    }
    public function get_all_proyek()
    {
        return $this->db->get('tb_proyek')->result_array();
    }


    public function get_no_trans() // buat kode barang secara otomatis
    {

        $this->db->select('RIGHT(tb_transaksi.no_trans,4) as kode', FALSE);
        $this->db->order_by('no_trans', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_transaksi');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }

        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodejadi = "TRX" . $kodemax;
        return $kodejadi;
    }

    function search_blog($nama) //autocomplete transaksi barang
    {
        $this->db->select('*');
        $this->db->from('tb_barang');
        $this->db->like('nama_barang', $nama, 'both');
        $this->db->order_by('nama_barang', 'ASC');
        $this->db->limit(10);
        $info = $this->db->get();
        return $info->result();
    }

    public function getNamaDanKode($nm) // ambil nama dan kode barang
    {
        $this->db->select('kode_barang, nama_barang');
        $this->db->from('tb_barang');
        $this->db->like('nama_barang', $nm);
        // $this->db->like('hide', 'x');
        $this->db->or_like('kode_barang', $nm);
        // $this->db->like('hide', 'x');
        $this->db->limit(10);
        return $this->db->get();
    }

    public function get_all_transaksi($cari = "") //ambil data dari tabel transaksi
    {
        $this->db->select('TT.*, S.nama_suplier,(
					SELECT COUNT(SUB.`id`)
                    FROM tb_sub_transaksi SUB
                    WHERE SUB.`no_trans` = TT.no_trans
				)count');
        $this->db->join('tb_suplier S', 'TT.suplier=S.id', 'LEFT');
        if (!empty($cari)) {
            $this->db->group_start();
            $this->db->like('TT.no_trans', $cari);
            $this->db->or_like('TT.jenis_transaksi', $cari);
            $this->db->or_like('TT.jenis_pembayaran', $cari);
            $this->db->or_like('S.nama_suplier', $cari);
            $this->db->group_end();
        }
        $this->db->order_by('TT.no_trans', 'DESC');
        $info = $this->db->get('tb_transaksi TT');
        return $info->result_array();
    }

    public function get_transaksi() //ambil data dari tabel transaksi dan total penujualan
    {
        $this->db->select('SUM(total) as max_trans, date_created');
        $this->db->from('tb_transaksi');
        $this->db->group_by('date_created');
        $this->db->order_by('no_resi', 'asc');
        $info = $this->db->get();
        return $info->result_array();
    }

    public function getTransaksi() //ambil total dari tabel transaksi
    {
        $this->db->select('*');
        $this->db->from('tb_transaksi');
        $info = $this->db->get();
        return $info->result_array();
    }

    public function get_transaksi_id($no_trans) //ambil total dari tabel transaksi
    {
        $this->db->select('*');
        $this->db->from('tb_transaksi');
        $this->db->join('tb_suplier', 'tb_transaksi.suplier=tb_suplier.id', 'LEFT');
        $this->db->join('tb_proyek', 'tb_transaksi.proyek=tb_proyek.id', 'LEFT');
        $this->db->where('no_trans', $no_trans);
        $info = $this->db->get();
        return $info->row_array();
    }

    public function get_subtransaksi_id($no_trans, $jenis_transasksi) //ambil total dari tabel transaksi
    {
        $this->db->select('*, TST.id id_sub, TST.satuan id_satuan');
        $this->db->from('tb_sub_transaksi TST');
        $this->db->join('tb_satuan', 'TST.satuan=tb_satuan.satuan_id', 'LEFT');

        if ($jenis_transasksi == 'barang') {
            $this->db->join('tb_barang', 'TST.id_item=tb_barang.id', 'LEFT');
        } else if ($jenis_transasksi == 'alat') {
            $this->db->join('tb_alat', 'TST.id_item=tb_alat.id', 'LEFT');
        } else if ($jenis_transasksi == 'transportasi') {
            $this->db->join('tb_transportasi', 'TST.id_item=tb_transportasi.id', 'LEFT');
        }
        $this->db->where('no_trans', $no_trans);
        $info = $this->db->get();
        return $info->result_array();
    }

    public function get_single_barang($id) //ambil data dari tabel transaksi berdasarkan id
    {
        $this->db->select('*');
        $this->db->from('tb_barang');
        $this->db->join('tb_satuan', 'tb_barang.satuan_id=tb_satuan.satuan_id', 'LEFT');
        $this->db->where('id', $id);
        $info = $this->db->get();
        return $info->row_array();
    }

    public function save_transaksi_info($odata) // save data ke database tb_transaksi
    {
        return $this->db->insert('tb_transaksi', $odata);
    }

    public function save_sub_transaksi_info($odata) // save data ke database sub transaksi
    {
        return $this->db->insert('tb_sub_transaksi', $odata);
    }

    public function sisa_stock_info($barang_id, $sisa_stock) //simpan sisa stock
    {
        $this->db->where('id', $barang_id);
        return $this->db->update('tb_barang', $sisa_stock);
    }

    public function delete_transaksi_info($id) // delate transaksi
    {
        $this->db->where('no_trans', $id);
        return $this->db->delete('tb_transaksi');
    }
    public function delete_subtransaksi_info($id) // delate transaksi
    {
        $this->db->where('no_trans', $id);
        return $this->db->delete('tb_sub_transaksi');
    }
}
