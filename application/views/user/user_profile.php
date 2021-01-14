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
            <h2 class="section-title">Hi, <?= ucfirst($data['name']); ?>!</h2>
            <p class="section-lead">
                Perbarui informasi di halaman ini
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="<?= base_url('uploads/images/' . $data['image']) ?>" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Bergabung sejak</div>
                                    <div class="profile-widget-item-value"><?= date('d F Y', $user['date_created']) ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name"><?= ucfirst($data['name']) ?> <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div> <?= ucfirst($data['role']) ?>
                                </div>
                            </div>
                            Sekilas <br />
                            <?= ucfirst($data['name']) ?> adalah seorang <?= ucfirst($data['role']) ?> di aplikasi ini.
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" action="<?= base_url('user/profile/' . encode($data['email'])) ?>">
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" value="<?= $data['email'] ?>" required="" readonly disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" value="<?= $data['name']; ?>" name="name" required="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>Password Lama (Kosongkan semua jika tidak ingin mengganti password)</label>
                                        <input type="password" class="form-control" name="passlama">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Password Baru</label>
                                        <input type="password" class="form-control" name="passbaru1">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Ketik ulang password baru</label>
                                        <input type="password" class="form-control" name="passbaru2">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>