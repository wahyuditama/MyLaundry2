<?php
session_start();
include '../database/koneksi.php';

//untuk nomor invoice
function generateTransactionCode()
{
    $kode = date('Ymdhis');
    return $kode;
}


//Tampilkan detail transaksi
$id =  isset($_GET['detail']) ? $_GET['detail'] : '';
$queryDetail = mysqli_query($koneksi, "SELECT 
penjualan.*, 
barang.*,
detail_paket.* 
    FROM 
detail_paket 
    LEFT JOIN 
penjualan 
    ON 
penjualan.id = detail_paket.id_penjualan
    LEFT JOIN
barang
    ON 
barang.id = detail_paket.id_barang
    WHERE 
detail_paket.id_penjualan = '$id'");



// Simpan hasil query ke dalam array
$rowDetail = [];
while ($dataTrans = mysqli_fetch_assoc($queryDetail)) {
    $rowDetail[] = $dataTrans;
}

// Handle form submissions, mengambil nilai input dengan attribute name="" di form
if (isset($_POST['simpan'])) {

    $id_user = $_SESSION['ID'] ? $_SESSION['ID'] : ''; // ambil data ID dari session

    $kode_transaksi = $_POST['kode_transaksi'];
    $pengguna = $_POST['nama_pengguna'];
    $email = $_POST['email_pengguna'];
    $no_telepon = $_POST['telepon_pengguna'];
    $status = $_POST['status'];
    $total_harga = $_POST['total_harga'];
    $nominal_bayar = $_POST['nominal_bayar'];
    $kembalian = $_POST['kembalian'];

    $queryPenjualan = mysqli_query($koneksi, " INSERT INTO penjualan (id_user, kode_transaksi, nama_pengguna, email_pengguna, telepon_pengguna, status) VALUES ('$id_user','$kode_transaksi','$pengguna','$email','$no_telepon','$status')");

    $id_penjualan = mysqli_insert_id($koneksi);

    foreach ($_POST['id_barang'] as $key => $id_barang) {
        $jumlah = $_POST['jumlah'][$key];
        $harga = $_POST['harga'][$key];
        $sub_total = $_POST['subtotal'][$key];


        $detailPenjualan = mysqli_query($koneksi, "INSERT INTO detail_paket (sub_total,id_penjualan, id_barang, jumlah, harga, total_harga, nominal_bayar, kembalian) 
        VALUES ('$sub_total','$id_penjualan', '$id_barang', '$jumlah', '$harga', '$total_harga', '$nominal_bayar', '$kembalian')");


        $updateQty = mysqli_query($koneksi, "UPDATE barang SET qty = qty - $jumlah WHERE id= '$id_barang'");
    }
    // select detail_paket untuk mendapatkan id
    $selectDetailPaket = mysqli_query($koneksi, "SELECT * FROM detail_paket ORDER BY id DESC ");
    $rowDetailPaket = mysqli_fetch_assoc($selectDetailPaket);
    header("Location:transaksi.php?detail=" . $rowDetailPaket['id']);
    exit();
}

$queryDataBarang = mysqli_query($koneksi, "SELECT * FROM kategori_barang ");
$rowDataBarang = mysqli_fetch_all($queryDataBarang, MYSQLI_ASSOC);

ob_clean(); // Bersihkan output buffer

if (isset($_GET['id_kategori'])) {
    $id_kategori = mysqli_real_escape_string($koneksi, $_GET['id_kategori']);

    // Periksa query
    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_kategori = '$id_kategori'");

    // tampung data kedalam $row
    $items = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $items[] = $row;
    }

    // Pastikan hanya JSON yang dikirim
    header('Content-Type: application/json');
    echo json_encode($items);
    exit;
}

if (isset($_GET['id_barang'])) {
    $id_barang = mysqli_real_escape_string($koneksi, $_GET['id_barang']);
    // Mengambil seluruh data barang
    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = '$id_barang'");

    if (mysqli_num_rows($query) > 0) {
        $item = mysqli_fetch_assoc($query);

        header('Content-Type: application/json');
        echo json_encode($item); // Mengirim semua kolom dari tabel barang
        exit;
    } else {
        echo json_encode(['error' => 'Data barang tidak ditemukan']);
        exit;
    }
}

// Jika ada paramter 'print'
$prints = isset($_GET['print']) ? $_GET['print'] : '';

if (isset($_GET['print'])) {
    $prints = intval($_GET['print']);

    $queryEditStatus = mysqli_query($koneksi, "UPDATE penjualan SET status = 1 WHERE id = '$prints'");
}

// print data 
if ($prints) {
    echo "<script>
    window.onload = function() { 
        window.print();
    }
    </script>";
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
        <?php if (!isset($_GET['print'])) : ?>
            <?php include '../layout/sidebar.php' ?>
        <?php endif; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Navbar Topbar-posittion -->
                <?php if (!isset($_GET['print'])) : ?>
                    <?php include '../layout/navbar.php' ?>
                <?php endif ?>
                <!-- End of Topbar-posittion -->

                <!-- Begin Page Content -->
                <div class="container-fluid mt-3">

                    <!-- Page Heading -->
                    <?php if (isset($_GET['detail'])) : ?>
                        <!-- Detail Transaksi -->
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <h5 class="m-0 p-0">Transaksi Pembelian :</h5>
                                                <h5 class="text-warning fst-italic"><br> <?php echo $rowDetail[0]['nama_pengguna'] ?></h5>
                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0" align="right">
                                                <a href="" class="btn btn-secondary" onclick="window.history.back();"><i class='bx bx-arrow-back'></i></a>
                                                <a href="transaksi.php?print=<?php echo $rowDetail[0]['id_penjualan'] ?>&detail=<?php echo $rowDetail[0]['id_penjualan'] ?>" onclick="" class="btn btn-success"><i class='bx bx-printer'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-1 print">
                                <div class=" col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Detail Data Transaksi</h5>
                                        </div>
                                        <?php include '../layout/helper.php' ?>
                                        <div class="card-Body">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <th>No Invoice</th>
                                                    <td><?php echo $rowDetail[0]['kode_transaksi'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <td><?php echo $rowDetail[0]['create_at'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td><?php echo changeStatus($rowDetail[0]['status']) ?></td>
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
                                                    <td><?php echo $rowDetail[0]['nama_pengguna'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>nomor Telepon</th>
                                                    <td><?php echo $rowDetail[0]['telepon_pengguna'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><?php echo $rowDetail[0]['email_pengguna'] ?></td>
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
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Satuan</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1;
                                                    foreach ($rowDetail as $key => $value) : ?>
                                                        <tr>
                                                            <td><?php echo $no++ ?></td>
                                                            <td><?php echo $value['nama_barang'] ?></td>
                                                            <td><?php echo $value['jumlah'] ?></td>
                                                            <td><?php echo $value['satuan'] ?></td>
                                                            <td><?php echo "Rp" . number_format($value['harga']) ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                            <div class="row m-2">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                <a align="center">Total Harga</a>
                                                            </th>
                                                            <td><?php echo "Rp"  . "." . number_format($value['total_harga']) ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                <a align="center">Nominal Bayar</a>
                                                            </th>
                                                            <td><?php echo "Rp"  . "." . number_format($value['nominal_bayar']) ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                <a align="center">Kembalian</a>
                                                            </th>
                                                            <td><?php echo "Rp"  . "." . number_format($value['kembalian']) ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Tambah Transaksi -->
                        <div class="row">
                            <div class="col-lg-12 col-md-8 table-header bg-tertiary">
                                <div class="card text-light border-4 shadow-lg p-3 mb-5 rounded">
                                    <div class="card-header text-center">
                                        <h4 class="fw-bold">Tabel Transaksi</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3 ">
                                                        <label for="" class="form-label">Kode Transaksi</label>
                                                        <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" value="<?php echo "TR-" . generateTransactionCode() ?>" readonly>
                                                    </div>
                                                    <div class="mb-3 ">
                                                        <label for="" class="form-label">email Pengguna</label>
                                                        <input type="text" class="form-control" id="email_pengguna" name="email_pengguna" value="<?php echo isset($_SESSION['Email']) ? $_SESSION['Email'] : '' ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3 ">
                                                        <label for="" class="form-label">Nama Pengguna</label>
                                                        <input type="text" class="form-control" id="kode_transaksi" name="nama_pengguna" value="<?php echo isset($_SESSION['namaPengguna']) ? $_SESSION['namaPengguna'] : '' ?>" readonly>
                                                    </div>
                                                    <div class="mb-3 ">
                                                        <label for="" class="form-label">Telepon Pengguna</label>
                                                        <input type="text" class="form-control" id="telepon_pengguna" name="telepon_pengguna" value="<?php echo isset($_SESSION['Telepon']) ? $_SESSION['Telepon'] : '' ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 ">
                                                    <div class="btn btn-outline-primary" type="button" id="counterBtn">Tambah</div>
                                                    <!-- <input type="number" name="countDisplay" id="countDisplay" class="visually-hidden" width="100%" value="<?php echo $_SESSION['click_count'] ?>" readonly> -->
                                                </div>
                                                <div class="table table-responsive rounded-2">
                                                    <table class=" table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Nomor</th>
                                                                <th>Nama Kategori</th>
                                                                <th>Nama Barang</th>
                                                                <th>Qty</th>
                                                                <th>Sisa Produk</th>
                                                                <th>Harga</th>
                                                                <th>Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody">
                                                            <!-- data ditambah disini -->
                                                        </tbody>
                                                        <tfoot class="text-center">
                                                            <tr>
                                                                <th colspan="6">Total Harga</th>
                                                                <td><input type="number" id="total_harga_keseluruhan" name="total_harga" class="form-control" readonly></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="6">Nominal Bayar</th>
                                                                <td><input type="text" name="nominal_bayar" class="form-control" id="nominal_bayar_keseluruhan" required></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="6">Kembalian</th>
                                                                <td><input type="number" id="kembalian_keseluruhan" name="kembalian" class="form-control" readonly></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="mb-3">
                                                <input type="submit" class="btn btn-outline-primary" name="simpan" value="Beli Sekarang">
                                                <a href="kasir.php" class="btn btn-danger">Kembali</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
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
    <?php include '../layout/logout-modal.php' ?>
    <!-- layout-javascript -->
    <?php include '../layout/js.php' ?>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //fungsi tambah baris
            const button = document.getElementById('counterBtn');
            const countDisplay = document.getElementById('countDisplay');
            const tbody = document.getElementById('tbody');
            const table = document.getElementById('table');
            let no = 0;
            button.addEventListener('click', function() {
                no++
                // let currentCount = parseInt(countDisplay.value) || 0;
                // ++currentCount;
                // countDisplay.value = currentCount;

                // Fungsi tambah baris (td)
                let newRow = "<tr>";
                newRow += "<td>" + no + "</td>";
                newRow += "<td><select class='form-control category-select' name='id_kategori[]' required>";
                newRow += "<option value=''>---Pilih Kategori---</option>";

                // PHP bagian ini akan diterjemahkan di sisi server
                <?php foreach ($rowDataBarang as $category) { ?>
                    newRow += "<option value='<?php echo $category['id']; ?>'><?php echo $category['nama_kategori']; ?></option>";
                <?php } ?>

                newRow += "</select></td>";
                newRow += "<td><select class='form-control item-select' name='id_barang[]' required>";
                newRow += "<option value=''>---Pilih Barang---</option>";
                newRow += "</select></td>";
                newRow += "<td><input type='number' class='form-control jumlah-input' name='jumlah[]' value='0' required></td>";
                newRow += "<td><input type='number' name='sisa_produk[]' class='form-control' readonly></td>";
                newRow += "<td><input type='number' name='harga[]' class='form-control' readonly></td>";
                newRow += "<td><input type='number' name='subtotal[]' class='form-control sub-total' readonly></td>";
                newRow += "</tr>";

                // Menyisipkan HTML ke dalam tbody
                tbody.insertAdjacentHTML('beforeend', newRow);

                attachCategoryChangeListener();
                attachItemChangeListener();
                attachJumlahChangeListener();

            });
            // fungsi untuk menampilkan brang berdasarkan kategori ...
            function attachCategoryChangeListener() {
                const categorySelects = document.querySelectorAll('.category-select');
                categorySelects.forEach(select => {
                    select.addEventListener('change', function() {
                        const categoryId = this.value;
                        const itemSelect = this.closest('tr').querySelector('.item-select');

                        if (categoryId) {
                            fetch('transaksi.php?id_kategori=' + categoryId)
                                .then(response => response.json())
                                .then(data => {
                                    itemSelect.innerHTML = '<option value="">---Pilih Barang---</option>';
                                    data.forEach(item => {
                                        itemSelect.innerHTML += `<option value="${item.id}">${item.nama_barang}</option>`;

                                    });
                                });
                        } else {
                            itemSelect.innerHTML = '<option value="">---Pilih Barang---</option>';
                        }
                    });

                });
            }


            function attachItemChangeListener() {
                const itemSelects = document.querySelectorAll('.item-select');
                itemSelects.forEach(select => {
                    select.addEventListener('change', function() {
                        const itemId = this.value;
                        const row = this.closest('tr');
                        const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                        const hargaInput = row.querySelector('input[name="harga[]"]');

                        if (itemId) {
                            fetch('transaksi.php?id_barang=' + itemId)
                                .then(response => response.json())
                                .then(data => {
                                    sisaProdukInput.value = data.qty;
                                    hargaInput.value = data.harga;
                                })
                        } else {
                            sisaProdukInput.value = '';
                            hargaInput.value = '';
                        }
                    });
                });
            }

            const totalHargaKeseluruhan = document.getElementById('total_harga_keseluruhan');
            // const subTotal = document.querySelectorAll('.sub-total');
            const nominalBayarKeseluruhanInput = document.getElementById('nominal_bayar_keseluruhan');
            const kembalianKeseluruhanInput = document.getElementById('kembalian_keseluruhan');

            // fungsi untuk membuat alert jumlah > sisaProduk
            function attachJumlahChangeListener() {
                const jumlahInputs = document.querySelectorAll('.jumlah-input');
                jumlahInputs.forEach(input => {
                    input.addEventListener('input', function() {
                        const row = this.closest('tr');
                        const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                        const totalHargaInput = row.querySelector('input[name="harga[]"]');
                        ('total_harga_keseluruhan');
                        const nominalBayarInput = document.getElementById('nominal_bayar_keseluruhan');
                        const kembalianInput = document.getElementById('kembalian_keseluruhan');

                        const jumlah = parseInt(this.value) || 0;
                        const sisaProduk = parseInt(sisaProdukInput.value) || 0;
                        const harga = parseInt(totalHargaInput.value) || 0;

                        if (jumlah > sisaProduk) {
                            alert("Jumlah tidak boleh melebihi sisa produk");
                            this.value = sisaProduk;
                            return;
                        }
                        updatetTotalKeseluruhan();
                    });
                });
            }

            function updatetTotalKeseluruhan() {
                let total = 0;
                let totalKeseluruhan = 0;
                const jumlahInput = document.querySelectorAll('.jumlah-input');

                jumlahInput.forEach(input => {
                    const row = input.closest('tr');
                    const hargaInput = row.querySelector('input[name="harga[]"]');
                    const harga = parseFloat(hargaInput.value) || 0;
                    const jumlah = parseInt(input.value) || 0;

                    const subTotal = row.querySelector('.sub-total');
                    total = jumlah * harga;
                    subTotal.value = total;
                });
                const subTotal = document.querySelectorAll('.sub-total');
                subTotal.forEach(totalItem => {
                    let subTotal = parseFloat(totalItem.value) || 0;
                    totalKeseluruhan += subTotal;
                })

                totalHargaKeseluruhan.value = totalKeseluruhan;

            }

            // mencari kembalian ..
            nominalBayarKeseluruhanInput.addEventListener('input', function() {
                const nominalBayar = parseFloat(this.value) || 0;
                const totalHarga = parseFloat(totalHargaKeseluruhan.value) || 0;
                // kembalianKeseluruhanInput.value = nominalBayar - totalHarga;
                if (nominalBayar >= totalHarga) {
                    let kembalian = nominalBayar - totalHarga;
                    kembalianKeseluruhanInput.value = kembalian;
                } else if (nominalBayar == 0) {
                    kembalianKeseluruhanInput.value = 0;
                }
            });
        });

        // untuk print konten
        function printElement(selector) {
            const printContent = document.querySelector(selector);
            const printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Cetak</title></head><body>');
            printWindow.document.write(printContent.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>


</body>

</html>