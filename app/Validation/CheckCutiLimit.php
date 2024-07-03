<?php

namespace App\Validation;

use App\Models\AbsensiModel;
use App\Models\PengaturanModel;

class CheckCutiLimit
{
    public function check_cuti_limit($value, string $params, array $data): bool
    {
        // Check if selected keterangan is 'Cuti'
        if ($value !== 'Cuti') {
            return true;
        }

        $tahun = date('Y');

        // Fetching data from the database
        $model = new AbsensiModel();
        $cuti_terpakai = $model->where('id_pegawai', $data[$params])
            ->where('keterangan', 'Cuti')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

        $pengaturan = new PengaturanModel();
        $pengaturan = $pengaturan->where('nama', 'jatah_cuti')->first();
        $cuti_per_tahun = $pengaturan['isi'];

        return $cuti_terpakai < $cuti_per_tahun;
    }
}
