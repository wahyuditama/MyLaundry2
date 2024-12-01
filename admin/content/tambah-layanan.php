<?php

include '../database/koneksi.php';

// jika button simpan di tekan
if (isset($_POST['simpan'])) {
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $insert = mysqli_query($koneksi, "INSERT INTO layanan (nama_paket, harga, deskripsi) VALUES ('$nama_paket','$harga','$deskripsi')");
    header("location: layanan.php?tambah=berhasil");
}


$id  = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM layanan WHERE id ='$id'");
$rowEdit   = mysqli_fetch_assoc($queryEdit);


// jika button edit di klik

if (isset($_POST['edit'])) {
    $nama_paket   = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $update = mysqli_query($koneksi, "UPDATE layanan SET nama_paket='$nama_paket', harga='$harga', deskripsi='$deskripsi' WHERE id='$id'");
    header("location:layanan.php?ubah=berhasil");
}

// ambil data dari level




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
                                <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Paket</div>
                                <div class="card-body">
                                    <?php if (isset($_GET['hapus'])): ?>
                                        <div class="alert alert-success" role="alert">
                                            Data berhasil dihapus
                                        </div>
                                    <?php endif ?>

                                    <form action="" method="post">
                                        <div class="mb-3 row">
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Tambah Nama Paket</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="nama_paket"
                                                    placeholder="Masukkan nama layanan"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_paket'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">Harga Paket</label>
                                                <input type="number"
                                                    class="form-control"
                                                    name="harga"
                                                    placeholder="Masukkan harga paket disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['harga'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="" class="form-label">deskripsi</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="deskripsi"
                                                    placeholder="Masukkan deskripsi barang disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['deskripsi'] : '' ?>">
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