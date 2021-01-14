<?php
defined('BASEPATH') or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class laporan extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('laporan_model', 'laporan');
        is_logged_in();
    }

    public function transaksi()
    {
        $proyek = $this->input->cookie('fproyek');
        $bulan = $this->input->cookie('fbulan');
        $tahun = $this->input->cookie('ftahun');

        $cetak = $this->input->get('cetak', true);
        $pengeluaran = [];

        if ($cetak == 'data') {
            $pengeluaran = $this->laporan->get_all_transaksi($proyek);
            $data_proyek = $this->db->get_where('tb_proyek', ['id' => $proyek])->row_array();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->mergeCells('F2:H2');
            $sheet->setCellValue("F2", "LAPORAN PENGELUARAN PROYEK : " . strtoupper($data_proyek['nama_proyek']));
            $sheet->mergeCells('K2:M2');
            $sheet->setCellValue("K2", "CV. HONGGONILO HADIGUNA WISESA");

            $sheet->getStyle('E4:M4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ff6347');
            $sheet->setCellValue('E4', 'No');
            $sheet->setCellValue('F4', 'Tanggal');
            $sheet->setCellValue('G4', 'Nama Barang');
            $sheet->setCellValue('H4', 'Satuan');
            $sheet->setCellValue('I4', 'Harga/Unit');
            $sheet->setCellValue('J4', 'Jumlah');
            $sheet->setCellValue('K4', 'Total');
            $sheet->setCellValue('L4', 'Suplier');
            $sheet->setCellValue('M4', 'Pembayaran');

            $no = 1;
            $x = 5;
            $grandtotal = 0;
            foreach ($pengeluaran as $row) {
                $total = $row['harga'] * $row['jumlah'];
                $grandtotal += $total;
                $sheet->setCellValue('E' . $x, $no++);
                $sheet->setCellValue('F' . $x, str_replace('-', '/', $row['date_created']));
                $sheet->setCellValue('G' . $x, ucfirst($row['nama_item']));
                $sheet->setCellValue('H' . $x, ucfirst($row['satuan']));
                $sheet->setCellValue('I' . $x, 'Rp ' . ifUang($row['harga']));
                $sheet->setCellValue('J' . $x, ifUang($row['jumlah']));
                $sheet->setCellValue('K' . $x, 'Rp ' . ifUang($total));
                $sheet->setCellValue('L' . $x, ucfirst($row['suplier']));
                $sheet->setCellValue('M' . $x, strtoupper($row['jenis_pembayaran']));
                $x++;
            }
            foreach (range('E', 'M') as $columnID) {
                $sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            $sheet->mergeCells('E' . $x . ':J' . $x);
            $sheet->getStyle('E', $x)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffff00');
            $sheet->setCellValue("E$x", "SUB TOTAL PENGELUARAN PROYEK");
            $sheet->mergeCells('K' . $x . ':M' . $x);
            $sheet->getStyle('K', $x)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('0000ff');
            $sheet->setCellValue("K$x", 'Rp ' . ifUang($grandtotal));


            $writer = new Xlsx($spreadsheet);
            $filename = 'laporan-transaksi';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {

            $pemasukan = [];
            $info = [];

            if (!empty($proyek) && !empty($bulan) && !empty($tahun)) {
                $info = $this->laporan->get_info($proyek, $bulan, $tahun);
                $pemasukan = $this->laporan->get_pemasukan($proyek, $bulan, $tahun);
                $pengeluaran = $this->laporan->get_pengeluaran($proyek, $bulan, $tahun);
            } else if (!empty($proyek)) {
                $info = $this->laporan->get_info_all($proyek);
            }


            $data = [
                'title' => 'Laporan', //judul halaman
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'info' => $info,
                'proyek' => $this->laporan->proyek()
            ];

            $this->render('laporan/laporan_transaksi', $data);
        }
    }
}
