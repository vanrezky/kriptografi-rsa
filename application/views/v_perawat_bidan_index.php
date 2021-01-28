<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->session->flashdata('message'); ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="float-left">
                            <a href="<?= base_url('perawat-bidan/data'); ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah data</a>
                            <a href="<?= base_url('cetak_pdf/perawat_bidan'); ?>" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-file-alt"></i> Print</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIP</th>
                                    <th>Pekerjaan</th>
                                    <th>Nomor Handphone</th>
                                    <th>Foto</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (empty($data)) {
                                    echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan!</td></tr>";
                                } else {
                                    $no = 1;
                                    foreach ($data as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>$no</td>";
                                        echo "<td>$value[nama]</td>";
                                        echo "<td>$value[nip]</td>";
                                        echo "<td>" . ucfirst($value['pekerjaan']) . "</td>";
                                        echo "<td>$value[no_hp]</td>";
                                        echo "<td class='text-center'><img class='rounded img-thumbnail profil' src='" . base_url('public/uploads/img/' . $value['foto']) . "'></td>";
                                        echo "<td>";
                                        echo "<a href='" . base_url('perawat-bidan/data/' . encode($value['id'])) . "' class='btn btn-info btn-sm mr-2'><i class='fas fa-pencil-alt'></i> Perbarui</a>";
                                        echo "<a href='" . base_url('perawat-bidan/hapus/' . encode($value['id'])) . "' class='btn btn-danger btn-sm btnDelete'><i class='fas fa-trash-alt' ></i> Hapus</a>";

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