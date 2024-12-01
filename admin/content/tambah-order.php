<?php

include '../database/koneksi.php';

// ambil data dari service 
$queryLayanan = mysqli_query($koneksi, "SELECT * FROM layanan ORDER BY id DESC");
$rowLayanan = mysqli_fetch_assoc($queryLayanan);

// Simpan semua hasil query ke dalam array
$services = [];
while ($row = mysqli_fetch_assoc($queryLayanan)) {
    $services[] = $row;
}
// munculkan / pilih sebuah atau semua kolom dari table 
$queryOrder = mysqli_query($koneksi, "SELECT *  FROM user ORDER BY id DESC");


// jika button simpan di tekan
if (isset($_POST['simpan'])) {

    $id_user = $_POST['id_user'];
    $no_invoice = $_POST['no_invoice'];
    $order_date = $_POST['order_date'];
    $keterangan = $_POST['keterangan'];

    $id_paket = $_POST['id_paket'];
    // insert ke table trans order 
    $insert = mysqli_query($koneksi, "INSERT INTO trans_paket (id_user, no_invoice, order_date, keterangan) VALUES ('$id_user', '$no_invoice', '$order_date', '$keterangan')");

    $last_id = mysqli_insert_id($koneksi);
    // Insert ke table trans_detail_order
    foreach ($id_paket as $key => $value) {
        // if ($key > 0) {
        // }
        $id_paket = array_filter($_POST['id_paket']);
        $qty = array_filter($_POST['qty']);
        $id_paket = $_POST['id_paket'][$key];
        $qty = $_POST['qty'][$key];

        $queryLayanan = mysqli_query($koneksi, "SELECT id, harga FROM layanan WHERE id = '$id_paket'");
        $rowLayanan = mysqli_fetch_assoc($queryLayanan);
        $harga = isset($rowLayanan['harga']) ? $rowLayanan['harga'] : '';
        //sub-total
        $subtotal = (int)$qty * (int)$harga;

        $insertTransDetail = mysqli_query($koneksi, "INSERT INTO detail_paket (id_user,id_paket, qty,subtotal) VALUES ('$last_id','$id_paket','$qty','$subtotal')");

        header("location: order.php?tambah=berhasil");
    }
}

// pembuatan nomor invoice
$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS no_invoice FROM trans_paket");
$no_unique = "INV";
$data_now = date("dmY");
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['no_invoice'] + 1;
    $codeInput = $no_unique . "/" . $data_now . "/" . "000" . $incrementPlus;
} else {
    $codeInput = $no_unique . "/" . $data_now . "/" . "001";
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
                    <!-- Content -->
                    <?php if (isset($_GET['detail'])) : ?>
                        <!-- untuk detail -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <h5 class="m-0 p-0">Transaksi Laundry :</h5>
                                                    <h5 class="text-warning fst-italic"><br> <?php echo $row[0]['costumer_name'] ?></h5>
                                                </div>
                                                <div class="col-sm-6 mb-3 mb-sm-0" align="right">
                                                    <a href="trans-order.php" class="btn btn-secondary"><i class='bx bx-arrow-back'></i></a>
                                                    <a href="print.php?id=<?php echo $row[0]['id_user'] ?>" class="btn btn-success"><i class='bx bx-printer'></i></a>
                                                    <?php if ($row[0]['status'] == 0): ?>
                                                        <a href="tambah-pickup.php?ambil=<?php echo $row[0]['id_user'] ?>" class="btn btn-warning"><i class='bx bx-closet'></i></a>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Detail Data Transaksi</h5>
                                        </div>
                                        <?php include 'helper.php' ?>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <td><?php echo $row[0]['order_code'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <td><?php echo $row[0]['order_date'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo changeStatus($row[0]['status']) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Data Pelanggan</h5>
                                        </div>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>Nama </th>
                                                    <td><?php echo $row[0]['costumer_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>nomor Telepon</th>
                                                    <td><?php echo $row[0]['phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?php echo $row[0]['alamat'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Transaksi Detail</h5>
                                        </div>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama service</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($row as $key => $value) : ?>
                                                        <tr>
                                                            <td> <?php echo $no++ ?></td>
                                                            <td> <?php echo $value['service_name'] ?></td>
                                                            <td> <?php echo $value['qty'] ?></td>
                                                            <td> <?php echo $value['harga'] ?></td>
                                                            <td> <?php echo $value['subtotal'] ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- untuk tambah -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil dihapus
                                                    </div>
                                                <?php endif ?>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label"> Costumer</label>
                                                        <select data-mdb-select-init name="id_user" class="form-control">
                                                            <option value="">Pilih Costumer</option>
                                                            <?php while ($rowUser = mysqli_fetch_assoc($queryOrder)) { ?>
                                                                <option <?php echo isset($rowEdit['id']) ? ($rowUser['id'] == $rowEdit['id']) ? 'selected' : '' : '' ?>
                                                                    value="<?php echo $rowUser['id'] ?>"><?php echo $rowUser['nama_lengkap'] ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">No Invoice</label>
                                                        <input type="text" class="form-control" name="no_invoice" value="#<?php echo $codeInput ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tanggal</label>
                                                        <input type="date"
                                                            class="form-control"
                                                            name="order_date"
                                                            placeholder="Masukkan tanggal"
                                                            required
                                                            value="<?php echo isset($_GET['edit']) ? $rowEdit['date'] : '' ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-12">
                                                        <label for="" class="form-label">Keterangan</label>
                                                        <input type="text"
                                                            name="keterangan"
                                                            placeholder="Tulis Keterangan atau Note disini"
                                                            class=" form-control"
                                                            id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Detail' ?> Transaksi</div>
                                            <div class="card-body">
                                                <?php if (isset($_GET['hapus'])): ?>
                                                    <div class="alert alert-success" role="alert">
                                                        Data berhasil dihapus
                                                    </div>
                                                <?php endif ?>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label"> Service</label>

                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select data-mdb-select-init name="id_paket[]" class="form-control">
                                                            <option value="">Pilih service</option>
                                                            <?php foreach ($services as $key => $value) { ?>
                                                                <option value="<?php echo $value['id']; ?>">
                                                                    <?php echo $value['nama_paket']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label">qty </label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="qty[]" value="">
                                                    </div>

                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label"> Service</label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <select data-mdb-select-init name="id_pake[]t" class="form-control">
                                                            <option value="">Pilih service</option>
                                                            <?php foreach ($services as $key => $value) { ?>
                                                                <option value="<?php echo $value['id']; ?>">
                                                                    <?php echo $value['nama_paket']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label for="" class="form-label">qty </label>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="qty[]" value="">
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php endif ?>
                    <!-- / Content -->

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