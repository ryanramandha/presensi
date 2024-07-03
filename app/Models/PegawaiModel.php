<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id_pegawai';
    protected $allowedFields    = ['kode_pegawai', 'nama_pegawai', 'alamat', 'no_hp', 'jabatan', 'id_pengguna'];
}
