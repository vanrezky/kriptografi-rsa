<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?> | Klinik Citra Bunda</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>public/assets/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">


        </div>
        <!-- /.login-logo -->
        <div class="card">
            <h1 class="mb-4 mt-2 text-center">Klinik Citra Bunda</h1>
            <img class="img-responsive" height="80" src="<?= base_url("public/assets/dist/img/medicine.svg"); ?>">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silahkan login untuk masuk aplikasi</p>
                <?= $this->session->flashdata('pesan_auth'); ?>

                <form action="<?= base_url('auth'); ?>" method="post">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Username" value="<?= set_value('username'); ?>" name="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Password" value="<?= set_value('password'); ?>" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                    </div>


                    <div class="float-right">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-6">
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <style>
        .login-page {
            background-image: url('<?= base_url('public/assets/dist/img/auth.jpg'); ?>') !important;
        }
    </style>
    <!-- jQuery -->
    <script src="<?= base_url(); ?>public/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>public/assets/dist/js/adminlte.min.js"></script>


</body>

</html>