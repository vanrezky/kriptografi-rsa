<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>

        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <div class="input-group">
                                    <a class="btn btn-secondary" href="<?= base_url('transaksi') ?>"> Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">No Transaksi/Faktur</label>
                                        <input type="text" class="form-control" value="<?= $trans['no_trans'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-6">
                                        <label for="">Proyek</label>
                                        <input type="text" class="form-control" value="<?= ucfirst($trans['nama_proyek']) ?>" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label for="">Suplier</label>
                                        <input type="text" class="form-control" value="<?= ucfirst($trans['nama_suplier']) ?>" readonly>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-5">
                                        <label for="">Jenis Pembayaran</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" value="<?= ucfirst($trans['jenis_pembayaran']) ?>" readonly>
                                            <?php if (!empty($trans['bukti_bayar'])) {
                                                echo ' <div class="input-group-append">
                                                            <a href="' . base_url('uploads/bukti/' . $trans['bukti_bayar']) . '" target="_blank" class="btn btn-primary" type="button">Bukti Transfer</a>
                                                        </div>';
                                            } ?>

                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-7">
                                        <label for="">Total</label>
                                        <input type="text" class="form-control" value="Rp <?= ifUang($trans['total']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>
                                            <i class="fas fa-shopping-cart"></i> List Pembelian
                                        </h4>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="sortable-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            <i class="fas fa-th"></i>
                                                        </th>
                                                        <th>Nama</th>
                                                        <th>Harga</th>
                                                        <th>Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Total Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($sub_trans as $key => $value) {
                                                        $jenis = $value['jenis'] == 'transportasi' ? 'kendaraan' : $value['jenis'];
                                                        $nama = $value['nama_' . $jenis];
                                                        echo "<tr>";
                                                        echo  "<td class='text-center'>$no</td>";
                                                        echo  "<td>$nama</td>";
                                                        echo  "<td>Rp " . ifUang($value['harga']) . "</td>";
                                                        echo  "<td>$value[satuan]</td>";
                                                        echo  "<td>$value[jumlah]</td>";
                                                        echo  "<td>Rp " . ifUang($value['harga'] * $value['jumlah']) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-right" colspan="4">Grand Total</td>
                                                        <td id="grand-total" colspan="">Rp <?= ifUang($trans['total']) ?></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>