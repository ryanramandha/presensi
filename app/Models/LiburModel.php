<?php

namespace App\Models;

use CodeIgniter\Model;

class LiburModel extends Model
{
    protected $table            = 'libur';
    protected $primaryKey       = 'id_libur';
    protected $allowedFields    = ['tgl_libur', 'nama_libur'];
}
