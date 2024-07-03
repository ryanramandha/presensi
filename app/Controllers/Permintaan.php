<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PermintaanModel;

class Permintaan extends BaseController
{
    public function __construct()
    {
        helper('form');
        $this->permintaan = new PermintaanModel();
        $this->pegawai = new PegawaiModel();
        $this->validation = service('validation');
    }

    public function index()
    {
        if (session()->get('level') == 'Kepala Cabang') {
            $data['permintaan'] = $this->permintaan
                ->select('permintaan.*, pegawai.nama_pegawai')
                ->join('pegawai', 'pegawai.id_pegawai = permintaan.id_pegawai')
                ->orderBy('id_permintaan', 'desc')->findAll();
        } else {
            $pegawai = $this->pegawai->where('id_pengguna', session()->get('id_pengguna'))->first();
            $data['permintaan'] = $this->permintaan
                ->select('permintaan.*, pegawai.nama_pegawai')
                ->join('pegawai', 'pegawai.id_pegawai = permintaan.id_pegawai')
                ->where('permintaan.id_pegawai', $pegawai['id_pegawai'])
                ->orderBy('id_permintaan', 'desc')->findAll();
        }

        return view('permintaan/data', $data);
    }

    public function tambah()
    {
        if ($this->request->is('post')) {
            $this->validation->setRules([
                'tgl_permintaan' => ['label' => 'Tanggal Permintaan', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'jenis' => ['label' => 'Jenis', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'pesan' => ['label' => 'Pesan', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $pegawai = $this->pegawai->where('id_pengguna', session()->get('id_pengguna'))->first();

            $params = [
                'id_pegawai' => $pegawai['id_pegawai'],
                'tgl_permintaan' => $this->request->getPost('tgl_permintaan'),
                'jenis' => $this->request->getPost('jenis'),
                'pesan' => $this->request->getPost('pesan'),
            ];

            $result = $this->permintaan->insert($params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil disimpan');
            } else {
                session()->setFlashdata('error', 'Data gagal disimpan');
            }

            return redirect('permintaan');
        }

        return view('permintaan/tambah');
    }

    public function ubah($id)
    {
        $data['permintaan'] = $this->permintaan
            ->select('permintaan.*, pegawai.nama_pegawai, pegawai.jabatan')
            ->join('pegawai', 'pegawai.id_pegawai = permintaan.id_pegawai')
            ->find($id);

        if ($this->request->is('post')) {
            $this->validation->setRules([
                'status' => ['label' => 'Status', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'status' => $this->request->getPost('status'),
                'keterangan' => $this->request->getPost('keterangan'),
            ];

            $result = $this->permintaan->update($id, $params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Data gagal diubah');
            }

            return redirect('permintaan');
        }

        return view('permintaan/ubah', $data);
    }

    public function hapus($id)
    {
        $result = $this->permintaan->delete($id);

        if ($result) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data gagal dihapus');
        }

        return redirect('permintaan');
    }
}
