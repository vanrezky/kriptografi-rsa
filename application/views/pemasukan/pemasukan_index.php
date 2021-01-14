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
                                    <?= stislaInputTextOnly('Cari..', 'pemasukan', $this->input->cookie('fpemasukan')); ?>
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
                                        <th>Tanggal</th>
                                        <th>Nama Proyek</th>
                                        <th>Jumlah</th>
                                        <th>Metode Bayar</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = $this->uri->segment('3') + 1;
                                    if (empty($data)) {
                                        echo "<tr><td class='text-center' colspan='10'>Data tidak ditemukan!</td></tr>";
                                    } else {

                                        foreach ($data as $pemasukan) { ?>
                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td><?= format_hari_tanggal($pemasukan['tanggal']) ?></td>
                                                <td><?= $pemasukan['nama_proyek'] ?></td>
                                                <td>Rp <?= ifUang($pemasukan['jumlah']) ?></td>
                                                <td><?= strtoupper($pemasukan['jenis_bayar']) ?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($pemasukan['bukti_bayar'])) {
                                                        echo "<a class='btn btn-icon btn-sm btn-success' target='_blank' href='" . base_url('uploads/bukti/' . $pemasukan['bukti_bayar']) . "'><i class='fas fa-file-pdf'></i> Bukti</a>";
                                                    }
                                                    ?>

                                                    <a class="btn btn-icon btn-sm btn-info" href="<?= base_url('pemasukan/update/' . encode($pemasukan['id'])); ?>"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="<?= base_url('pemasukan/delete/' . encode($pemasukan['id'])); ?>" class="btn btn-icon btn-sm btn-danger" onClick="return confirm('Yakin menghapus pemasukan?');" title="delete"><i class="fas fa-trash-alt"></i> Delete</a>
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
    </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pemasukan'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" required name="tanggal" value="<?= set_value('tanggal') ?>">
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" required name="jumlah" value="<?= set_value('jumlah') ?>" placeholder="Jumlah..">
                    </div>
                    <div class="form-group">
                        <label>Proyek</label>
                        <select class="form-control" name="proyek" required>
                            <option value=""> Pilih</option>
                            <?php
                            foreach ($proyek as $key => $value) {
                                echo "<option value='$value[id]'>$value[nama_proyek]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Bayar</label>
                        <select class="form-control" name="jenis_bayar" required>
                            <option value=""> Pilih</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>

                    <div class="form-group" id="form-upload" style="display:none">
                        <label>Bukti transfer</label>
                        <input type="file" class="form-control" name="bukti">
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
            document.location.href = '<?= base_url('pemasukan/index') ?>';
            return false;
        });
        $('[name="jenis_bayar"]').change(function() {
            var val = $(this).val();
            if (val == 'transfer') {
                $('#form-upload').show();
            } else {
                $('#form-upload').hide();
            }
            return false;
        });

    });

    function setFilter() {
        setCookies('fpemasukan', $('[name="pemasukan"]').val());
    };
</script>