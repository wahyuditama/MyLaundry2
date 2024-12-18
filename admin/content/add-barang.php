<?php

include '../database/koneksi.php';
session_start();
// jika button simpan di tekan
if (isset($_POST['simpan'])) {
    $kategori = $_POST['id_kategori'];
    $invoice = $_POST['inv_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $note = $_POST['note'];

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
            $insert = mysqli_query($koneksi, "INSERT INTO barang (id_kategori, inv_barang, nama_barang, satuan, qty, harga, judul,deskripsi, note,foto) VALUES ('$kategori','$invoice','$nama_barang','$satuan','$qty','$harga','$judul','$deskripsi','$note','$nama_foto')");
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO barang (id_kategori, inv_barang, nama_barang, satuan, qty, harga, judul,deskripsi, note) VALUES '$kategori','$invoice','$nama_barang','$satuan','$qty','$harga','$judul','$deskripsi','$note')");
    }

    header("location: item-data-detail.php?tambah=berhasil");
}


$id  = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM barang WHERE id ='$id'");
$rowEdit   = mysqli_fetch_assoc($queryEdit);


// jika button edit di klik

if (isset($_POST['edit'])) {
    $kategori = $_POST['id_kategori'];
    $invoice = $_POST['inv_barang'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $note = $_POST['note'];

    // Jika user ingin mengganti gambar
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
            unlink('../upload/' . $rowEdit['foto']);
            move_uploaded_file($_FILES['foto']['tmp_name'], '../upload/' . $nama_foto);

            $update = mysqli_query($koneksi, "UPDATE barang SET 
             id_kategori = '$kategori', 
            inv_barang = '$invoice', 
            nama_barang = '$nama_barang', 
            satuan = '$satuan', 
            qty = '$qty', 
            harga = '$harga',
            judul = '$judul', 
            deskripsi = '$deskripsi',  
            note = '$note', 
            foto = '$nama_foto'
        WHERE id = '$id'");
        }
    } else {
        $update = mysqli_query($koneksi, "UPDATE barang SET 
         id_kategori = '$kategori', 
            inv_barang = '$invoice', 
            nama_barang = '$nama_barang', 
            satuan = '$satuan', 
            qty = '$qty', 
            harga = '$harga', 
        judul = '$judul', 
        deskripsi = '$deskripsi',  
        note = '$note'
    WHERE id = '$id'");
    }

    header("location:item-data-detail.php?ubah=berhasil");
}

// ambil data dari level

//Kode Transaksi Barang

function kode_transaksi_barang()
{
    $kode = date('Ymdhis');
    return $kode;
}

// Ambil data kategori dari database
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori_barang");
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
                        <!-- Section-Barang -->
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="btn btn-primary"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Barang</h5>
                                    <h4 onclick="window.history.back();">
                                        <a href="" class="btn-sm btn-secondary"><i class='bx bx-left-arrow-alt'></i></a>
                                        <a href="" class="btn-sm btn-warning"><i class='bx bx-cart-download'></i></a>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php if (isset($_GET['hapus'])): ?>
                                        <div class="alert alert-success" role="alert">
                                            Data berhasil dihapus
                                        </div>
                                    <?php endif ?>

                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-3 row">
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Kode Transaksi Barang</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="inv_barang"
                                                    placeholder="Masukkan nama barang"
                                                    required
                                                    value="<?php echo "TRB-" . kode_transaksi_barang() ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Nama Barang</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="nama_barang"
                                                    placeholder="Masukkan harga paket disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['nama_barang'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Pilih Kategori Barang</label>
                                                <select name="id_kategori" id="kategori" class="form-control" required>
                                                    <option value="">--Pilih Kategori--</option>
                                                    <?php
                                                    while ($kategori = mysqli_fetch_assoc($queryKategori)) {
                                                        echo "<option value='" . $kategori['id'] . "'>" . $kategori['nama_kategori'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Nama satuan</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="satuan"
                                                    placeholder="Masukkan harga paket disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['satuan'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Qty</label>
                                                <input type="number"
                                                    class="form-control"
                                                    name="qty"
                                                    placeholder="Masukkan deskripsi barang disini"
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['qty'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Harga</label>
                                                <input type="number"
                                                    class="form-control"
                                                    name="harga"
                                                    placeholder="Masukkan deskripsi barang disini"
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['harga'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Judul Judul</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="judul"
                                                    placeholder="Masukkan harga paket disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['judul'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Deskripsi Barang</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="deskripsi"
                                                    placeholder="Masukkan harga paket disini"
                                                    required
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['deskripsi'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">Foto Barang</label>
                                                <input type="file"
                                                    class="form-control"
                                                    name="foto"
                                                    placeholder="Masukkan deskripsi barang disini"
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['foto'] : '' ?>">
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="" class="form-label">note</label>
                                                <input type="text"
                                                    class="form-control"
                                                    name="note"
                                                    placeholder="Masukkan deskripsi barang disini"
                                                    value="<?php echo isset($_GET['edit']) ? $rowEdit['note'] : '' ?>">
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
                        <!-- end-section-Barang -->
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
    <!-- javascript -->

    <?php include '../layout/js.php' ?>

</body>

</html>