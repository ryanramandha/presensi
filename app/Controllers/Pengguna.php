<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Pengguna extends BaseController
{
    protected $pengguna;
    protected $validation;

    public function __construct()
    {
        helper('form');
        $this->pengguna = new PenggunaModel();
        $this->validation = service('validation');
    }

    public function index()
    {
        $data['pengguna'] = $this->pengguna->findAll();

        return view('pengguna/data', $data);
    }

    public function tambah()
    {
        if ($this->request->is('post')) {
            $this->validation->setRules([
                'nama_lengkap' => ['label' => 'Nama Lengkap', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'username' => ['label' => 'Username', 'rules' => 'required|is_unique[pengguna.username]', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah terdaftar']],
                'password' => ['label' => 'Password', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'level' => ['label' => 'Level', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'level' => $this->request->getPost('level'),
            ];

            $result = $this->pengguna->insert($params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil disimpan');
            } else {
                session()->setFlashdata('error', 'Data gagal disimpan');
            }

            return redirect('pengguna');
        }

        return view('pengguna/tambah');
    }

    public function ubah($id)
    {
        $data['pengguna'] = $this->pengguna->find($id);

        if ($this->request->is('post')) {
            $this->validation->setRules([
                'nama_lengkap' => ['label' => 'Nama Lengkap', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'username' => ['label' => 'Username', 'rules' => 'required|is_unique[pengguna.username,id_pengguna,' . $id . ']', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah terdaftar']],
                'level' => ['label' => 'Level', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'username' => $this->request->getPost('username'),
                'level' => $this->request->getPost('level'),
            ];

            $result = $this->pengguna->update($id, $params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Data gagal diubah');
            }

            return redirect('pengguna');
        }

        return view('pengguna/ubah', $data);
    }

    public function hapus($id)
    {
        $result = $this->pengguna->delete($id);

        if ($result) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data gagal dihapus');
        }

        return redirect('pengguna');
    }

    public function password()
    {
        if ($this->request->is('post')) {
            $this->validation->setRules([
                'password_lama' => ['label' => 'Password Lama', 'rules' => 'required|passlama', 'errors' => ['required' => '{field} harus diisi', 'passlama' => '{field} salah']],
                'password' => ['label' => 'Password Baru', 'rules' => 'required|matches[password_confirmation]', 'errors' => ['required' => '{field} harus diisi', 'matches' => '{field} tidak sama dengan Ulangi Password Baru']],
                'password_confirmation' => ['label' => 'Ulangi Password Baru', 'rules' => 'required|matches[password]', 'errors' => ['required' => '{field} harus diisi', 'matches' => '{field} tidak sama dengan Password Baru']]
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ];

            $result = $this->pengguna->update(session()->get('id_pengguna'), $params);

            if ($result) {
                session()->setFlashdata('success', 'Password berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Password gagal diubah');
            }

            return redirect('password');
        }

        return view('password');
    }
}
