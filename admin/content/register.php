<?php
include '../database/koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryRegister = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, email, password) VALUES ('$username', '$email', '$password')");
    if ($queryRegister) {
        header('location: login.php');
    } else {
        echo "Gagal mendaftar, silahkan coba lagi.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <?php include '../layout/head.php' ?>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="../img/home-logo.png" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5 mt-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register Disini</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="" name="username" aria-describedby=""
                                                placeholder="Masukan Nama Lengkap Anda">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Masukan Email Anda">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <a href="login.php" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a>
                                        <hr>
                                        <button href="" type="submit" name="register" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Register
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <?php include '../layout/js.php' ?>

</body>

</html>