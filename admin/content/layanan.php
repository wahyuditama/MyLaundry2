<?php
session_start();
include '../database/koneksi.php';
// munculkan / pilih sebuah atau semua kolom dari table layanan
$querylayanan = mysqli_query($koneksi, "SELECT * FROM layanan");
// mysqli_fetch_assoc($query) = untuk menjadikan hasil query menjadi sebuah data (object,array)

// jika parameternya ada ?delete=nilai param
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; //mengambil nilai params

    // query / perintah hapus
    $delete = mysqli_query($koneksi, "DELETE FROM layanan  WHERE id ='$id'");
    header("location:layanan.php?hapus=berhasil");
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Data layanan</div>
                                <div class="card-body">
                                    <?php if (isset($_GET['hapus'])): ?>
                                        <div class="alert alert-success" role="alert">
                                            Data Berhasil Dihapus
                                        </div>
                                    <?php endif ?>
                                    <div align="right" class="mb-3">
                                        <a href="tambah-layanan.php" class="btn btn-primary">Tambah</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Paket</th>
                                                    <th>Harga Paket</th>
                                                    <th>Deskripsi Paket</th>
                                                    <th>Aksi</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                while ($rowlayanan = mysqli_fetch_assoc($querylayanan)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++ ?></td>
                                                        <td><?php echo $rowlayanan['nama_paket'] ?></td>
                                                        <td><?php echo $rowlayanan['harga'] ?></td>
                                                        <td><?php echo $rowlayanan['deskripsi'] ?></td>
                                                        <td>
                                                            <a href="tambah-layanan.php?edit=<?php echo $rowlayanan['id'] ?>" class="btn btn-success btn-sm">
                                                                <span class="tf-icon bx bx-pencil bx-18px "></span>
                                                            </a>
                                                            <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"
                                                                href="layanan.php?delete=<?php echo $rowlayanan['id'] ?>" class="btn btn-danger btn-sm">
                                                                <span class="tf-icon bx bx-trash bx-18px "></span>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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