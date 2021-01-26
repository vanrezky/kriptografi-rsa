<div class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <?= $this->session->flashdata('message') ?>
                <?php if (!empty($error)) {
                    echo alert($error, 'danger');
                } ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="float-right">
                            <a href="<?= base_url('dokter'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <form role="form" method="POST" action="<?= base_url('dokter/data/' . (isset($data['id']) ? encode($data['id']) : '')); ?>" enctype="multipart/form-data">
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip">Nomor Induk Pegawai</label>
                                    <input type="text" name="nip" class="form-control" id="nip" placeholder="Nomor Induk Pegawai" <?= isset($data['nip']) ? "value='$data[nip]'" : '' ?>>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama_dokter" class="form-control" id="nama" placeholder="Nama Lengkap" <?= isset($data['nama_dokter']) ? "value='$data[nama_dokter]'" : '' ?>>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">Nomor Handphone</label>
                                    <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="0822****f" <?= isset($data['no_hp']) ? "value='$data[no_hp]'" : '' ?>>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto Profil</label>
                                    <input type="file" name="foto" class="form-control" id="foto" placeholder="Ulangi password">
                                </div>
                            </div>
                            <div class="mx-auto col-md-6">
                                <?php
                                if (isset($data['foto'])) {
                                    echo "<img class='rounded profil-data' src='" . base_url('public/uploads/img/' . $data['foto']) . "'>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <button type="reset" class="btn btn-warning"><i class="fas fa-sync"></i> Reset</button>
                            <a href="<?= base_url('dokter'); ?>" class="btn btn-danger"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>