<?php

namespace App\Validation;

use App\Models\AbsensiModel;

class CheckOffLimit
{
    public function check_off_limit($value, string $params, array $data): bool
    {
        // Check if selected keterangan is 'off'
        if ($value !== 'Off') {
            return true;
        }

        // Fetching data from the database
        $model = new AbsensiModel();
        $count = $model->where('tanggal', $data[$params])
            ->where('keterangan', 'Off')
            ->countAllResults();

        return $count < 2;
    }
}
