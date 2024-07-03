<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LiburModel;

class Libur extends BaseController
{
    protected $libur;
    protected $validation;

    public function __construct()
    {
        helper('form');
        $this->libur = new LiburModel();
        $this->validation = service('validation');
    }

    public function index()
    {
        $data['libur'] = $this->libur->findAll();

        return view('libur/data', $data);
    }

    public function tambah()
    {
        if ($this->request->is('post')) {
            $this->validation->setRules([
                'tgl_libur' => ['label' => 'Tanggal Libur', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'nama_libur' => ['label' => 'Nama Libur', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'tgl_libur' => $this->request->getPost('tgl_libur'),
                'nama_libur' => $this->request->getPost('nama_libur'),
            ];

            $result = $this->libur->insert($params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil disimpan');
            } else {
                session()->setFlashdata('error', 'Data gagal disimpan');
            }

            return redirect('libur');
        }

        return view('libur/tambah');
    }

    public function ubah($id)
    {
        $data['libur'] = $this->libur->find($id);

        if ($this->request->is('post')) {
            $this->validation->setRules([
                'tgl_libur' => ['label' => 'Tanggal Libur', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
                'nama_libur' => ['label' => 'Nama Libur', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi']],
            ]);

            if ($this->validation->withRequest($this->request)->run() == false) {
                return redirect()->back()->withInput();
            }

            $params = [
                'tgl_libur' => $this->request->getPost('tgl_libur'),
                'nama_libur' => $this->request->getPost('nama_libur'),
            ];

            $result = $this->libur->update($id, $params);

            if ($result) {
                session()->setFlashdata('success', 'Data berhasil diubah');
            } else {
                session()->setFlashdata('error', 'Data gagal diubah');
            }

            return redirect('libur');
        }

        return view('libur/ubah', $data);
    }

    public function hapus($id)
    {
        $result = $this->libur->delete($id);

        if ($result) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Data gagal dihapus');
        }

        return redirect('libur');
    }
}
