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
                    <div class="card">
                        <div class="card-header">
                            <div class="form-inline mr-auto">
                                <div class="search-element">
                                    <?= stislaInputTextOnly('Nama proyek..', 'nama_proyek', $this->input->cookie('fnama_proyek')); ?>
                                    <?= stislaButtonMedium("<i class='fa fa-search'></i>", "primary", "bCari"); ?>
                                </div>
                            </div>
                            <?php
                            echo "<div class='card-header-action'>";
                            echo "<div class='input-group'>";
                            echo "<button class='btn btn-success' data-toggle='modal' data-target='#addModal'><i class='fas fa-plus'></i> Add</button>";
                            echo "</div>";
                            ?>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center"><i class="fas fa-th"></i></th>
                                        <th>Nama proyek</th>
                                        <th>Anggaran</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Pemilik</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = $this->uri->segment('3') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td class='text-center' colspan='10'>Data tidak ditemukan!</td></tr>";
                                    } else {

                                        foreach ($data as $proyek) { ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td><?= "$proyek[nama_proyek]" ?></td>
                                                <td><?= ifUang($proyek['anggaran_proyek']) ?></td>
                                                <td><?= format_hari_tanggal($proyek['tanggal_mulai']) ?></td>
                                                <td><?= format_hari_tanggal($proyek['tanggal_selesai']) ?></td>
                                                <td><?= '<b>' . $proyek['pemilik'] . '</b><br/>' . $proyek['alamat_proyek'] ?></td>
                                                <td>
                                                    <a class="btn btn-icon btn-sm btn-success" target="_blank" href="<?= base_url('uploads/dokumen/' . $proyek['dokumen']); ?>"><i class="fas fa-file-pdf"></i> Docs</a>
                                                    <a class="btn btn-icon btn-sm btn-info" href="<?= base_url('proyek/update/' . encode($proyek['id'])); ?>"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="<?= base_url('proyek/delete/' . encode($proyek['id'])); ?>" class="btn btn-icon btn-sm btn-danger" onClick="return confirm('Yakin menghapus proyek?');" title="delete"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer float-right">
                        <span>Total Data : <?= $jumlah_data; ?></span>
                        <div class="float-right mr-3">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add proyek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('proyek'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Proyek</label>
                        <input type="text" class="form-control" name="nama_proyek" value="<?= set_value('nama_proyek') ?>" placeholder="Nama proyek..">
                    </div>
                    <div class="form-group">
                        <label>Alamat Proyek</label>
                        <textarea type="text" class="form-control" rows="3" name="alamat_proyek" value="<?= set_value('alamat_proyek') ?>" placeholder="Alamat Proyek.."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Anggaran Proyek</label>
                        <input type="number" class="form-control" name="anggaran_proyek" value="<?= set_value('anggaran_proyek') ?>" placeholder="Anggaran Proyek..">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tanggal_mulai" value="<?= set_value('tanggal_mulai') ?>">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" name="tanggal_selesai" value="<?= set_value('tanggal_selesai') ?>">
                    </div>
                    <div class="form-group">
                        <label>Pemilik</label>
                        <input type="text" class="form-control" name="pemilik" value="<?= set_value('pemilik') ?>" placeholder="Pemilik..">
                    </div>
                    <div class="form-group">
                        <label>Dokumen Rancangan</label>
                        <input type="file" class="form-control" name="dokumen">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('[bCari]').click(function() {
            setFilter();
            document.location.href = '<?= base_url('proyek/index') ?>';
            return false;
        });

        function setFilter() {
            setCookies('fnama_proyek', $('[name="nama_proyek"]').val());
        };
    });
</script>