<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\PegawaiModel;

class Absensi extends BaseController
{
    protected $absensi;
    protected $pegawai;
    protected $validation;

    public function __construct()
    {
        helper('form');
        $this->absensi = new AbsensiModel();
        $this->pegawai = new PegawaiModel();
        $this->validation = service('validation');
    }

    public function index()
    {
        $data['absensi'] = $this->absensi
            ->select('absensi.*, pegawai.kode_pegawai, pegawai.nama_pegawai')
            ->join('pegawai', 'pegawai.id_pegawai = absensi.id_pegawai')
            ->orderBy('id_absensi', 'desc')->findAll();

        return view('absensi/data', $data);
    }

    public function tambah()
    {
        $data['pegawai'] = $this->pegawai->findAll();

        if ($this->request->is('post')) {
            $this->validation->setRules([
                'id_pegawai' => ['label' => 'Nama Pegawai', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'tanggal' => ['label' => 'Tanggal', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'keterangan' => [
                    'label' => 'Keterangan',
                    'rules' => 'required|check_off_limit[tanggal]|check_cuti_limit[id_pegawai]',
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'check_off_limit' => 'Pegawai Off pada tanggal tersebut sudah melebihi batas maksimal 2 orang',
                        'check_cuti_limit' => 'Jatah cuti untuk pegawai tersebut sudah habis'
                    ]
                ],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'tanggal' => $this->request->getPost('tanggal'),
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            $result = $this->absensi->insert($params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil disimpan');
            } else {
                session()->setFlashdata('error', 'Data gagal disimpan');
            }

            return redirect('absensi');
        }

        return view('absensi/tambah', $data);
    }

    public function ubah($id)
    {
        $data['absensi'] = $this->absensi->find($id);
        $data['pegawai'] = $this->pegawai->findAll();

        if ($this->request->is('post')) {
            $this->validation->setRules([
                'id_pegawai' => ['label' => 'Nama Pegawai', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'tanggal' => ['label' => 'Tanggal', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'keterangan' => ['label' => 'Keterangan', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'tanggal' => $this->request->getPost('tanggal'),
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            $result = $this->absensi->update($id, $params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Data gagal diubah');
            }

            return redirect('absensi');
        }

        return view('absensi/ubah', $data);
    }

    public function hapus($id)
    {
        $result = $this->absensi->delete($id);

        if ($result) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data gagal dihapus');
        }

        return redirect('absensi');
    }
}
