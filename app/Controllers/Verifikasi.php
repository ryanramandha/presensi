<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PresensiModel;

class Verifikasi extends BaseController
{
    protected $presensi;

    public function __construct()
    {
        $this->presensi = new PresensiModel();
    }

    public function index()
    {
        $data['presensi'] = $this->presensi
            ->select('presensi.*, pegawai.kode_pegawai, pegawai.nama_pegawai')
            ->join('pegawai', 'pegawai.id_pegawai = presensi.id_pegawai')
            ->where('status', 0)
            ->findAll();

        return view('verifikasi/index', $data);
    }

    public function terima($id)
    {
        $this->presensi->update($id, ['status' => 1]);

        session()->setFlashdata('success', 'Data presensi berhasil diterima');

        return redirect()->to(route_to('verifikasi'));
    }

    public function tolak($id)
    {
        $presensi = $this->presensi->find($id);

        if ($presensi['foto']) {
            unlink('uploads/' . $presensi['foto']);
        }

        $this->presensi->delete($id);

        session()->setFlashdata('success', 'Data presensi berhasil ditolak');

        return redirect()->to(route_to('verifikasi'));
    }
}
