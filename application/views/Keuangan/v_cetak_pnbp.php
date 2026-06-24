<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bukti Tanda Terima Pembayaran PNBP</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    margin:0;
    padding:0;
    color:#000;
    font-size:12px;
}

.page{
    width:210mm;
    margin:0 auto;
    padding:10mm;
    box-sizing:border-box;
}

.judul-halaman{
    text-align:center;
    font-weight:bold;
    margin-bottom:10px;
}

.kwitansi{
    border:2px solid #000;
    margin-bottom:15px;
}

.header{
    width:100%;
    border-collapse:collapse;
}

.header td{
    vertical-align:top;
}

.logo{
    width:90px;
    text-align:center;
}

.logo img{
    width:65px;
    margin-top:10px;
}

.kop{
    text-align:center;
    padding-top:5px;
}

.kop .l1{
    font-size:14px;
    font-weight:bold;
}

.kop .l2{
    font-size:12px;
    font-weight:bold;
    margin-top:3px;
}

.kop .alamat{
    font-size:10px;
    margin-top:5px;
}

.lembar{
    width:100px;
    text-align:center;
    padding:10px;
}

.lembar-box{
    border:1px dashed #666;
    padding:8px;
    font-size:11px;
}

.garis{
    border-top:2px solid #000;
}

.judul{
    text-align:center;
    font-size:16px;
    font-weight:bold;
    padding:15px 0;
}

.isi{
    width:100%;
    border-collapse:collapse;
}

.isi td{
    padding:8px 10px;
    vertical-align:top;
}

.kol-label{
    width:170px;
}

.kol-titik{
    width:20px;
}

.garis-input{
    border-bottom:2px solid #000;
    padding-bottom:3px;
}

.terbilang{
    font-style:italic;
    border-bottom:2px solid #000;
    display:block;
    padding-bottom:3px;
}

.spasi-untuk{
    height:120px;
}

.ttd{
    width:100%;
    margin-top:20px;
}

.ttd-kanan{
    width:320px;
    margin-left:auto;
    text-align:center;
}

.nama-ttd{
    margin-top:55px;
    font-weight:bold;
}

@media print{

    @page{
        size:A4;
        margin:8mm;
    }

    body{
        margin:0;
    }

    .page{
        width:auto;
        padding:0;
    }
}

</style>
</head>
<body>

<?php

$terbilang = "Sepuluh Ribu Rupiah";
$nominal   = "Rp10,000.00";

$nama1      = $nm_pemohon1;
$untuk1     = "PNBP ".$jns1." No. ".$no_surat1."";
$tanggal1   = "Muara Teweh, ". $tgl1."";
$petugas1   = $nm_ttd1;

$nama2      = $nm_pemohon2;
$untuk2     = "PNBP ".$jns2." No. ".$no_surat2."";
$tanggal2   = "Muara Teweh, ". $tgl2."";
$petugas2   = $nm_ttd2;

for($i=1;$i<=2;$i++):

$lembar = ($i==1) ? "Lembar untuk Pengadilan" : "Lembar untuk Pengadilan";

?>

<div class="page">

    <div class="judul-halaman">
        Bukti Tanda Terima Pembayaran PNBP
    </div>

    <div class="kwitansi">

        <table class="header">
            <tr>

                <td class="logo">
                    <img src="<?= base_url('assets/gambar/logo_putih.jpg') ?>">
					
                </td>

                <td class="kop">

                    <div class="l1">MAHKAMAH AGUNG REPUBLIK INDONESIA</div>

                    <div class="l1">
                        DIREKTORAT JENDERAL BADAN PERADILAN UMUM
                    </div>

                    <div class="l1">
                        PENGADILAN TINGGI PALANGKARAYA
                    </div>

                    <div class="l1">
                        PENGADILAN NEGERI MUARA TEWEH
                    </div>

                    <div class="alamat">
                        Jalan Yetro Sinseng Nomor 8 Lanjas Kecamatan Teweh Tengah
                        <br>
                        Muara Teweh, Barito Utara 73812
                        www.pn-muarateweh.go.id
                        pnmuarateweh1@gmail.com
                    </div>

                </td>

                <td class="lembar">
                    <div class="lembar-box">
                        <?= $lembar ?>
                    </div>
                </td>

            </tr>
        </table>

        <div class="garis"></div>

        <div class="judul">
            Tanda Terima Pembayaran PNBP
        </div>

        <table class="isi">

            <tr>
                <td class="kol-label">Telah diterima dari</td>
                <td class="kol-titik">:</td>
                <td>
                    <div class="garis-input">
                        <?= $nama ?>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="kol-label">Uang Sejumlah</td>
                <td class="kol-titik">:</td>
                <td>
                    <div class="garis-input">
                        <?= $nominal ?>
                    </div>

                    <span class="terbilang">
                        <?= $terbilang ?>
                    </span>
                </td>
            </tr>

            <tr>
                <td class="kol-label">Untuk</td>
                <td class="kol-titik">:</td>
                <td class="spasi-untuk">
                    <?= $untuk ?>
                </td>
            </tr>

        </table>

        <div class="ttd">
            <div class="ttd-kanan">

                <div><?= $tanggal ?></div>

                <div>
                    Petugas Kepaniteraan Hukum
                </div>

                <div class="nama-ttd">
                    (<?= $petugas ?>)
                </div>

            </div>
        </div>

    </div>

</div>

<?php endfor; ?>

</body>
</html>