<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id_presensi';
    protected $allowedFields    = ['tanggal', 'id_pegawai', 'jam_masuk', 'jam_pulang', 'status', 'foto'];
}
