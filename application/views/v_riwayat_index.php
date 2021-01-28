<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="float-left">
                            <a href="<?= base_url('riwayat/data'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah data</a>
                            <a href="<?= base_url('cetak_pdf/riwayat'); ?>" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-file-alt"></i> Print</a>
                        </div>
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
                                    <th>Aksi</th>
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
                                        echo "<td>";
                                        echo "<a href='" . base_url('riwayat/data/' . encode($value['id'])) . "' class='btn btn-info btn-sm mr-2' title='Perbaharui'><i class='fas fa-pencil-alt'></i></a>";
                                        echo "<a href='" . base_url('riwayat/hapus/' . encode($value['id'])) . "' class='btn btn-danger btn-sm btnDelete' title='hapus'><i class='fas fa-trash-alt' ></i></a>";

                                        echo "</td>";
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
</div>
<script>
    $(document).ready(function() {
        $('.btnDelete').click(function(event) {
            event.preventDefault();
            var result = confirm("Yakin hapus data ?");
            var href = $(this).attr('href');
            if (result) {
                window.location.href = href;
            }
            return false;

        });
    });
</script>