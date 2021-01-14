<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?> <?= $alat['kode_alat'] ?></h1>
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
                        <form method="post" action="<?= base_url('alat/update/' . encode($alat['id'])); ?>">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-8">
                                            <label for="">Kode alat</label>
                                            <input type="text" required class="form-control" name="kode_alat" value="<?= $alat['kode_alat'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="">Nama alat</label>
                                            <input type="text" required class="form-control" name="nama_alat" value="<?= $alat['nama_alat'] ?>" placeholder="Nama alat..">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="<?= base_url('alat') ?>">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>