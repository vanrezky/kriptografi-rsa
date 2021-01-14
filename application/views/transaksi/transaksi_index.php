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
                                    <?= stislaInputTextOnly('Cari..', 'cari', $this->input->cookie('fcari')); ?>
                                    <?= stislaButtonMedium("<i class='fa fa-search'></i>", "primary", "bCari"); ?>
                                </div>
                            </div>
                            <div class="card-header-action">
                                <div class="input-group">
                                    <a class="btn btn-success" href="<?= base_url($url); ?>"><i class="fas fa-plus"></i> Add</a> </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped" id="sortable-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <i class="fas fa-th"></i>
                                        </th>
                                        <th>Nomor Transaksi</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Suplier</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Total</th>
                                        <th>Jumlah Barang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    if (empty($allTransaksi)) {
                                        echo "<tr><td colspan='10' class='text-center'>Data tidak ditemukan</td></tr>";
                                    } else {
                                        foreach ($allTransaksi as $t) { ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $t['no_trans']; ?></td>
                                                <td><?= format_hari_tanggal($t['date_created']); ?></td>
                                                <td><?= $t['nama_suplier']; ?></td>
                                                <td><?= ucfirst($t['jenis_transaksi']); ?></td>
                                                <td><?= ifUang($t['total']); ?></td>
                                                <td><?= ifUang($t['count']); ?></td>
                                                <td>
                                                    <?php if (!empty($t['bukti_bayar'])) { ?>
                                                        <a href="<?= base_url('uploads/bukti/' . $t['bukti_bayar']); ?>" target="_blank" class="btn btn-icon btn-sm btn-success" title="bukti"><i class="fas fa-file-pdf"></i> Bukti</a>
                                                    <?php } ?>
                                                    <button data-id="<?= encode($t['no_trans']) ?>" class="btn btn-icon btn-sm btn-info lihat">
                                                        <span class="fas fa-eye show"></span>
                                                        <span class="spinner-border spinner-border-sm preload" role="status" hidden="true" aria-hidden="true"></span>
                                                        Lihat
                                                    </button>
                                                    <a href="<?= site_url('transaksi/hapus/' . encode($t['no_trans'])); ?>" onClick="return confirm('Yakin hapus data transaksi');" class="btn btn-icon btn-sm btn-danger" title="delete"><i class="fas fa-trash-alt"></i> Hapus</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="tampilkan_data"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.lihat').click(function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var preload = $(this).find(".preload");
            var show = $(this).find('.show');
            $(this).attr('disabled', true);
            preload.attr("hidden", false);
            show.hide();
            setTimeout(function() {
                window.location.href = '<?= base_url('transaksi/detail'); ?>/' + id;
            }, 500);

            return false;
        });
        $('[bCari]').click(function() {
            setFilter();
            document.location.href = '<?= base_url('transaksi/index') ?>';
            return false;
        });
    });

    function setFilter() {
        setCookies('fcari', $('[name="cari"]').val());
    };

    function view(no_resi) {
        barang = $('[id="barang"]');
        $.ajax({
            type: 'POST',
            data: {
                barang: no_resi
            },
            url: '<?= base_url('transaksi/view') ?>',
            cache: false,
            beforeSend: function() {
                barang.attr('disabled', true);
                $("#preload").attr("hidden", false);
                $('#show').hide();
            },
            success: function(data) {
                setTimeout(function() {
                    barang.attr('disabled', false);
                    $("#preload").attr("hidden", true);
                    $('#show').show();
                    $('.tampilkan_data').html(data);
                }, 1500);
            }
        });
        return false;
    }
</script>