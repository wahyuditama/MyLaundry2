<?php

include '../database/koneksi.php';

// jika button simpan di tekan
if (isset($_POST['simpan'])) {
    $id_level = $_POST['id_level'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //ambil data dari list level
    $selectLevel = mysqli_query($koneksi, "SELECT * FROM level WHERE id = '$id_level'");
    $dataLevel = mysqli_fetch_assoc($selectLevel);
    $nama_level = $dataLevel['nama_level'];

    // insert data ke database
    $insert = mysqli_query($koneksi, "INSERT INTO user (id_level, level, nama_lengkap, no_telepon, alamat, email, password) VALUES ('$id_level', '$nama_level', '$nama_lengkap', '$no_telepon', '$alamat', '$email', '$pass')");
    header("location: customer.php?tambah=berhasil");
}


$id  = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM user WHERE id ='$id'");
$rowEdit   = mysqli_fetch_assoc($queryEdit);


// jika button edit di klik

if (isset($_POST['edit'])) {
    $id_level = $_POST['id_level'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];

    //ambil data dari list level
    $inputtLevel = mysqli_query($koneksi, "SELECT * FROM level WHERE id = '$id_level'");
    $resultLevel = mysqli_fetch_assoc($inputtLevel);
    $nama_level = $resultLevel['nama_level'];

    // insert data ke database

    $update = mysqli_query($koneksi, "UPDATE user SET 
    id_level = '$id_level',
    level = '$nama_level',
    nama_lengkap='$nama_lengkap',
    no_telepon='$no_telepon', 
    alamat='$alamat' 
     WHERE id='$id'");
    header("location:customer.php?ubah=berhasil");
}

// ambil data dari level

$id_level = isset($_GET['level']) ? $_GET['level'] : '';
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level");



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <?php include '../layout/head.php' ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include '../layout/sidebar.php' ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Navbar Topbar-posittion -->
                <?php include '../layout/navbar.php' ?>
                <!-- End of Topbar-posittion -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> users</div>
                                <div class="card-body">
                                    <?php if (isset($_GET['hapus'])): ?>
                                        <div class="alert alert-success" role="alert">
                                            Data berhasil dihapus
                                        </div>
                                    <?php endif ?>

                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-3 row">
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Tambah Nama</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="nama_lengkap"
                                                    placeholder="Masukkan nama user anda"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_lengkap'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Tambah Email</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="email"
                                                    placeholder="Masukkan email anda"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['email'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Nomor Telepon</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="no_telepon"
                                                    placeholder="Masukkan nomor telepon anda"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['no_telepon'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Alamat</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="alamat"
                                                    placeholder="Masukkan nama user disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['alamat'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Password</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="password"
                                                    placeholder="Masukkan password disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['password'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Level</label>
                                                <select name="id_level" class="form-control" id="">
                                                    <option value="">--Pilih Level---</option>
                                                    <?php while ($rowLevel = mysqli_fetch_assoc($queryLevel)) { ?>
                                                        <option value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['nama_level'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="mt-3">
                                            <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include '../layout/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layout/js.php' ?>

</body>

</html>