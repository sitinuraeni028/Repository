<?php
session_start();
include 'config.php';
include 'authcheck.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    //menampilkan data berdasarkan ID
    $data = mysqli_query($dbconnect, "SELECT * FROM barang where id_barang='$id'");
    $data = mysqli_fetch_assoc($data);
}

if (isset($_POST['update'])) {
    $id = $_GET['id'];

    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    //menyimpan ke database;
    mysqli_query($dbconnect, "UPDATE barang SET nama='$nama', harga='$harga', jumlah_stok='$jumlah'where id_barang='$id' ");

    //mengalihkan halaman ke list barang
    header("location:barang.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>perbaruhi Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="height: 100vh;
background: rgb(26,138,133);
background: linear-gradient(180deg, rgba(26,138,133,1) 0%, rgba(27,106,151,1) 0%, rgba(27,109,153,1) 0%, rgba(27,114,157,1) 0%, rgba(27,86,135,0.5746673669467788) 0%, rgba(27,95,142,1) 0%, rgba(35,175,214,1) 0%, rgba(41,207,194,1) 0%, rgba(27,101,147,1) 0%, rgba(28,195,222,1) 0%, rgba(42,115,223,0.6951155462184874) 0%, rgba(28,60,119,1) 0%, rgba(25,100,146,1) 0%, rgba(47,134,132,1) 0%, rgba(16,216,223,1) 0%, rgba(65,105,113,1) 0%, rgba(65,105,113,1) 0%, rgba(65,105,113,1) 0%, rgba(36,75,145,1) 0%, rgba(41,69,103,1) 0%, rgba(34,90,148,1) 0%, rgba(41,69,103,1) 0%, rgba(43,63,89,1) 0%, rgba(43,63,88,1) 0%, rgba(18,71,140,1) 0%, rgba(116,169,236,1) 0%, rgba(70,178,224,1) 0%, rgba(43,62,87,0.4458158263305322) 99%, rgba(65,105,113,1) 99%, rgba(115,168,234,1) 100%, rgba(41,68,102,1) 100%, rgba(26,162,160,1) 100%, rgba(37,102,119,1) 100%, rgba(38,94,113,1) 100%, rgba(30,159,165,1) 100%, rgba(92,168,172,0.9220063025210083) 100%, rgba(29,160,164,1) 100%, rgba(31,148,156,1) 100%, rgba(37,102,119,1) 100%, rgba(63,130,205,1) 100%, rgba(63,130,205,1) 100%, rgba(21,113,181,1) 100%, rgba(107,145,157,0.8547794117647058) 100%, rgba(8,237,246,1) 100%, rgba(49,129,152,1) 100%, rgba(27,106,139,0) 100%, rgba(39,192,185,0.6110819327731092) 100%);
">

    <body>
        <div class="container">
            <h1>Barang Edit</h1>
            <form method="post">
                <div class="form-group">
                    <label>Nama barang</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama barang" value="<?= $data['nama'] ?>">
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" placeholder="Harga barang" value="<?= $data['harga'] ?>">
                </div>
                <div class="form-group">
                    <label>Jumlah Stock</label>
                    <input type="text" name="jumlah" class="form-control" placeholder="Jumlah Stock" value="<?= $data['jumlah_stok'] ?>">
                </div>
                <input type="submit" name="update" value="perbaruhi" class="btn btn-primary">
                <a href="barang.php" class="btn btn-warning">kembali</a>
            </form>
        </div>
    </body>

</html>