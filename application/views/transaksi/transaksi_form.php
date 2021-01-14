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
                    <div class="card-body p-0">
                        <div class="card card-primary">
                            <div class="card-body">
                                <form action="" class="form-submit">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-8">
                                            <label for="">No Transaksi/Faktur</label>
                                            <input type="text" class="form-control" name="no_trans" value="<?= $no_trans ?>" readonly>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label for="">Proyek</label>
                                            <input class="form-control" type="date" name="date_created">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-8">
                                            <label for="">Proyek</label>
                                            <select name="proyek" class="form-control">
                                                <?php
                                                if (!empty($proyek)) {
                                                    echo "<option value=''>Pilih proyek</option>";
                                                    foreach ($proyek as $key => $value) {
                                                        echo "<option value='$value[id]'>$value[nama_proyek]</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Belum ada proyek</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-8">
                                            <label for="">Suplier</label>
                                            <select name="suplier" class="form-control">
                                                <?php
                                                if (!empty($suplier)) {
                                                    echo "<option value=''>Pilih suplier</option>";
                                                    foreach ($suplier as $key => $value) {
                                                        echo "<option value='$value[id]'>$value[nama_suplier]</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Belum ada suplier</option>";
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="">Jenis Transaksi</label>
                                            <select class="form-control" name="jenis_transaksi">
                                                <option value="">Pilih</option>
                                                <option value="barang">Barang</option>
                                                <option value="alat">Alat</option>
                                                <option value="transportasi">Transportasi</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 form-select"></div>

                                        <div class="form-group col-sm-12">
                                            <label for="">Satuan</label>
                                            <select class="form-control" name="satuan">
                                                <?php
                                                if (!empty($satuan)) {
                                                    echo "<option value=''>Pilih satuan</option>";
                                                    foreach ($satuan as $key => $value) {
                                                        echo "<option value='$value[satuan_id]'>$value[satuan]</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Belum ada satuan</option>";
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-12 col-md-4">
                                            <label for="">Harga</label>
                                            <input type="number" class="form-control" name="harga">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-5">
                                            <label for="">Jumlah</label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="jumlah" class="form-control" placeholder="" aria-label="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary sementara" type="button">Tambahkan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4">
                                            <label for="">Jenis Pembayaran</label>
                                            <select class="form-control" name="jenis_pembayaran">
                                                <option value="">Pilih</option>
                                                <option value="cash">Cash</option>
                                                <option value="transfer">Transfer</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4" style="display:none;" bukti_bayar>
                                            <label for="">Bukti Bayar</label>
                                            <input type="file" name="bukti_bayar" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>
                                                <i class="fas fa-shopping-cart"></i> List Pembelian
                                            </h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="sortable-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">
                                                                <i class="fas fa-th"></i>
                                                            </th>
                                                            <th>Nama</th>
                                                            <th>Harga</th>
                                                            <th>Jumlah</th>
                                                            <th>Satuan</th>
                                                            <th>Total Harga</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tampil-data">
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right" colspan="5">Grand Total</td>
                                                            <td id="grand-total" colspan="">0</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <button class="btn btn-primary float-left" type="submit"><i class="fas fa-shopping-cart"></i> Beli</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Main Content -->
<script type="text/javascript">
    $(document).ready(function() {

        tampil_data(); //==> tampilkan data 

        $('[name="jenis_pembayaran"]').change(function() {
            var element = $('[bukti_bayar]');
            var val = $(this).val();
            if (val == 'transfer') {
                element.show();
            } else {
                element.hide();
            }
        });

        $('[name="jenis_transaksi"]').change(function() {
            var val = $(this).val();
            var domClass = $('.form-select');
            var element = '';

            if (val === "") {
                return false;
            }

            $.ajax({
                url: "<?= base_url('transaksi/jenis'); ?>",
                method: "GET",
                data: {
                    jenis: val
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        destroy(); // hapus semua data transaksi sementara
                        domClass.empty();

                        element += '<label>' + val + '</label>';
                        element += '<select name="item" class="form-control">';
                        element += '<option value="">pilih</option>';
                        $.each(response.data, function(index, value) {
                            element += '<option value="' + value.id + '">' + value.nama + '</option>';
                        });
                        element += '</select>';

                        domClass.append(element);

                    } else {
                        iziToast.warning({
                            title: 'Opps',
                            message: response.message,
                            position: 'topRight',
                        });
                    }
                },
            });
        });
        $('.form-submit').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "<?= base_url('transaksi/simpan'); ?>",
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        iziToast.success({
                            title: 'Berhasil..',
                            message: response.message,
                            position: 'topRight',
                        });
                        tampil_data();
                        window.location.href = '<?= base_url('transaksi'); ?>';
                    } else {
                        iziToast.warning({
                            title: '',
                            message: response.message,
                            position: 'topRight',
                        });
                    }
                },
            });
        });

        $('.sementara').click(function(event) {
            var jumlah = $('[name="jumlah"]').val();
            var harga = $('[name="harga"]').val();
            var jenis_transaksi = $('[name="jenis_transaksi"]').val();
            var item = $('[name="item"]').val();
            var satuan = $('[name="satuan"]').val();
            if ($('[name="item"]').length < 1) { // ==> kondisi jika dom name="item" tidak ditemukan
                iziToast.warning({
                    title: 'Opps',
                    message: 'Silahkan pilih jenis transaksi terlebih dahulu!',
                    position: 'topRight',
                });
                return false;
            }
            $.ajax({
                url: "<?= base_url('transaksi/add_item'); ?>",
                method: "POST",
                data: {
                    jumlah: jumlah,
                    harga: harga,
                    jenis_transaksi: jenis_transaksi,
                    item: item,
                    satuan: satuan
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            title: 'Berhasil..',
                            message: response.message,
                            position: 'topRight',
                        });
                        tampil_data();
                    } else {
                        iziToast.warning({
                            title: 'Opps',
                            message: response.message,
                            position: 'topRight',
                        });
                    }
                },
            });
        });


        $(document).on('click', '.btn-remove', function() {
            var rowid = $(this).data('id');
            $.ajax({
                url: "<?= base_url('transaksi/remove'); ?>",
                method: "POST",
                data: {
                    rowid: rowid
                },
                dataType: "JSON",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        tampil_data();
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight',
                        });
                    } else {
                        iziToast.warning({
                            title: 'Opps',
                            message: response.message,
                            position: 'topRight',
                        });
                    }
                },
            });
        });
    });

    function tampil_data() {
        var tampil_data = $('#tampil-data');
        var grand_total = $('#grand-total');
        var element = '';
        $.ajax({
            url: "<?= base_url('transaksi/tampil_data'); ?>",
            method: "GET",
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                tampil_data.empty();
                if (response.data != '') {
                    var no = 1;

                    $.each(response.data, function(index, value) {
                        element += '<tr>';
                        element += '<td class="text-center">' + (no++) + '</td>';
                        element += '<td>' + value.name + '</td>';
                        element += '<td>' + rubah(value.price) + '</td>';
                        element += '<td>' + value.qty + '</td>';
                        element += '<td>' + value.satuan + '</td>';
                        element += '<td>' + rubah(value.subtotal) + '</td>';
                        element += '<td><button class="btn btn-default btn-remove" type="button" data-id="' + value.rowid + '"><i class="fas fa-times"></i></button></td>';
                        element += '</tr>';
                    });

                    tampil_data.append(element);
                    grand_total.empty().text(rubah(response.grand_total));

                } else {
                    grand_total.empty().text('0');
                }
            },
        });
        return false;
    }

    function destroy() {
        $.ajax({
            url: "<?= base_url('transaksi/destroy'); ?>",
            method: "POST",
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                $('#tampil-data').empty();
                $('#grand-total').empty().text('0');
            },
        });
    }

    function rubah(angka) {
        var reverse = angka.toString().split("").reverse().join(""),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join(".").split("").reverse().join("");
        return ribuan;
    }
</script>