<?php
session_start();
include '../database/koneksi.php';

// munculkan / pilih sebuah atau semua kolom dari table barang
$nama_kategori = isset($_GET['nama_kategori']) ? $_GET['nama_kategori'] : '';
$nama_satuan = isset($_GET['nama_satuan']) ? $_GET['nama_satuan'] : '';
$jumlah_qty = isset($_GET['jumlah_qty']) ? $_GET['jumlah_qty'] : '';

// Membangun query dasar dalam bentuk string
$queryBarang = "SELECT kategori_barang.nama_kategori, barang.* FROM barang LEFT JOIN kategori_barang ON kategori_barang.id = barang.id_kategori WHERE 1=1";

$queryFilter = mysqli_query($koneksi, "SELECT DISTINCT qty FROM barang ORDER BY qty ASC");

// Menambahkan kondisi berdasarkan input GET
if ($nama_kategori != '') {
    $queryBarang .= " AND barang.id_kategori = '$nama_kategori'";
}

if ($nama_satuan != '') {
    $queryBarang .= " AND barang.satuan = '$nama_satuan'";
}

if ($jumlah_qty != '') {
    $queryBarang .= " AND barang.qty = '$jumlah_qty'";
}

// $jumlah_qty .= " GROUP BY barang.qty";
// Eksekusi query 
$sqlBarang = mysqli_query($koneksi, $queryBarang);

// Ambil hasil query
$dataBarang = [];
while ($row_barang = mysqli_fetch_assoc($sqlBarang)) {
    $dataBarang[] = $row_barang;
}

// print_r($sqlBarang);
// die();
// jika parameternya ada ?delete=nilai param
if (isset($_GET['delete'])) {
    $id = $_GET['delete']; //mengambil nilai params

    // query / perintah hapus
    $delete = mysqli_query($koneksi, "DELETE FROM barang  WHERE id ='$id'");
    header("location:item-data-detail.php?hapus=berhasil");
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
                                        <a href="add-barang.php" class="btn btn-primary">Tambah</a>
                                        <a href="transaksi.php" class="btn btn-warning">Tambah Transaksi</a>
                                    </div>
                                    <!-- Filter Data Transaksi -->
                                    <form action="" method="get">
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                <label for="">Kategori Barang</label>
                                                <!-- Select untuk nama_barang -->
                                                <select name="nama_kategori" class="form-control">
                                                    <option value="">---Pilih Kategori---</option>
                                                    <?php foreach ($dataBarang as $kategori): ?>
                                                        <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['nama_kategori']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>

                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Satuan</label>
                                                <select name="nama_Satuan" class="form-control" id="">
                                                    <option value="">---Pilih Satuan---</option>
                                                    <?php foreach ($dataBarang as $satuan) : ?>
                                                        <option value="<?php echo $satuan['satuan']; ?>"><?php echo $satuan['satuan']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="">Qty</label>
                                                <select name="jumlah_qty" class="form-control">
                                                    <option value="">---Pilih Qty---</option>
                                                    <?php foreach ($dataBarang as $qty) : ?>
                                                        <option value="<?php echo $qty['qty']; ?>"><?php echo $qty['qty']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-3">
                                                <button name="filter" class="btn btn-outline-primary form-control"> Tampilkan Laporan</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No. Invoice</th>
                                                <th>Nama Barang</th>
                                                <th>qty</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($dataBarang as $row) :  ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $row['inv_barang'] ?></td>
                                                    <td><?php echo $row['nama_barang'] ?></td>
                                                    <td><?php echo $row['qty'] ?></td>
                                                    <td><?php echo $row['harga'] ?></td>
                                                    <td>
                                                        <a href="add-barang.php?edit=<?php echo $row['id'] ?>" class="btn btn-success btn-sm">
                                                            <span class="tf-icon bx bx-pencil bx-18px "></span>
                                                        </a>
                                                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini??')"
                                                            href="item-data-detail.php?delete=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">
                                                            <span class="tf-icon bx bx-trash bx-18px "></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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
        </div>
        <!-- End of Footer -->

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
                    <a class="btn btn-primary" href="keluar.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php include '../layout/js.php' ?>

</body>

</html>