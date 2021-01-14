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
                        <form method="post" action="<?= base_url('transportasi/update/' . encode($transportasi['id'])); ?>">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="">Nama transportasi</label>
                                            <input type="text" required class="form-control" name="nama_kendaraan" value="<?= $transportasi['nama_kendaraan'] ?>" placeholder="Nama transportasi..">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label>Jenis Kendaraan</label>
                                            <select name="jenis_kendaraan" class="form-control">
                                                <?php
                                                foreach (jenis_kendaraan() as $value) {

                                                    $s = ($transportasi['jenis_kendaraan'] == $value['val'] ? 'selected' : '');

                                                    echo "<option $s value='$value[val]'>$value[val]</option>";
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="<?= base_url('transportasi') ?>">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>