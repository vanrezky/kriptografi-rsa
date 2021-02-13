<style>
    textarea {
        resize: none;
    }

    .middle {
        vertical-align: middle;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3>Enkripsi RSA</h3>
                    </div>
                    <div class="card-body">
                        <div class="row middle">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <textarea class="form-control" name="plain" rows="3"></textarea>
                                    <div class="text-center">Plainteks</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-default" enkripsi><i class="fas fa-lock"></i> Ekripsi</button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <textarea class="form-control chip" name="" rows="3"></textarea>
                                    <div class="text-center">Chipherteks</div>
                                </div>
                            </div>
                            <div class="col-md-12" hasilenkripsi>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3>Dekripsi RSA</h3>
                    </div>
                    <div class="card-body">
                        <div class="row middle ">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <textarea class="form-control" name="chip" rows="3"></textarea>
                                    <div class="text-center">Chipherteks</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-default" dekripsi><i class="fas fa-unlock"></i> Dekripsi</button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <textarea class="form-control plain" rows="3"></textarea>
                                    <div class="text-center">Plainteks</div>
                                </div>
                            </div>
                            <div class="col-md-12" hasildekripsi>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const BASEURL = '<?= base_url() ?>';
        $('[enkripsi]').click(function() {
            var plain = $('[name="plain"]').val(),
                cleanPlain = plain.trim();

            if (cleanPlain == '') {
                alert('plainteks tidak boleh kosong!');
                return false;
            }

            $.ajax({
                url: BASEURL + 'rsa/enkripsi',
                type: "POST",
                data: {
                    plain: plain
                },
                dataType: "JSON",
                error: function() {
                    alert("Terjadi kesalahan, lakukan refresh");
                },
                success: function(response) {

                    if (response.success) {
                        $('[hasilenkripsi]').empty();
                        $('.chip').val(response.proses.Chipperteks);
                        $('[hasilenkripsi]').append(response.message);

                    }
                },
            });

        });

        $('[dekripsi]').click(function() {
            var chip = $('[name="chip"]').val(),
                cleanChip = chip.trim();

            if (cleanChip == '') {
                alert('chipperteks tidak boleh kosong!');
                return false;
            }

            $.ajax({
                url: BASEURL + 'rsa/dekripsi',
                type: "POST",
                data: {
                    chip: chip
                },
                dataType: "JSON",
                error: function() {
                    alert("Terjadi kesalahan, lakukan refresh");
                },
                success: function(response) {

                    if (response.success) {
                        $('[hasildekripsi]').empty();
                        $('.plain').val(response.proses.Plainteks);
                        $('[hasildekripsi]').append(response.message);

                    }
                },
            });

        });
    });
</script>