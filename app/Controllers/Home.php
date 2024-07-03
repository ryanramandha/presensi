<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\PenggunaModel;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('level') == 'Pegawai') {
            return redirect()->to('presensi');
        }

        return view('home');
    }

    public function profil()
    {
        helper('form');
        $validation = service('validation');
        $pegawai = new PegawaiModel();
        $pengguna = new PenggunaModel();

        $data['pegawai'] = $pegawai->select('pegawai.*, pengguna.username')
            ->join('pengguna', 'pengguna.id_pengguna = pegawai.id_pengguna')
            ->where('pegawai.id_pengguna', session()->get('id_pengguna'))->first();

        if ($this->request->is('post')) {
            $validation->setRules([
                'nama_pegawai' => ['label' => 'Nama Pegawai', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'alamat' => ['label' => 'Alamat', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'no_hp' => ['label' => 'No HP', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'username' => ['label' => 'Username', 'rules' => 'required|is_unique[pengguna.username,id_pengguna,' . $data['pegawai']['id_pengguna'] . ']', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah terdaftar']],
            ]);

            if ($validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $result = $pegawai->update($data['pegawai']['id_pegawai'], [
                'nama_pegawai' => $this->request->getPost('nama_pegawai'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
            ]);

            $pengguna->update($data['pegawai']['id_pengguna'], [
                'nama_lengkap' => $this->request->getPost('nama_pegawai'),
                'username' => $this->request->getPost('username'),
            ]);

            if ($result) {
                session()->setFlashdata('success', 'Profil berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Profil gagal diubah');
            }

            return redirect('profil');
        }

        return view('profil', $data);
    }
}
