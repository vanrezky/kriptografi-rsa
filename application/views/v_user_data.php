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
                            <a href="<?= base_url('user'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <form role="form" method="POST" action="<?= base_url('user/data/' . (isset($data['id']) ? encode($data['id']) : '')); ?>" enctype="multipart/form-data">
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" <?= isset($data['nama']) ? "value='$data[nama]'" : '' ?>>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" <?= isset($data['username']) ? "value='$data[username]' readonly" : '' ?>>
                                </div>
                                <?php if (!isset($data['password'])) { ?>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="pass1" class="form-control" id="password" placeholder="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassowrd">Konfirmasi Password</label>
                                        <input type="password" name="pass2" class="form-control" id="confirmPassowrd" placeholder="Ulangi password">
                                    </div>
                                <?php }; ?>
                                <div class="form-group">
                                    <label for="level">Level User</label>
                                    <select class="custom-select" name="level" id="level">
                                        <?php
                                        echo "<option value=''>Pilih</option>";
                                        foreach (getLevel() as $key => $value) {
                                            $level = isset($data['level']) ? $data['level'] : '';
                                            $s = $level == $value ? 'selected' : '';
                                            echo "<option value='$value' $s>" . ucfirst($value) . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto Profil</label>
                                    <input type="file" name="foto" class="form-control" id="foto" placeholder="Ulangi password">
                                </div>
                                <?php if (isset($data['password'])) { ?>
                                    <hr class="mt-5" />

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="pass1" class="form-control" id="password" placeholder="password">
                                        <i>Kosongkan jika tidak ingin mengganti password</i>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassowrd">Konfirmasi Password</label>
                                        <input type="password" name="pass2" class="form-control" id="confirmPassowrd" placeholder="Ulangi password">
                                        <i>Kosongkan jika tidak ingin mengganti password</i>
                                    </div>

                                <?php }; ?>
                            </div>
                            <div class="mx-auto col-md-6">
                                <?php
                                if (isset($data['foto'])) {
                                    echo "<img class='profil-data' src='" . base_url('public/uploads/img/' . $data['foto']) . "'>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <button type="reset" class="btn btn-warning"><i class="fas fa-sync"></i> Reset</button>
                            <a href="<?= base_url('user'); ?>" class="btn btn-danger"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>