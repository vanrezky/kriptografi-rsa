<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>
        <?= $this->session->flashdata('message') ?>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row mt-2 mb-2 ml-2">
                                <?= str_replace('col-sm-12', 'col-md-3', stislaFromDropdownOnly('proyek', $proyek, 'id', 'nama_proyek', $this->input->cookie('fproyek'))); ?>
                                <?= str_replace('col-sm-12', 'col-md-3', stislaFromDropdownOnly('bulan', nama_bulan(), 'val', 'label', $this->input->cookie('fbulan'))); ?>
                                <?= str_replace('col-sm-12', 'col-md-3', stislaFromDropdownOnly('tahun', tahun_sekarang(), 'val', 'val', $this->input->cookie('ftahun'))); ?>
                                <div class=col-md-3>
                                    <?= stislaButtonMedium("<i class='fa fa-search'></i>", "primary", "bCari"); ?>
                                    <?= stislaButtonMedium("<i class='fas fa-file-excel'></i> Excel", "warning", "Cetak target='_blank'", base_url('laporan/transaksi?cetak=data')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-square"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Pemasukan</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= !empty($info['pemasukan']) ? ifUang($info['pemasukan']) : '-' ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Pengeluaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= !empty($info['pengeluaran']) ? ifUang($info['pengeluaran']) : '-' ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="fas fa-car"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Anggaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= !empty($info['anggaran_proyek']) ? ifUang($info['anggaran_proyek']) : '-' ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Laba</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= isset($info['anggaran_proyek'], $info['pengeluaran']) ? ifUang($info['anggaran_proyek'] - $info['pengeluaran']) : (isset($info['anggaran_proyek']) ? ifUang($info['anggaran_proyek']) : '-') ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Pemasukan</h4>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fas fa-th"></i></th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Metode Bayar</th>
                                            <th>Bukti Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        if (empty($pemasukan)) {
                                            echo "<tr><td class='text-center' colspan='10'>Data tidak ditemukan!</td></tr>";
                                        } else {

                                            foreach ($pemasukan as $value) { ?>
                                                <tr>
                                                    <td align="center"><?= $no++; ?></td>
                                                    <td><?= format_hari_tanggal($value['tanggal']) ?></td>
                                                    <td>Rp <?= ifUang($value['jumlah']) ?></td>
                                                    <td><?= strtoupper($value['jenis_bayar']) ?></td>
                                                    <td align="center">
                                                        <?php
                                                        if (!empty($value['bukti_bayar'])) {
                                                            echo "<a class='btn btn-icon btn-sm btn-primary' target='_blank' href='" . base_url('uploads/bukti/' . $value['bukti_bayar']) . "'><i class='fas fa-file-pdf'></i></a>";
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>

                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tabel Pengeluaran</h4>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fas fa-th"></i></th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Metode Bayar</th>
                                            <th>Bukti Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        if (empty($pengeluaran)) {
                                            echo "<tr><td class='text-center' colspan='10'>Data tidak ditemukan!</td></tr>";
                                        } else {

                                            foreach ($pengeluaran as $val) { ?>
                                                <tr>
                                                    <td align="center"><?= $no++; ?></td>
                                                    <td><?= format_hari_tanggal($val['date_created']) ?></td>
                                                    <td>Rp <?= ifUang($val['total']) ?></td>
                                                    <td><?= strtoupper($val['jenis_pembayaran']) ?></td>
                                                    <td align="center">
                                                        <?php
                                                        if (!empty($val['bukti_bayar'])) {
                                                            echo "<a class='btn btn-icon btn-sm btn-primary' target='_blank' href='" . base_url('uploads/bukti/' . $val['bukti_bayar']) . "'><i class='fas fa-file-pdf'></i></a>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<style>
    .card-icon {
        width: 40px !important;
    }
</style>
<script>
    $(document).ready(function() {

        $('[bCari]').click(function() {
            var proyek = $('[name="fproyek"]').val();
            var bulan = $('[name="fbulan"]').val();
            var tahun = $('[name="ftahun"]').val();

            if (proyek == '') {
                alert('silahkan pilih proyek terlebih dahulu!');
                return false;
            }
            if (bulan == '' || bulan == ' ') {
                alert('silahkan pilih bulan terlebih dahulu!');
                return false;
            }
            if (tahun == '') {
                alert('silahkan pilih tahun terlebih dahulu!');
                return false;
            }
            setFilter();

            document.location.href = '<?= base_url('laporan/transaksi') ?>';
            return false;
        });
        $('[name="proyek"]').change(function() {
            $('[name=""]')
            setCookies('fproyek', $(this).val());
            setCookies('fbulan', '');
            setCookies('ftahun', '');
            document.location.href = '<?= base_url('laporan/transaksi') ?>';
        })

    });

    function setFilter() {
        setCookies('fproyek', $('[name="proyek"]').val());
        setCookies('fbulan', $('[name="bulan"]').val());
        setCookies('ftahun', $('[name="tahun"]').val());
    };
</script>