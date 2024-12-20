<?php

include '../database/koneksi.php';
session_start();
//query tambah level
if (isset($_POST['tambah'])) {
    $nama_level = $_POST['nama_level'];

    $query = mysqli_query($koneksi, "INSERT INTO level (nama_level) values ('$nama_level')");
    if ($query) {
        header("Location: level.php");
    } else {
        echo "Gagal menambah data";
        echo mysqli_error($koneksi);
    }
}

//query edit level
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEditLevel = mysqli_query($koneksi, "SELECT * FROM level WHERE id ='$id'");
$rowEditLevel = mysqli_fetch_assoc($queryEditLevel);

if (isset($_POST['edit'])) {
    $nama_level = $_POST['nama_level'];

    $query = mysqli_query($koneksi, "UPDATE level SET nama_level = '$nama_level' WHERE id = '$id'");
    if ($query) {
        header("Location: level.php");
    } else {
        echo "Gagal mengedit data";
        echo mysqli_error($koneksi);
    }
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
                        <div class="col-md-6 offset-3" style="height: 100vh;">
                            <div class="card mt-5">
                                <div class="card-header"><?php echo (isset($_GET['edit']) ? 'edit' : 'tambah') ?> Level</div>
                                <div class="card-body">
                                    <form action="" method="post">
                                        <div class="my-3">
                                            <label for="">Nama Level</label>
                                            <input type="text" name="nama_level" class="form-control" id="nama_level" value="<?php echo (isset($_GET['edit']) ? $rowEditLevel['nama_level'] : '') ?>" required>
                                            <button type="submit" class="mt-3 btn-primary" name="<?php echo (isset($_GET['edit']) ? 'edit' : 'tambah') ?>">Tambah</button>
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