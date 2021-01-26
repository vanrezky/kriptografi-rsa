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
                            <a href="<?= base_url('pasien'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <form role="form" method="POST" action="<?= base_url('pasien/data/' . (isset($data['id']) ? encode($data['id']) : '')); ?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <?php
                            if (isset($data['kode_pasien'])) {
                                echo '<div class="col-md-4">
                                <div class="form-group">
                                    <label for="kode_pasien">Kode Pasien</label>
                                    <div class="input-group">
                                        <input type="text" name="kode_pasien" class="form-control" id="kode_pasien" placeholder="Kode Pasien" value="' . $data['kode_pasien'] . '" readonly>
                                    </div>

                                    <i>Kosongkan jika ingin generate sistem</i>
                                </div>
                            </div>';
                            }; ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nik">Nomor Induk Kependudukan</label>
                                    <input type="text" name="nik" class="form-control" id="nik" placeholder="Nomor Induk Kependudukan" <?= isset($data['nik']) ? "value='$data[nik]'" : '' ?>>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama_pasien" class="form-control" id="nama" placeholder="Nama Lengkap" <?= isset($data['nama_pasien']) ? "value='$data[nama_pasien]'" : '' ?>>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kategori">kategori</label>
                                        <select class="custom-select" name="kategori" id="kategori">
                                            <?php
                                            $data_kategori = isset($data['kategori']) ? strtolower($data['kategori']) : '';
                                            echo "<option value=''>Pilih</option>";
                                            foreach ($kategori as $key => $value) {
                                                $s = $value == $data_kategori ? 'selected' : '';
                                                echo "<option value='$value' $s>" . ucfirst($value) . "</option>";
                                            }; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jenis-kelamin">Jenis Kelamin</label>
                                        <select class="custom-select" name="jenis_kelamin" id="jenis-kelamin">
                                            <?php
                                            $data_jenis_kelamin = isset($data['jenis_kelamin']) ? strtolower($data['jenis_kelamin']) : '';
                                            echo "<option value=''>Pilih</option>";
                                            foreach ($jenis_kelamin as $key => $value) {
                                                $s = $value == $data_jenis_kelamin ? 'selected' : '';
                                                echo "<option value='$value' $s>" . ucfirst($value) . "</option>";
                                            }; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="umur">Umur</label>
                                        <input type="text" name="umur" class="form-control" id="umur" placeholder="Umur" <?= isset($data['umur']) ? "value='$data[umur]'" : '' ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_hp">Nomor Handphone</label>
                                    <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="0822****" <?= isset($data['no_hp']) ? "value='$data[no_hp]'" : '' ?>>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat lengkap" rows="5"><?= isset($data['alamat']) ? "$data[alamat]" : '' ?></textarea>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <button type="reset" class="btn btn-warning"><i class="fas fa-sync"></i> Reset</button>
                            <a href="<?= base_url('pasien'); ?>" class="btn btn-danger"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>