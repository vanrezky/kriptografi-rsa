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
                        <form method="post" action="<?= base_url('proyek/update/' . encode($proyek['id'])); ?>" enctype="multipart/form-data">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="">Nama proyek</label>
                                            <input type="text" required class="form-control" name="nama_proyek" value="<?= $proyek['nama_proyek'] ?>" placeholder="Nama proyek..">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Alamat Proyek</label>
                                            <input type="text" required class="form-control" name="alamat_proyek" value="<?= $proyek['alamat_proyek'] ?>" placeholder="Alamat proyek..">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Anggaran proyek</label>
                                            <input type="number" required class="form-control" name="anggaran_proyek" value="<?= $proyek['anggaran_proyek'] ?>" placeholder="Anggaran proyek..">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Tanggal Mulai</label>
                                            <input type="date" required class="form-control" name="tanggal_mulai" value="<?= $proyek['tanggal_mulai'] ?>">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Tanggal Selesai</label>
                                            <input type="date" required class="form-control" name="tanggal_selesai" value="<?= $proyek['tanggal_selesai'] ?>">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Pemilik</label>
                                            <input type="text" required class="form-control" name="pemilik" value="<?= $proyek['pemilik'] ?>" placeholder="Pemilik..">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="">Dokumen</label>
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="dokumen" value="<?= $proyek['dokumen'] ?>">
                                                <div class="input-group-append">
                                                    <a href="<?= base_url('uploads/dokumen/' . $proyek['dokumen']) ?>" target="_blank" class="btn btn-info"><i class="fas fa-eye"></i> Dokumen</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="<?= base_url('proyek') ?>">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>