<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>
        <?= $this->session->flashdata('message') ?>
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors() ?>
            </div>
        <?php } ?>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card-body p-0">
                        <form method="post" action="<?= base_url('pemasukan/update/' . encode($pemasukan['id'])); ?>" enctype="multipart/form-data">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="">Tanggal</label>
                                            <input type="date" required class="form-control" name="tanggal" value="<?= $pemasukan['tanggal'] ?>">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Jumlah</label>
                                            <input type="number" required class="form-control" name="jumlah" value="<?= $pemasukan['jumlah'] ?>">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Proyek</label>
                                            <select class="form-control" name="proyek" required>
                                                <?php
                                                foreach ($proyek as $key => $value) {
                                                    $s = $pemasukan['proyek'] == $value['id'] ? 'selected' : '';
                                                    echo "<option $s value='$value[id]'>$value[nama_proyek]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Jenis Bayar</label>
                                            <select class="form-control" name="jenis_bayar" required>
                                                <option <?= $pemasukan['jenis_bayar'] == 'cash' ? 'selected' : ''; ?> value="cash">Cash</option>
                                                <option <?= $pemasukan['jenis_bayar'] == 'transfer' ? 'selected' : ''; ?> value="transfer">Transfer</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label for="">Dokumen</label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="bukti">
                                                <div class="input-group-append">
                                                    <?php
                                                    if (!empty($pemasukan['bukti_bayar'])) {
                                                        echo "<a href='" . base_url('uploads/bukti/' . $pemasukan['bukti_bayar']) . "' target='_blank' class='btn btn-info'><i class='fas fa-eye'></i> Bukti</a>";
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="<?= base_url('pemasukan') ?>">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>