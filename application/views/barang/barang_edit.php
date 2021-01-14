<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?> <?= $barang['kode_barang'] ?></h1>
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
                        <form method="post" action="<?= base_url('barang/update/' . encode($barang['id'])); ?>">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-8">
                                            <label for="">Kode Barang</label>
                                            <input type="text" required class="form-control" name="kode_barang" value="<?= $barang['kode_barang'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="">Nama Barang</label>
                                            <input type="text" required class="form-control" name="nama_barang" value="<?= $barang['nama_barang'] ?>" placeholder="Nama Barang..">
                                        </div>
                                    </div>
                                    <label for="">Keterangan</label>
                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="keterangan" value="<?= $barang['keterangan'] ?>" placeholder="Keterangan..">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="<?= base_url('barang') ?>">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>