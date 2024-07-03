<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaturanModel;

class Pengaturan extends BaseController
{
    public function index()
    {
        helper('form');
        $validation = service('validation');

        $pengaturan = new PengaturanModel();
        $pengaturan = $pengaturan->where('nama', 'jatah_cuti')->first();

        if ($this->request->is('post')) {
            $validation->setRules([
                'jatah_cuti' => ['label' => 'Jatah Cuti per Tahun', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'isi' => $this->request->getPost('jatah_cuti'),
            ];

            $pengaturan = new PengaturanModel();
            $result = $pengaturan->update(1, $params);

            if ($result) {
                session()->setFlashdata('success', 'Pengaturan berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Pengaturan gagal diubah');
            }

            return redirect('pengaturan');
        }

        $data['pengaturan'] = $pengaturan;

        return view('pengaturan', $data);
    }
}
