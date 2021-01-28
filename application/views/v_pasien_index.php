<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="float-left">
                            <a href="<?= base_url('pasien/data'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah data</a>
                            <a href="<?= base_url('cetak_pdf/pasien'); ?>" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-file-alt"></i> Print</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No.</th>
                                    <th>Identitas Pasien</th>
                                    <th>Kode Pasien</th>
                                    <th>Kategori</th>
                                    <th>Umur</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor HP</th>
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
                                        echo "<td>$value[nama_pasien]<br/>
                                            <small><strong>NIK : $value[nik] | $value[alamat]</strong></small>
                                        </td>";
                                        echo "<td class='text-center'>$value[kode_pasien]</td>";
                                        echo "<td>$value[kategori]</td>";
                                        echo "<td class='text-center'>$value[umur] tahun</td>";
                                        echo "<td>$value[jenis_kelamin]</td>";
                                        echo "<td>$value[no_hp]</td>";
                                        echo "<td>";
                                        echo "<a href='" . base_url('pasien/data/' . encode($value['id'])) . "' class='btn btn-info btn-sm mr-2' title='Perbaharui'><i class='fas fa-pencil-alt'></i></a>";
                                        echo "<a href='" . base_url('pasien/hapus/' . encode($value['id'])) . "' class='btn btn-danger btn-sm btnDelete' title='hapus'><i class='fas fa-trash-alt' ></i></a>";

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