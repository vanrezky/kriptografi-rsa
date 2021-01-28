    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?php if (!empty($data)) { ?>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Info!</h5>
                        <?= $count; ?> Data ditemukan!
                    </div>
                <?php }; ?>
                <div class="card card-warning card-outline">
                    <form method="POST" action="<?= base_url('laporan'); ?>">
                        <div class="card-body row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="tgl-awal" class="col-sm-2 col-form-label">Awal</label>
                                    <div class="col-sm-10">
                                        <input type="date" id="tgl-awal" class="form-control" name="tgl_awal" value="<?= !empty($tgl['awal']) ? $tgl['awal'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="tgl-akhir" class="col-sm-2 col-form-label">Akhir</label>
                                    <div class="col-sm-10">
                                        <input type="date" id="tgl-akhir" class="form-control" name="tgl_akhir" value="<?= !empty($tgl['akhir']) ? $tgl['akhir'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> Cari</button>
                                <a href="<?= base_url('laporan'); ?>" class="btn btn-warning">Reset</a>
                                <?php
                                $tgl_cetak = "";
                                if (!empty($tgl['awal']) && !empty($tgl['akhir'])) $tgl_cetak = "/$tgl[awal]/$tgl[akhir]"; ?>
                                <a href="<?= base_url('cetak_pdf/laporan' . $tgl_cetak); ?>" target="_blank" class="btn btn-primary bCetak">Cetak</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No.</th>
                                    <th>Identitas Pasien</th>
                                    <th>Tanggal Berobat</th>
                                    <th>Gejala</th>
                                    <th>Obat</th>
                                    <th>Dokter/Perawat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($data)) {
                                    echo "<tr><td colspan='8' class='text-center'>Data tidak ditemukan!</td></tr>";
                                } else {
                                    $no = 1;
                                    foreach ($data as $key => $value) {
                                        echo "<tr >";
                                        echo "<td class='text-center'>$no</td>";
                                        echo "<td>" . ucwords($value['nama_pasien']) . "<br/>
                                            <small><i>Kode Pasien : $value[kode_pasien], TB: $value[tb], BB: $value[bb], TD: $value[td]/120</i></small>
                                        </td>";
                                        echo "<td class='text-center'>" . format_hari_tanggal($value['tgl_berobat']) . "</td>";
                                        echo "<td class='text-center'>" . decode_rsa($value['gejala'], $rsa_key['d'], $rsa_key['n']) . "</td>";
                                        echo "<td class='text-center'>" . decode_rsa($value['obat'], $rsa_key['d'], $rsa_key['n']) . "</td>";
                                        echo "<td>Dokter: " . (!empty($value['id_dokter']) ? ucfirst($value['nama_dokter']) : '-') . "<br/>
                                                  Perawat/Bidan:" .  (!empty($value['id_pb']) ? ucfirst($value['nama']) : '-') . "
                                            </td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.bCetak').click(function(e) {
                e.preventDefault();

                var url = $(this).attr('href'),
                    tgl_awal = $('[name="tgl_awal"]').val(),
                    tgl_akhir = $('[name="tgl_akhir"]').val();
                if (tgl_awal == '' && tgl_akhir == '') {
                    alert('Silahkan pilih tanggal awal dan tanggal akhir terlebih dahulu!');
                    return false;
                }
                window.open(url, '_blank');

            })
        });
    </script>