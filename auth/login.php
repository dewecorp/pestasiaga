<?php
ob_start();
session_start();
include "../config/koneksi.php";
$sql = $koneksi->query("SELECT * FROM tb_panitia");
while ($data = $sql->fetch_assoc()) {
if (@$_SESSION['admin']) {
header("location:../admin/index.php");
} elseif (@$_SESSION['user']) {
header("location:../index.php");
} else {
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login Pesta Siaga <?=date('Y')?></title>
    <!-- Favicon-->
    <link rel="icon" href="../assets/images/<?=$data['logo']; ?>" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="../assets/css/material-google-font.css" rel="stylesheet" type="text/css">
    <link href="../assets/css/roboto-google-font.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="../assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="../assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/sweetalert2.min.css" rel="stylesheet">
    <!-- <script src="../assets/plugins/sweetalert/sweetalert.min.js"></script> -->
    <script src="../assets/js/sweetalert2.all.min.js"></script>
</head>
<style>
    img {
        width: 130px;
        height: 130px;
    }

    body {
        background-image: url('../assets/images/<?=$data['bg']; ?>');
        background-size: cover;
        overflow: hidden;
    }

    h1 {
        color: #228B22;
        text-align: center;
        font-size: 25px;
    }

    h4 {
        color: #A52A2A;
        text-align: center;
    }

</style>

<body class="login-page">
        <div class="login-box">
            <div class="card">
                <div class="body">
                    <div class="logo">
                        <div align="center">
                            <img src="../assets/images//<?=$data['logo']; ?>" alt="Login">
                        </div>
                        <h1>SISTEM INFORMASI NILAI</h1>
                        <h4 style="text-transform: uppercase;"><?=$data['nama_kegiatan']; ?> <?=date('Y')?></h4>
                    </div>
                    <div class="alert alert-success">
                        <center>Masukkan Username dan Password Anda</center>
                    </div>
                    <!-- <div class="msg">Masukkan Username dan Password</div> -->
                    <form id="sign_in" method="POST">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <button class="btn btn-success btn-block btn-lg waves-effect" type="submit" name="login"><strong>LOGIN</strong>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Jquery Core Js -->
        <script src="../assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap Core Js -->
        <script src="../assets/plugins/bootstrap/js/bootstrap.js"></script>
        <!-- Waves Effect Plugin Js -->
        <script src="../assets/plugins/node-waves/waves.js"></script>
        <!-- Validation Plugin Js -->
        <script src="../assets/plugins/jquery-validation/jquery.validate.js"></script>
        <!-- Custom Js -->
        <script src="../assets/js/admin.js"></script>
        <script src="../assets/js/pages/examples/sign-in.js"></script>
    <div class="legal align-center" style="color: #ffffff; position: fixed; bottom: 50px; width: 100%; text-align: center;">
        <div class="copyright">
            SISTEM INFORMASI NILAI &copy; <?=date('Y')?>
        </div>
    </div>
</body>

</html>
<?php
    if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $pass     = $_POST['password'];
    $sql = $koneksi->query("SELECT * FROM tb_user WHERE username ='$username' AND password ='$pass'");
    $data = $sql->fetch_assoc();
    $login = $sql->num_rows;
    if ($login > 0) {
    $_SESSION['level'] = $data['level'];
    $_SESSION['id_user'] = $data['id'];
    if ($_SESSION['level'] == "admin") {
    header("location:../admin/index.php");
    exit;
    } elseif ($_SESSION['level'] == "user") {
    header("location:../index.php");
    exit;
    }
    ?>

<script type="text/javascript">
    Swal.fire({
        icon: 'success',
        title: 'Selamat',
        text: 'Login Berhasil',
    })

</script>
<?php
} else {
?>
<script type="text/javascript">
    Swal.fire({
        icon: 'error',
        title: 'Mohon Maaf Kakak',
        text: 'Login Gagal, Username/Password Salah',
    })

</script>
<?php
    }
    }
    }
}
    ?>
