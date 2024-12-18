<?php

include '../database/koneksi.php';
session_start();
// jika button simpan di tekan
if (isset($_POST['submit'])) {
    $user = $_POST['id_user'];
    $deskripsi = $_POST['deskripsi'];
    $catt = $_POST['catatan'];

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
            $insert = mysqli_query($koneksi, "INSERT INTO suggestion (id_user, deskripsi, catatan,foto) VALUES ('$user','$deskripsi','$catt','$nama_foto')");
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO suggestion (id_user, deskripsi, catatan) VALUES ('$user','$deskripsi','$catt')");
    }

    header("location: suggestion.php?tambah=berhasil");
}


$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM suggestion WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

// jika button edit di klik

if (isset($_POST['edit'])) {
    $user = $_POST['id_user'];
    $deskripsi = $_POST['deskripsi'];
    $catt = $_POST['catatan'];

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

            $update = mysqli_query($koneksi, "UPDATE suggestion SET 
             id_user = '$user',  
            deskripsi = '$deskripsi',  
            catatatan = '$catt', 
            foto = '$nama_foto'
        WHERE id = '$id'");
        }
    } else {
        $update = mysqli_query($koneksi, "UPDATE suggestion SET 
         id_user = '$user', 
        deskripsi = '$deskripsi',  
        catatatan = '$catt'
    WHERE id = '$id'");
    }
    print_r($update);
    die();
    // header("location:suggestion.php?ubah=berhasil");
}

$resultUser = mysqli_query($koneksi, "SELECT * FROM user");
$inputUser = mysqli_fetch_assoc($resultUser);

//Tampilkan data suggestions di browser
$resultSuggestion = mysqli_query($koneksi, "SELECT user.nama_lengkap, suggestion.* FROM suggestion LEFT JOIN user ON suggestion.id_user = user.id");
$rowData = mysqli_fetch_assoc($resultSuggestion);

$rowData = [];
while ($data = mysqli_fetch_assoc($resultSuggestion)) {
    $rowData[] = $data;
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
                    <?php if (isset($_GET['tambah']) or isset($_GET['edit'])) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="btn btn-primary"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Saran & Komentar</h5>
                                        <h4 onclick="window.history.back();">
                                            <a href="" class="btn-sm btn-secondary"><i class='bx bx-left-arrow-alt'></i></a>
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
                                                    <label for="" class="form-label">Nama Anda</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        placeholder="<?php echo $inputUser['nama_lengkap'] ?>"
                                                        value="<?php echo isset($_GET['edit']) ? isset($_SESSION['NamaPengguna']) : '' ?>">
                                                    <input type="hidden" name="id_user" value="<?php echo $inputUser['id'] ?>">
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <label for="" class="form-label">Silahkan Tulis Saran Dan komentar Anda</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="deskripsi"
                                                        placeholder="Masukkan Komentar disini"
                                                        required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['deskripsi'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <label for="" class="form-label">Masukan Catatan</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="catatan"
                                                        placeholder="Masukkan keterangan disini"
                                                        required
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['catatan'] : '' ?>">
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <label for="" class="form-label">Foto Barang</label>
                                                    <input type="file"
                                                        class="form-control mb-2"
                                                        name="foto"
                                                        placeholder="Masukkan deskripsi barang disini"
                                                        value="<?php echo isset($_GET['edit']) ? $rowEdit['foto'] : '' ?>">
                                                    <?php if (isset($_GET['edit'])) : ?>
                                                        <img src="../upload/<?php echo $rowEdit['foto'] ?>" alt="" class="card" width="100" height="100">
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <button class="btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'submit' ?>" type="submit">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <h1 class="h3 mb-1 text-gray-800">Border Utilities</h1>
                        <a href="suggestion.php?tambah=" class="btn btn-primary mb-3">Tambah</a>
                        <!-- <p class="mb-4">Bootstrap's default utility classes can be found on the official <a
                                href="../https://getbootstrap.com/docs">Bootstrap Documentation</a> page. The custom utilities
                            below were created to extend this theme past the default utility classes built into Bootstrap's
                            framework.</p> -->

                        <!-- Content Row -->
                        <div class="row">

                            <!-- Border Left Utilities -->
                            <div class="col-lg-6">
                                <?php foreach ($rowData as $value) : ?>
                                    <div class="card mb-4 py-3 border-left-info">
                                        <div class="card-hedaer">
                                            <img src="../upload/<?php echo $value['foto'] ?> " width="50" height="50" class="rounded-circle mx-3" alt="">
                                        </div>
                                        <div class="card-body">
                                            <?php echo $value['deskripsi'] ?>
                                            <p></p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="suggestion.php?edit=<?php echo $value['id'] ?>" class="btn-sm btn-primary me-auto">edit</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="card mb-4 py-3 border-left-info">
                                    <div class="card-body">
                                        .border-left-info
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-left-warning">
                                    <div class="card-body">
                                        .border-left-warning
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-left-danger">
                                    <div class="card-body">
                                        .border-left-danger
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-left-dark">
                                    <div class="card-body">
                                        .border-left-dark
                                    </div>
                                </div>

                            </div>

                            <!-- Border Bottom Utilities -->
                            <div class="col-lg-6">

                                <div class="card mb-4 py-3 border-bottom-primary">
                                    <div class="card-body">
                                        .border-bottom-primary
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-bottom-secondary">
                                    <div class="card-body">
                                        .border-bottom-secondary
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-bottom-success">
                                    <div class="card-body">
                                        .border-bottom-success
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-bottom-info">
                                    <div class="card-body">
                                        .border-bottom-info
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-bottom-warning">
                                    <div class="card-body">
                                        .border-bottom-warning
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-bottom-danger">
                                    <div class="card-body">
                                        .border-bottom-danger
                                    </div>
                                </div>

                                <div class="card mb-4 py-3 border-bottom-dark">
                                    <div class="card-body">
                                        .border-bottom-dark
                                    </div>
                                </div>

                            </div>

                        <?php endif; ?>
                        </div>

                </div>
                <!-- /.container-fluid -->

                <?php include '../layout/footer.php' ?>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="../#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Logout Modal-->
    <?php include '../layout/logout-modal.php' ?>

    <!-- Js-->
    <?php include '../layout/js.php' ?>

</body>

</html>