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
                                    <?= stislaInputTextOnly('Nama transportasi..', 'nama_kendaraan', $this->input->cookie('fnama_kendaraan')); ?>
                                    <?= stislaButtonMedium("<i class='fa fa-search'></i>", "primary", "bCari"); ?>
                                </div>
                            </div>
                            <?php
                            echo "<div class='card-header-action'>";
                            echo "<div class='input-group'>";
                            // if ($this->session->userdata('status') == 'admin') {
                            echo "<button class='btn btn-success' data-toggle='modal' data-target='#addModal'><i class='fas fa-plus'></i> Add</button>";
                            // }
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
                                        <th class="text-center">
                                            <i class="fas fa-th"></i>
                                        </th>
                                        <th>Nama transportasi</th>
                                        <th>Jenis</th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = $this->uri->segment('3') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td class='text-center' colspan='10'>Data tidak ditemukan!</td></tr>";
                                    } else {
                                        foreach ($data as $transportasi) { ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td><?= "$transportasi[nama_kendaraan]" ?></td>
                                                <td><?= "$transportasi[jenis_kendaraan]" ?></td>
                                                <td>
                                                    <a class="btn btn-icon btn-sm btn-info" href="<?= base_url('transportasi/update/' . encode($transportasi['id'])); ?>"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="<?= base_url('transportasi/delete/' . encode($transportasi['id'])); ?>" class="btn btn-icon btn-sm btn-danger" onClick="return confirm('Yakin menghapus transportasi?');" title="delete"><i class="fas fa-trash-alt"></i> Delete</a>
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
                <h5 class="modal-title">Add transportasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('transportasi'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nama_kendaraan" value="<?= set_value('nama_kendaraan') ?>" placeholder="Nama transportasi.." autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select name="jenis_kendaraan" class="form-control">
                            <?php
                            foreach (jenis_kendaraan() as $value) {

                                echo "<option value='$value[val]'>$value[val]</option>";
                            }

                            ?>
                        </select>
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
            document.location.href = '<?= base_url('transportasi/index') ?>';
            return false;
        });

        function setFilter() {
            setCookies('fnama_kendaraan', $('[name="nama_kendaraan"]').val());
        };
    });
</script>