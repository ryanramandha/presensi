<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\LiburModel;
use App\Models\PegawaiModel;
use App\Models\PermintaanModel;
use App\Models\PresensiModel;
use Carbon\Carbon;
use claviska\SimpleImage;

class Presensi extends BaseController
{
    protected $presensi;
    protected $pegawai;

    public function __construct()
    {
        $this->presensi = new PresensiModel();
        $this->pegawai = new PegawaiModel();
    }

    public function index()
    {
        // ambil tanggal sekarang
        $tanggal = Carbon::now()->format('Y-m-d');
        // ambil jam sekarang
        $jam_sekarang = Carbon::now()->format('H:i:s');

        // ambil data pegawai berdasarkan id_pengguna
        $pegawai = $this->pegawai->where('id_pengguna', session()->get('id_pengguna'))->first();
        // ambil data presensi berdasarkan id_pegawai dan tanggal
        $presensi = $this->presensi->where('id_pegawai', $pegawai['id_pegawai'])
            ->where('tanggal', $tanggal)->first();

        $data['tanggal_hari_ini'] = Carbon::now()->locale('id')->isoFormat('dddd, Do MMMM YYYY');

        // cek jika jam masuk/pulang kosong, maka isi dengan teks kosong, jika tidak kosong, maka format jamnya dari data yang ada
        $data['jam_masuk'] = empty($presensi['jam_masuk']) ? '' : Carbon::parse($presensi['jam_masuk'])->format('H:i');
        $data['jam_pulang'] = empty($presensi['jam_pulang']) ? '' : Carbon::parse($presensi['jam_pulang'])->format('H:i');

        $libur = new LiburModel();
        $libur = $libur->findAll();
        $data['libur'] = in_array($tanggal, array_column($libur, 'tgl_libur'));

        $data['nama_libur'] = '';
        foreach ($libur as $item) {
            if ($item['tgl_libur'] == $tanggal) {
                $data['nama_libur'] = $item['nama_libur'];
                break;
            }
        }

        $permintaan = new PermintaanModel();
        $permintaan = $permintaan->where('id_pegawai', $pegawai['id_pegawai'])
            ->where('tgl_permintaan', $tanggal)
            ->where('status', 'Diterima')
            ->first();
        $data['cuti'] = $permintaan;

        $absensi = new AbsensiModel();
        $absensi = $absensi->where('id_pegawai', $pegawai['id_pegawai'])
            ->where('tanggal', $tanggal)
            ->first();
        if ($absensi) {
            $data['cuti'] = $absensi;
        }

        $data['foto'] = $presensi['foto'] ?? '';

        return view('presensi/index', $data);
    }

    // proses presensi saat scan qr code
    public function proses()
    {
        // cek jika request post
        if ($this->request->is('post')) {
            // ambil tanggal sekarang
            $tanggal = Carbon::now()->format('Y-m-d');
            // ambil jam sekarang
            $jam_sekarang = Carbon::now()->format('H:i:s');

            // ambil data pegawai berdasarkan id_pengguna
            $pegawai = $this->pegawai->where('id_pengguna', session()->get('id_pengguna'))->first();
            // ambil data presensi berdasarkan id_pegawai dan tanggal
            $presensi = $this->presensi->where('id_pegawai', $pegawai['id_pegawai'])
                ->where('tanggal', $tanggal)->first();

            // jika data presensi kosong, maka lakukan insert jam masuk
            // jika tidak kosong, maka lakukan update jam pulang
            if (empty($presensi)) {
                $this->presensi->insert([
                    'id_pegawai' => $pegawai['id_pegawai'],
                    'tanggal' => $tanggal,
                    'jam_masuk' => $jam_sekarang,
                    'status' => $pegawai['jabatan'] == 'Admin' ? 1 : 0,
                ]);

                // return response json success
                return $this->response->setJSON([
                    'success' => 'Presensi masuk berhasil dilakukan',
                    'redirect' => route_to('presensi'),
                ]);
            } else {
                $this->presensi->update($presensi['id_presensi'], [
                    'jam_pulang' => $jam_sekarang
                ]);

                // return response json success
                return $this->response->setJSON([
                    'success' => 'Presensi pulang berhasil dilakukan',
                    'redirect' => route_to('presensi'),
                ]);
            }
        }
    }

    public function foto()
    {
        // cek jika request post
        if ($this->request->is('post')) {
            $imageData = base64_decode($this->request->getPost('image'));

            $filename = 'photo_' . uniqid() . '.png';

            $filePath = './uploads/' . $filename;
            file_put_contents($filePath, $imageData);

            $image = new SimpleImage();
            $image->fromFile('uploads/' . $filename)
                ->bestFit(600, 600)
                ->toFile('uploads/' . $filename, 'image/png');

            // ambil data pegawai berdasarkan id_pengguna
            $pegawai = $this->pegawai->where('id_pengguna', session()->get('id_pengguna'))->first();
            // ambil data presensi berdasarkan id_pegawai dan tanggal
            $presensi = $this->presensi->where('id_pegawai', $pegawai['id_pegawai'])
                ->where('tanggal', date('Y-m-d'))->first();

            $params = [
                'foto' => $filename,
            ];
            $this->presensi->update($presensi['id_presensi'], $params);

            return $this->response->setJSON([
                'success' => 'Foto berhasil disimpan',
                'redirect' => route_to('presensi'),
            ]);
        }
    }
}
