<?php

include '../database/koneksi.php';
session_start();
// jika button simpan di tekan
if (isset($_POST['simpan'])) {
    $id_level = $_POST['id_level'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = $_FILES['foto']['name'];
        $ukuran_foto = $_FILES['foto']['size'];


        $ext = array('png', 'jpg', 'jpeg');
        $extFoto = pathinfo($nama_foto, PATHINFO_EXTENSION);

        if (!in_array($extFoto, $ext)) {
            echo "Ext tidak ditemukan";
            die;
        } else {
            move_uploaded_file($_FILES['foto']['tmp_name'], '../upload/' . $nama_foto);
            $insert = mysqli_query($koneksi, "INSERT INTO user (id_level, nama_lengkap, no_telepon, alamat, email, password,foto) VALUES ('$id_level', '$nama_lengkap', '$no_telepon', '$alamat', '$email', '$pass','$nama_foto')");
            header("location: customer.php?tambah=berhasil");
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO user (id_level, nama_lengkap, no_telepon, alamat, email, password) VALUES ('$id_level', '$nama_lengkap', '$no_telepon', '$alamat', '$email', '$pass')");
    }
    // header("location: customer.php?tambah=berhasil");
}


$idUser  = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEditUser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN level on user.id_level = level.id WHERE user.id ='$idUser'");
$rowEditUser   = mysqli_fetch_assoc($queryEditUser);


// jika button edit di klik

if (isset($_POST['edit'])) {
    $id_level = $_POST['id_level'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = $_FILES['foto']['name'];
        $ukuran_foto = $_FILES['foto']['size'];

        // png, jpg, jpeg
        $ext = array('png', 'jpg', 'jpeg');
        $extFoto = pathinfo($nama_foto, PATHINFO_EXTENSION);

        if (!in_array($extFoto, $ext)) {
            echo "Extensi gambar tidak ditemukan";
            die;
        } else {
            unlink('../upload/' . $rowEditUser['foto']);
            move_uploaded_file($_FILES['foto']['tmp_name'], '../upload/' . $nama_foto);

            $update = mysqli_query($koneksi, "UPDATE user SET 
                id_level = '$id_level',
                nama_lengkap = '$nama_lengkap',
                no_telepon = '$no_telepon', 
                alamat = '$alamat',
                email = '$email',
                password = '$pass',
                foto = '$nama_foto'
                WHERE id = '$idUser'");
            header("location:customer.php?ubah=berhasil");
        }
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET 
            id_level = '$id_level',
            nama_lengkap = '$nama_lengkap',
            no_telepon = '$no_telepon', 
            alamat = '$alamat',
            email = '$email',
            password = '$pass'
            WHERE id = '$idUser'");
    }
    header("location: customer.php?ubah=berhasil");
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
                                                    value="<?php echo isset($_GET['edit']) ? $rowEditUser['nama_lengkap'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Tambah Email</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="email"
                                                    placeholder="Masukkan email anda"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEditUser['email'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Nomor Telepon</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="no_telepon"
                                                    placeholder="Masukkan nomor telepon anda"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEditUser['no_telepon'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Alamat</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="alamat"
                                                    placeholder="Masukkan nama user disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEditUser['alamat'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Password</label>
                                                <input type="password"
                                                    class="form-control"
                                                    name="password"
                                                    placeholder="Masukkan password disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEditUser['password'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Level</label>
                                                <select name="id_level" class="form-control" id="">
                                                    <option value="<?php echo isset($_GET['edit']) ? $rowEditUser['id_level'] : '' ?>"><?php echo isset($_GET['edit']) ? $rowEditUser['nama_level'] : '--Pilih barang--' ?></option>
                                                    <?php while ($rowLevel = mysqli_fetch_assoc($queryLevel)) { ?>
                                                        <option value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['nama_level'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Foto</label>
                                                <input type="file"
                                                    class="form-control"
                                                    name="foto"
                                                    placeholder="Masukkan foto disini"
                                                    value="<?php echo isset($_GET['edit']) ? $rowEditUser['foto'] : '' ?>">
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
    <?php include '../layout/logout-modal.php' ?>

    <?php include '../layout/js.php' ?>

</body>

</html>