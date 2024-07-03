<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\PenggunaModel;

class Pegawai extends BaseController
{
    // deklarasi variabel
    protected $pegawai;
    protected $validation;
    protected $pengguna;

    // fungsi construct untuk inisialisasi model yang digunakan
    public function __construct()
    {
        // helper form
        helper('form');
        // inisialisasi model yang digunakan
        $this->pegawai = new PegawaiModel();
        $this->pengguna = new PenggunaModel();
        // inisialisasi form validation
        $this->validation = service('validation');
    }

    public function index()
    {
        // ambil data pegawai
        $data['pegawai'] = $this->pegawai
            ->select('pegawai.*, pengguna.username')
            ->join('pengguna', 'pengguna.id_pengguna = pegawai.id_pengguna')
            ->findAll();

        return view('pegawai/data', $data);
    }

    public function tambah()
    {
        // jika request adalah post
        if ($this->request->is('post')) {
            // set rules form validation
            $this->validation->setRules([
                'kode_pegawai' => ['label' => 'Kode Pegawai', 'rules' => 'required|is_unique[pegawai.kode_pegawai]', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah ada']],
                'nama_pegawai' => ['label' => 'Nama Pegawai', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'alamat' => ['label' => 'Alamat', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'no_hp' => ['label' => 'No HP', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'jabatan' => ['label' => 'Jabatan', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'username' => ['label' => 'Username', 'rules' => 'required|is_unique[pengguna.username]', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah terdaftar']],
                'password' => ['label' => 'Password', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']]
            ]);

            // cek jika tidak valid
            if ($this->validation->withRequest($this->request)->run() == false) {
                // redirect ke halaman sebelumnya dengan mengirimkan inputan sebelumnya
                return redirect()->back()->withInput();
            }

            // parameter yang akan diinsert
            $params = [
                'nama_lengkap' => $this->request->getPost('nama_pegawai'),
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'level' => 'Pegawai',
            ];

            // insert data pengguna dan ambil id_pengguna
            $id_pengguna = $this->pengguna->insert($params);

            // parameter yang akan diinsert ke tabel pegawai
            $params = [
                'kode_pegawai' => $this->request->getPost('kode_pegawai'),
                'nama_pegawai' => $this->request->getPost('nama_pegawai'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'jabatan' => $this->request->getPost('jabatan'),
                'id_pengguna' => $id_pengguna,
            ];

            // insert data pegawai
            $result = $this->pegawai->insert($params);

            // cek jika proses insert berhasil
            if ($result) {
                // set pesan sukses
                session()->setFlashdata('success', 'Data berhasil disimpan');
            } else {
                // set pesan error
                session()->setFlashdata('error', 'Data gagal disimpan');
            }

            // redirect ke halaman pegawai
            return redirect('pegawai');
        }

        // tampilkan halaman tambah
        return view('pegawai/tambah');
    }

    // fungsi untuk mengubah data pegawai
    public function ubah($id)
    {
        // ambil data pegawai berdasarkan id
        $data['pegawai'] = $this->pegawai
            ->select('pegawai.*, pengguna.username')
            ->join('pengguna', 'pengguna.id_pengguna = pegawai.id_pengguna')
            ->find($id);

        // jika request adalah post
        if ($this->request->is('post')) {
            // set rules form validation
            $this->validation->setRules([
                'kode_pegawai' => ['label' => 'Kode Pegawai', 'rules' => 'required|is_unique[pegawai.kode_pegawai,id_pegawai,' . $id . ']', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah ada']],
                'nama_pegawai' => ['label' => 'Nama Pegawai', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'alamat' => ['label' => 'Alamat', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'no_hp' => ['label' => 'No HP', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'jabatan' => ['label' => 'Jabatan', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'username' => ['label' => 'Username', 'rules' => 'required|is_unique[pengguna.username,id_pengguna,' . $data['pegawai']['id_pengguna'] . ']', 'errors' => ['required' => '{field} harus diisi', 'is_unique' => '{field} sudah terdaftar']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'nama_lengkap' => $this->request->getPost('nama_pegawai'),
                'username' => $this->request->getPost('username'),
            ];

            $this->pengguna->update($data['pegawai']['id_pengguna'], $params);

            $params = [
                'kode_pegawai' => $this->request->getPost('kode_pegawai'),
                'nama_pegawai' => $this->request->getPost('nama_pegawai'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'jabatan' => $this->request->getPost('jabatan'),
            ];

            $result = $this->pegawai->update($id, $params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Data gagal diubah');
            }

            return redirect('pegawai');
        }

        return view('pegawai/ubah', $data);
    }

    // fungsi untuk menghapus data pegawai
    public function hapus($id)
    {
        $pegawai = $this->pegawai->find($id);
        $result = $this->pengguna->delete($pegawai['id_pengguna']);

        if ($result) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data gagal dihapus');
        }

        return redirect('pegawai');
    }
}
