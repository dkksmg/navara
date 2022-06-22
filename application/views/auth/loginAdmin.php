<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NAVARA - LOGIN</title>
    <link rel="shortcut icon" href="<?= base_url('assets/') ?>logo/favicon.png" type="image/x-icon" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet"
        href="<?= base_url('assets/admin/') ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-success">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>NAVARA</b><br></a>
                <p>Layanan servis kendaraan operasional dinas kesehatan</p>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('message') ?>
                <p class="login-box-msg">Login Admin</p>
                <?php echo form_open('auth/check_login_admin', 'class="form-signin"'); ?>
                <div class="input-group mb-3">
                    <input type="text"
                        class="form-control <?php if (form_error('username') == TRUE) : ?> is-invalid <?php endif ?>"
                        placeholder="Username" name="username" value="<?= set_value('username') ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <?= form_error('username', '<small class="text-danger pl-3" style="margin-bottom:20px">', '</small>') ?>
                <div class="input-group mb-3 mt-3">
                    <input type="password"
                        class="form-control <?php if (form_error('password') == TRUE) : ?> is-invalid <?php endif ?>"
                        placeholder="Password" name="password" id="pass">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span title="Lihat Password" id="show-pw" onclick="change()"><i
                                    class="fas fa-eye"></i></span>
                        </div>
                    </div>
                </div>
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Masuk</button>
                    </div>

                </div>
                <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/admin/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('assets/admin/') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/admin/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/admin/') ?>dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/admin/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4500);
    });
    </script>
    <script type="text/javascript">
    function change() {
        var x = document.getElementById('pass').type;

        if (x == 'password') {
            document.getElementById('pass').type = 'text';
            document.getElementById('show-pw').innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            document.getElementById('pass').type = 'password';
            document.getElementById('show-pw').innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
    </script>
</body>

</html>