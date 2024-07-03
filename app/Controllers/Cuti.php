<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\PegawaiModel;
use App\Models\PengaturanModel;

class Cuti extends BaseController
{
    protected $pegawai;
    protected $absensi;

    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
        $this->absensi = new AbsensiModel();
    }

    public function index()
    {
        $pengaturan = new PengaturanModel();
        $pengaturan = $pengaturan->where('nama', 'jatah_cuti')->first();
        $cuti_per_tahun = $pengaturan['isi'];

        $data['tahun'] = $this->request->getGet('tahun') ?? date('Y');

        $pegawai = $this->pegawai->findAll();

        $cuti = [];
        foreach ($pegawai as $row) {
            $cuti_terpakai = $this->getCutiTerpakai($row['id_pegawai'], $data['tahun']);
            $sisa_cuti = $cuti_per_tahun - $cuti_terpakai;

            $cuti[] = [
                'nama_pegawai' => $row['nama_pegawai'],
                'cuti_terpakai' => $cuti_terpakai,
                'sisa_cuti' => $sisa_cuti,
            ];
        }

        $data['cuti'] = $cuti;

        return view('cuti/index', $data);
    }

    // fungsi untuk menghitung cuti terpakai
    public function getCutiTerpakai($id_pegawai, $tahun)
    {
        return $this->absensi->where('id_pegawai', $id_pegawai)
            ->where('YEAR(tanggal)', $tahun)
            ->where('keterangan', 'Cuti')
            ->countAllResults();
    }
}
