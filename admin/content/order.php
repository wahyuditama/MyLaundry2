<?php
session_start();
include '../database/koneksi.php';
// munculkan / pilih sebuah atau semua kolom dari table trans_order
$querytrans_order = mysqli_query($koneksi, "SELECT user.nama_lengkap,trans_paket.* FROM trans_paket LEFT JOIN user ON user.id = trans_paket.id_user ORDER BY ID DESC");
// mysqli_fetch_assoc($query) = untuk menjadikan hasil query menjadi sebuah data (object,array)

// jika parameternya ada ?delete=nilai param
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; //mengambil nilai params

    // query / perintah hapus
    $delete = mysqli_query($koneksi, "DELETE FROM trans_paket  WHERE id ='$id'");
    header("location:order.php?hapus=berhasil");
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
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">Data Transaksi Laundry</div>
                                <div class="card-body">
                                    <?php if (isset($_GET['hapus'])): ?>
                                        <div class="alert alert-success" role="alert">
                                            Data berhasil dihapus
                                        </div>
                                    <?php endif ?>
                                    <div align="right" class="mb-3">
                                        <a href="tambah-order.php" class="btn btn-primary">Tambah</a>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No. Invoice</th>
                                                <th>Pelanggan</th>
                                                <th>tanggal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            while ($rowtrans_order = mysqli_fetch_assoc($querytrans_order)) { ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $rowtrans_order['no_invoice'] ?></td>
                                                    <td><?php echo $rowtrans_order['nama_lengkap'] ?></td>
                                                    <td><?php echo $rowtrans_order['order_date'] ?></td>
                                                    <td>
                                                        <?php switch ($rowtrans_order['status']) {
                                                            case '1':
                                                                $badge = "<span class='badge bg-success'> sudah dikembalikan</span>";
                                                                break;

                                                            default:
                                                                $badge = "<span class='badge bg-warning'> Baru</span>";
                                                                break;
                                                        }
                                                        echo $badge;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="tambah-order.php?detail=<?php echo $rowtrans_order['id'] ?>" class="btn btn-primary btn-sm">
                                                            <span class="tf-icon bx bx-show bx-18px "></span>
                                                        </a>
                                                        <a target="blank" href="print.php?id=<?php echo $rowtrans_order['id'] ?>" class="btn btn-success btn-sm">
                                                            <span class="tf-icon bx bx-printer bx-18px "></span>
                                                        </a>
                                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"
                                                            href="order.php?delete=<?php echo $rowtrans_order['id'] ?>" class="btn btn-danger btn-sm">
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