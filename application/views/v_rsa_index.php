<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <a href="<?= base_url('rsa'); ?>" class="btn btn-primary">Hapus Semua</a>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('rsa'); ?>" role="form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Plain Text</label>
                                        <textarea class="form-control" name="plain" rows="3"><?= $data_rsa['plain']; ?></textarea>
                                    </div>
                                    <div>
                                        <pre><code>
                                                <?= $data_rsa['encrypt']; ?>
                                            </code>
                                        </pre>
                                    </div>
                                    <div class="form-group">
                                        <label>Chipper Text</label>
                                        <textarea name="chipper" class="form-control" rows="4" readonly disabled><?= $data_rsa['encrypt']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dekripsi</label>
                                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Plain Text</label>
                                        <textarea name="plaintext" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Ekripsi</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card card-warning card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md6">
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