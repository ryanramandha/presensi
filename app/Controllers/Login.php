<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Login extends BaseController
{
    public function index()
    {
        // jika sudah login, maka redirect ke halaman home
        if (session()->has('logged_in')) {
            return redirect('home');
        }

        // tampilkan halaman login
        return view('login');
    }

    public function cek()
    {
        // cek jika request adalah post
        if ($this->request->is('post')) {
            $pengguna = new PenggunaModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // ambil data pengguna berdasarkan username
            $result = $pengguna->where('username', $username)->first();

            // cek jika data pengguna kosong, maka tampilkan pesan error
            if (empty($result)) {
                session()->setFlashdata('pesan', '<div class="alert alert-danger text-center" role="alert">User tidak terdaftar</div>');
                return redirect()->back()->withInput();
            }

            // cek jika password yang diinputkan sama dengan password yang ada di database
            if (password_verify($password, $result['password'])) {
                // buat session
                $session_data = array(
                    'id_pengguna' => $result['id_pengguna'],
                    'username' => $result['username'],
                    'nama_lengkap' => $result['nama_lengkap'],
                    'level' => $result['level'],
                    'logged_in' => TRUE
                );

                // set session
                session()->set($session_data);
                // redirect ke halaman home
                return redirect('home');
            }

            // jika password salah, maka tampilkan pesan error
            session()->setFlashdata('pesan', '<div class="alert alert-danger text-center" role="alert">Username dan Password salah</div>');
            return redirect()->back()->withInput();
        }

        // jika bukan request post, maka redirect ke halaman login
        return redirect('login');
    }

    public function logout()
    {
        // hapus session
        session()->destroy();
        // redirect ke halaman login
        return redirect('login');
    }
}
