<?php
require '../vendor/autoload.php';

use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        th {
            height: 30px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        .table-no-border {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        .table-no-border,
        .table-no-border th,
        .table-no-border tr,
        .table-no-border td {
            border: none;
        }

        .table-no-border td {
            padding: 3px;
        }

        th,
        td {
            padding: 3px;
        }

        .center {
            text-align: center;
        }

        .no-margin {
            margin-top: 0;
            margin-bottom: 0;
        }

        .container {
            width: 100%;
        }

        .column {
            width: 50%;
            padding: 20px;
            float: left;
        }

        .signature p {
            text-align: center;
        }

        .signature p:first-child {
            margin-bottom: 50px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <p class="center no-margin">
        <img src="<?= $base64Image ?>" width="250" alt="Logo">
    </p>
    <h2 class="center no-margin">LAPORAN REKAP DATA PRESENSI</h2>
    <h4 class="center no-margin">PERIODE <?= strtoupper(Carbon::create()->day(1)->month($bulan)->locale('id')->isoFormat('MMMM')) . ' ' . $tahun ?></h4>
    <hr>
    <p>
        Kepada Yth.
        <br>Kepala Cabang bapak <?= $kepala_cabang ?>
        <br>PT JNT Express
    </p>
    <br>
    <table class="table-no-border">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Hadir</th>
                <th>Off</th>
                <th>Alfa</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Cuti</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($pegawai as $row) : ?>
                <tr>
                    <td class="center"><?= $no++ ?></td>
                    <td><?= $row['nama_pegawai'] ?></td>
                    <td class="center"><?= $row['hadir'] > 0 ? $row['hadir'] : '0' ?></td>
                    <td class="center"><?= $row['off'] > 0 ? $row['off'] : '0' ?></td>
                    <td class="center"><?= $row['alfa'] > 0 ? $row['alfa'] : '0' ?></td>
                    <td class="center"><?= $row['sakit'] > 0 ? $row['sakit'] : '0' ?></td>
                    <td class="center"><?= $row['izin'] > 0 ? $row['izin'] : '0' ?></td>
                    <td class="center"><?= $row['cuti'] > 0 ? $row['cuti'] : '0' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="container">
        <div class="column"></div>
        <div class="column signature">
            <p>Hormat Saya,</p>
            <p><?= $admin ?></p>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>