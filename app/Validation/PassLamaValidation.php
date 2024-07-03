<?php

namespace App\Validation;

use App\Models\PenggunaModel;

class PassLamaValidation
{
    public function passlama($value)
    {
        $pengguna = new PenggunaModel();
        $result = $pengguna->find(session()->get('id_pengguna'));

        if (password_verify($value, $result['password'])) {
            return true;
        }

        return false;
    }
}
