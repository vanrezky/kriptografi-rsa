<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-indigo elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('/'); ?>" class="brand-link">
        <img src="<?= base_url(); ?>public/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Klinik Citra Bunda</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>public/uploads/img/<?= $account_detail['foto']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0);" class="d-block"><?= ucfirst($account_detail['nama']); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url(); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Beranda</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('riwayat'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-recycle"></i>
                        <p>Riwayat Pasien</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('pasien'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                <?php if ($this->session->userdata('level') == 'PEMILIK') {; ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dokter'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>Data Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('perawat-bidan'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-user-nurse"></i>
                            <p>Data Perawat & Bidan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('user'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Users</p>
                        </a>
                    </li>
                <?php }; ?>
                <li class="nav-item">
                    <a href="<?= base_url('laporan'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('auth/logout'); ?>" class="nav-link">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>