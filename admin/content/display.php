<?php

include '../database/koneksi.php';
session_start();

$sqlDataBarang = mysqli_query($koneksi, "SELECT * FROM barang");


// query delet deskripi_barang 

if (isset($_GET['delete'])) {
    $id = $_GET['delete']; //mengambil nilai params

    // query / perintah hapus
    $delete = mysqli_query($koneksi, "DELETE FROM barang  WHERE id ='$id'");
    header("location:display.php?hapus=berhasil");
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
<style>
    .card-section {
        transition: transform .2s ease;
    }

    .card-section:hover {
        transform: translateY(-10px);

    }
</style>

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
                    <div class="col-md-12">
                        <div class="card shadow  bg-body-tertiary rounded">
                            <div class="card-header d-flex justify-content-between">
                                <a href="" class="btn-md fw-bold">Data Barang</a>
                                <?php if ($_SESSION['NamaLevel'] == 1): ?>
                                    <a href="add-barang.php" class="btn-sm btn-primary">Tambah Deskripsi Barang</a>
                                <?php endif ?>
                            </div>
                            <div class="card-body">
                                <div class="row p-4 shadow bg-body-tertiary rounded">
                                    <?php while ($rowDetailBarang = mysqli_fetch_assoc($sqlDataBarang)) { ?>
                                        <div class="col-md-3 pb-4">
                                            <div class="card card-section p-3 shadow bg-body-tertiary rounded" style="width: 17rem;">
                                                <img src="../upload/<?php echo $rowDetailBarang['foto'] ?>" class="img-fluid" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title border-bottom d-flex justify-content-between">
                                                        <a href="" class="btn-sm shadow-lg"><?php echo $rowDetailBarang['nama_barang'] ?></a>
                                                        <a href="" class="btn-sm btn-primary shadow-lg harga">Rp.<?php echo $rowDetailBarang['harga'] ?></a>
                                                    </h5>
                                                    <p class="card-text"><?php echo $rowDetailBarang['note'] ?></p>
                                                    <div class="card-footer d-flex justify-content-between">
                                                        <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                                                            <a href="#" class="btn-sm btn-primary btnDetail">
                                                                <i class='bx bx-cart-add'></i>
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="#" class="btn-sm btn-primary btnDetail">
                                                                Beli Barang Ini
                                                            <?php endif ?>
                                                            </a>
                                                            <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                                                                <a href="add-barang.php?edit=<?php echo $rowDetailBarang['id'] ?>" class="btn-sm btn-success"><i class='bx bx-edit'></i></a>
                                                                <a href="display.php?delete=<?php echo $rowDetailBarang['id'] ?>" onclick="return confirm('Apa anda yakin ingin menghapus ?')" class="btn-sm btn-danger btnDetail"><i class='bx bx-trash'></i></a>
                                                            <?php endif; ?>
                                                    </div>
                                                    <div class="d-none deskripsi">
                                                        <p class="text-justify">
                                                            <?php echo $rowDetailBarang['deskripsi'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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
    <!-- javascript -->

    <?php include '../layout/js.php' ?>

    <!-- Modal-konten -->
    <button type="button" class="btn btn-primary d-none btnModal" data-bs-toggle="modal" data-bs-target="#exampleModal">Launch demo modal</button>


    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title btn-sm btn-success modalTitle" id="detailModalLabel">Detail Barang</h5>
                </div>
                <div class="modal-body row">
                    <img id="modalImage" src="" class="col-md-6 col-12" />
                    <div class="col-md-6 col-12">
                        <div id="modalDescription" class="modalDescription card-header mb-3"></div>
                        <div class="d-md-flex justify-content-between">
                            <a href="transaksi.php" class="btn btn-sm btn-warning d-block btnBeli">Beli barang </a>
                            <span id="modalPrice" class="ms-auto text-danger fw-bold d-block text-center modalPrice"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript-konten -->
    <script>
        document.querySelectorAll('.btnDetail').forEach((item) => {
            item.addEventListener('click', (e) => {
                // Cari elemen 'card' terdekat dari tombol yang diklik
                let parent = e.target.closest('.card');

                // Ambil data dari elemen 
                let gambar = parent.querySelector('.img-fluid').src;
                let harga = parent.querySelector('.harga').textContent.trim();
                let judul = parent.querySelector('.btn-sm.shadow-lg').textContent.trim();
                let deskripsi = parent.querySelector('.deskripsi p').innerHTML.trim();

                // Buka modal 
                let modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();

                // Update konten modal
                document.querySelector('.modalTitle').innerHTML = judul;
                let imageElement = document.querySelector('#modalImage');
                imageElement.src = gambar;
                imageElement.classList.add('w-50');
                imageElement.classList.add('h-50');
                imageElement.classList.add('rounded');
                document.querySelector('.modalDescription').innerHTML = deskripsi;
                document.querySelector('.modalPrice').innerHTML = harga;

            });
        });
    </script>

</body>

</html>