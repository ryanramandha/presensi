<?php
require '../vendor/autoload.php';

use Carbon\Carbon;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak History Absensi</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        th {
            height: 30px;
            text-align: center;
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

        thead {
            background: lightgray;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 class="center">LAPORAN DATA ABSENSI</h2>
    <h4 class="center">PERIODE <?= strtoupper(Carbon::create()->day(1)->month($bulan)->locale('id')->isoFormat('MMMM')) . ' ' . $tahun ?></h4>
    <hr>
    <table class="table-no-border">
        <tr>
            <td width="80">Kode Pegawai</td>
            <td>: <?= $pegawai['kode_pegawai'] ?></td>
        </tr>
        <tr>
            <td>Nama Pegawai</td>
            <td>: <?= $pegawai['nama_pegawai'] ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: <?= $pegawai['jabatan'] ?></td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0; ?>
            <?php foreach ($absensi as $row) : ?>
                <tr>
                    <td class="center"><?= ++$no ?></td>
                    <td><?= Carbon::parse($row['tanggal'])->locale('id')->isoFormat('dddd, Do MMMM YYYY') ?></td>
                    <td class="center"><?= $row['keterangan'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>