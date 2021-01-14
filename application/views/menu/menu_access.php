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
                                        <th>Role Access</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <form>
                                        <?php $no = 1;
                                        foreach ($role as $r) { ?>

                                            <tr>
                                                <td align="center"><?= $no++; ?></td>
                                                <td><?= $r['role'] ?></td>
                                                <td>
                                                    <a href="<?= base_url('menu/roleaccess/') . encode($r['id']); ?>" class="btn btn-icon btn-sm btn-info"><i class="far fa-eye"></i> access</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>