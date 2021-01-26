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
                            <a href="<?= base_url('riwayat'); ?>" class="btn btn-danger btn-sm"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </div>
                    <form role="form" method="POST" action="<?= base_url('riwayat/data/' . (isset($data['id']) ? encode($data['id']) : '')); ?>" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="pasien">Pasien</label>
                                    <select class="form-control select2Bs" id="pasien" name="id_pasien" style="width: 100%;" placeholder="pilih">
                                        <?php
                                        echo "<option value=''>Pilih Pasien</option>";
                                        foreach ($pasien as $key => $value) {
                                            $s = '';
                                            echo "<option value='" . encode($value['id']) . "'>" . ucwords($value['nama_pasien']) . " - $value[kode_pasien]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_berobat">Tanggal Berobat</label>
                                    <input type="date" name="tgl_berobat" class="form-control" id="tgl_berobat" placeholder="" <?= isset($data['tgl_berobat']) ? "value='$data[tgl_berobat]'" : '' ?>>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="gejala">Gejala</label>
                                    <textarea class="form-control" id="gejala" name="gejala" placeholder="" rows="3"><?= isset($data['gejala']) ? decode_rsa($data['gejala'], $rsa_key['d'], $rsa_key['n']) : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tb">Tinggi Badan(cm)</label>
                                        <input type="text" name="tb" class="form-control" id="tb" <?= isset($data['tb']) ? "value='$data[tb]'" : '' ?>>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bb">Berat Badan(kg)</label>
                                        <input type="text" name="bb" class="form-control" id="bb" <?= isset($data['bb']) ? "value='$data[bb]'" : '' ?>>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="td">Tekanan Darah</label>
                                        <input type="text" name="td" class="form-control" id="td" <?= isset($data['td']) ? "value='$data[td]'" : '' ?>>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="kat_penyakit">Kategori Penyakit</label>
                                        <select class="custom-select" name="kat_penyakit" id="kat_penyakit">
                                            <?php
                                            $data_kat_penyakit = isset($data['kat_penyakit']) ? strtolower($data['kat_penyakit']) : '';
                                            echo "<option value=''>Pilih</option>";
                                            foreach ($kat_penyakit as $key => $value) {
                                                $s = $value['val'] == $data_kat_penyakit ? 'selected' : '';
                                                echo "<option value='$value[val]' $s>" . ucfirst($value['label']) . "</option>";
                                            }; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="obat">Obat</label>
                                    <textarea class="form-control" id="obat" name="obat" placeholder="" rows="3"><?= isset($data['obat']) ? decode_rsa($data['obat'], $rsa_key['d'], $rsa_key['n']) : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="dokter">Nama Dokter</label>
                                    <select class="form-control select2Bs" name="id_dokter" id="dokter" style="width: 100%;">
                                        <?php
                                        $data_dokter = isset($data['id_dokter']) ? strtolower($data['id_dokter']) : '';
                                        echo "<option value=''>Pilih</option>";
                                        foreach ($dokter as $key => $value) {
                                            $s = $value['id'] == $data_dokter ? 'selected' : '';
                                            echo "<option value='" . encode($value['id']) . "' $s>" . ucfirst($value['nama_dokter']) . "</option>";
                                        }; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="perawat_bidan">Nama Perawat/Bidan</label>
                                    <select class="form-control select2Bs" name="id_perawat_bidan" id="perawat_bidan" style="width: 100%;">
                                        <?php
                                        $data_perawat_bidan = isset($data['id_pb']) ? strtolower($data['id_pb']) : '';
                                        echo "<option value=''>Pilih</option>";
                                        foreach ($perawat_bidan as $key => $value) {
                                            $s = $value['id'] == $data_perawat_bidan ? 'selected' : '';
                                            echo "<option value='" . encode($value['id']) . "' $s>" . ucfirst($value['nama']) . "</option>";
                                        }; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            <button type="reset" class="btn btn-warning"><i class="fas fa-sync"></i> Reset</button>
                            <a href="<?= base_url('riwayat'); ?>" class="btn btn-danger"><i class="fas fa-angle-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>