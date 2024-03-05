<?php

session_start();
include 'config.php';
include "authcheckkasir.php";

$barang = mysqli_query($dbconnect, "SELECT *FROM barang");
// print_r($_SESSION);

$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += (int)$value['harga'] * (int)$value['qty'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body style="height: 100vh;
background: rgb(26,138,133);
background: linear-gradient(180deg, rgba(26,138,133,1) 0%, rgba(27,106,151,1) 0%, rgba(27,109,153,1) 0%, rgba(27,114,157,1) 0%, rgba(27,86,135,0.5746673669467788) 0%, rgba(27,95,142,1) 0%, rgba(35,175,214,1) 0%, rgba(41,207,194,1) 0%, rgba(27,101,147,1) 0%, rgba(28,195,222,1) 0%, rgba(42,115,223,0.6951155462184874) 0%, rgba(28,60,119,1) 0%, rgba(25,100,146,1) 0%, rgba(47,134,132,1) 0%, rgba(16,216,223,1) 0%, rgba(65,105,113,1) 0%, rgba(65,105,113,1) 0%, rgba(65,105,113,1) 0%, rgba(36,75,145,1) 0%, rgba(41,69,103,1) 0%, rgba(34,90,148,1) 0%, rgba(41,69,103,1) 0%, rgba(43,63,89,1) 0%, rgba(43,63,88,1) 0%, rgba(18,71,140,1) 0%, rgba(116,169,236,1) 0%, rgba(70,178,224,1) 0%, rgba(43,62,87,0.4458158263305322) 99%, rgba(65,105,113,1) 99%, rgba(115,168,234,1) 100%, rgba(41,68,102,1) 100%, rgba(26,162,160,1) 100%, rgba(37,102,119,1) 100%, rgba(38,94,113,1) 100%, rgba(30,159,165,1) 100%, rgba(92,168,172,0.9220063025210083) 100%, rgba(29,160,164,1) 100%, rgba(31,148,156,1) 100%, rgba(37,102,119,1) 100%, rgba(63,130,205,1) 100%, rgba(63,130,205,1) 100%, rgba(21,113,181,1) 100%, rgba(107,145,157,0.8547794117647058) 100%, rgba(8,237,246,1) 100%, rgba(49,129,152,1) 100%, rgba(27,106,139,0) 100%, rgba(39,192,185,0.6110819327731092) 100%);
 ">
    <div class=" h-100" style="height:100;">


        <div class="container vh-screen">
            <div class="row">
                <div class="col-md-12">
                    <h1>Kasir</h1>
                    <h2> Hai <?= $_SESSION['nama'] ?></h2>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                    <a href=" keranjang_reset.php" class="btn btn-primary">Reset Keranjang</a>
                </div>
            </div>
            <hr>
            <div class=" row">
                <div class="col-md-8">
                    <form method="post" action="keranjang_act.php" class="form-inline">
                        <div class="input-group">
                            <select class="form-control" name="id_barang">
                                <option value="">Pilih Barang</option>
                                <?php while ($row = mysqli_fetch_array($barang)) { ?>
                                    <option value="<?= $row['id_barang'] ?>"><?= $row['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="number" name="qty" class="form-control" placeholder="Jumlah">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Tambah</button>
                            </span>
                        </div>
                    </form>
                    <br>
                    <form method="post" action="keranjang_update.php">
                        <table class="table table-bordered bg-white">
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub Total</th>
                                <th></th>
                            </tr>
                            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                <tr>
                                    <td><?= $value['nama'] ?></td>
                                    <td align="right"><?= number_format($value['harga']) ?></td>
                                    <td class="col-md-2"><input type="number" name="qty[]" value="<?= $value['qty'] ?>" class="form-control"></td>
                                    <td align="right"><?= number_format((int)$value['qty'] * (int)$value['harga']) ?></td>

                                    <td><a href="Keranjang_hapus.php?id=<?= $value['id'] ?>" class="btn btn-danger">
                                            <i class="bi bi-x"></i></a></td>

                                </tr>
                            <?php } ?>
                        </table>
                        <button type="submit" class="btn btn-success">Perbaruhi</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <h3>Total Rp. <?= number_format($sum) ?></h3>
                    <form action="transaksi_act.php" method="post">
                        <input type="hidden" name="total" value="<?= $sum ?>">
                        <div class="form-group">
                            <label>Bayar</label>
                            <input type="text" id="bayar" name="bayar" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Selesai</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // inisialisasi inputan 
        var bayar = document.getElementById('bayar');

        bayar.addEventListener('keyup', function(e) {
            bayar.value = formatRupiah(this.value, 'Rp.');
            //harga = cleanRupiah(dengan_rupiah.value);
            //calculate(harga,service.value);

        });

        //generate dari inputan angka menjadi format rupiah

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').tosString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        //generate dari inputan rupiah menjadi angka

        function cleanRupiah(rupiah) {
            var clean = rupiah.replace(/\D/g, '');
            return clean;
            //console.log(clean);
        }
    </script>
</body>

</html>