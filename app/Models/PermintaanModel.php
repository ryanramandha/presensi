<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanModel extends Model
{
    protected $table            = 'permintaan';
    protected $primaryKey       = 'id_permintaan';
    protected $allowedFields    = ['id_pegawai', 'tgl_permintaan', 'jenis', 'pesan', 'status', 'keterangan'];
}
